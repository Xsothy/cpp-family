<?php

namespace App\Models\Traits;

trait GetModelClass
{
    public static function getModelClass(): string
    {
        return static::class;
    }
}
