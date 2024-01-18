<?php

namespace App\Http\Requests\User;

use CodersCantina\Request\ApiRequest;

class ChangePasswordRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed',
        ];
    }
}
