<?php

namespace App\Services\Auth;

use Illuminate\Auth\EloquentUserProvider;

class HashidUserProvider extends EloquentUserProvider
{
    public function retrieveById($identifier)
    {
        $model = $this->createModel();

        return $model->resolveRouteBinding($identifier);
    }

}
