<?php

namespace App\Http\Requests\User;

use CodersCantina\Request\ApiRequest;

class UpdateUserRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'firstname' => 'nullable|string',
            'lastname' => 'nullable|string',
        ];
    }
}
