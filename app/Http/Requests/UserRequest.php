<?php

namespace App\Http\Requests;

class UserRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'old_password'          => 'required|confirmed|min:8',
            'password'              => 'required|confirmed|min:8',
            'password_confirmation' => 'required|confirmed|min:8'
        ];
    }
}
