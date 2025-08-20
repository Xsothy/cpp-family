<?php

namespace App\Enums;

enum Gender: string
{
    case MALE = 'ប្រុស';
    case FEMALE = 'ស្រី';

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
