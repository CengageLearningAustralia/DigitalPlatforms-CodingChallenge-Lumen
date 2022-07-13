<?php

namespace App\Http\Requests;


use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CreateSessionRequest
{
    public function validate(Request $request)
    {
        $rules = [
            'name'=>'required|string',
            'user_id'=>['required','exists:users,id'],
            'start_at'=>'required|date',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()){
            throw new HttpResponseException(response()->json(['errors'=>$validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY));
        }
        return $validator->validated();
    }
}
