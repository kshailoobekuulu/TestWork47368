<?php

namespace App\Validators;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class TodoValidator
{
    public function validate($request) {
        $validator = Validator::make($request->all(), $this->getValidationRules(), [], $this->getFieldNames());
        if ($validator->fails()) {
            throw new HttpResponseException(
              response()->json(['errors' => $validator->getMessageBag()->getMessages()], JsonResponse::HTTP_BAD_REQUEST)
            );
        }
    }

    public function getFieldNames() {
        return [
            'title' => __('messages.Title'),
            'body' => __('messages.Body'),
            'due_date' => __('messages.DueDate'),
            'status' => __('messages.Status')
        ];
    }

    public function getValidationRules() {
        return [
            'title' => 'required|max:50',
            'body' => 'max:255',
            'due_date' => 'nullable|date_format:Y-m-d|after:yesterday',
            'status' => 'boolean'
        ];
    }
}
