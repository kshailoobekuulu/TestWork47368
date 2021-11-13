<?php

namespace App\Services;

use App\Models\Todo;
use App\Validators\TodoValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TodoService {
    protected $todoValidator;

    public function __construct(TodoValidator $validator) {
        $this->todoValidator = $validator;
    }

    public function getTodos() {
        $onlyUnfinished = request()->get('hidecompleted');
        if ($onlyUnfinished) {
            return Todo::where('completed', false)
                ->orderBy('created_at')
                ->get();
        }

        return Todo::orderBy('created_at')->get();
    }

    public function getTodo($id) {
        return Todo::find($id);
    }

    public function createTodo(Request $request) {
       $this->todoValidator->validate($request);
        $todo = new Todo();
        $this->setValues($todo);
        $todo->save();
        return $todo;
    }

    public function updateTodo($request, $id) {
        $todo = $this->getTodo($id);
        if (!$todo) {
            return false;
        }
        $this->todoValidator->validate($request);
        $this->setValues($todo);
        $todo->save();
        return $todo;
    }

    public function deleteTodo($id) {
        $todo = $this->getTodo($id);
        if (!$todo) {
            return false;
        }
        $todo->delete();
        return true;
    }

    public function setValues(Todo $todo) {
        $todo->setTitle(request()->input('title'));
        $todo->setBody(request()->input('body'));
        $todo->setDueDate(request()->input('due_date'));
        $todo->setCompleted(request()->input('status') ?: false);
    }

    public function notFound() {
        return response()->json(["Todo not found"], JsonResponse::HTTP_NOT_FOUND);
    }
}
