<?php

namespace App\Models\Traits;

trait GetTableName
{
    public static function getTableName(): string
    {
        return (new static)->getTable();
    }
}
