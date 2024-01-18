<?php

use Illuminate\Database\Eloquent\Model;

function ensure_array($input): array
{
    if (is_array($input)) {
        return $input;
    }

    return [$input];
}

function mapHashIdsForModel(array $ids, Model|string $model): array
{
    if (is_string($model)) {
        $model = new $model();
    }

    return array_map(
        static fn($id) => \Illuminate\Support\Arr::get($model->getHashidsFactory()->decode($id), 0),
        $ids ?: []
    );
}
