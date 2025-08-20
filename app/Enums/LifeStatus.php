<?php

namespace App\Enums;

enum LifeStatus: string
{
    case ALIVE = 'រស់';
    case DEAD = 'ស្លាប់';

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
