<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\TodoService;
use Psy\Util\Json;

class TodosController extends Controller
{
    protected $todoService;

    public function __construct(TodoService $todoService) {
        $this->todoService = $todoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return $this->todoService->getTodos();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $todo = $this->todoService->createTodo($request);
        return response()->json(['todo' => $todo], JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  Todo  $todo
     * @return JsonResponse
     */
    public function show($id)
    {
        $todo = $this->todoService->getTodo($id);

        if (!$todo) {
            return $this->todoService->notFound();
        }

        return response()->json(['todo' => $todo]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $todo = $this->todoService->updateTodo($request, $id);
        if (!$todo) {
            return $this->todoService->notFound();
        }
        return response()->json(['todo' => $todo]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sucess = $this->todoService->deleteTodo($id);
        if (!$sucess) {
            $this->todoService->notFound();
        }
        return response(['success' => $sucess]);
    }
}
