<?php

namespace App\Enums;

enum WorkLocation: string
{
    case LOCAL = 'ក្នុងស្រុក';
    case OTHER_PROVINCE = 'ក្រៅស្រុក';
    case ABROAD = 'ក្រៅប្រទេស';

    public function getLabel(): string
    {
        return $this->value;
    }

    public static function getOptions(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->getLabel()];
        })->toArray();
    }
}
