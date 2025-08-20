<?php

namespace App\Enums;

enum IdCardStatus: string
{
    case HAS = 'មាន';
    case NOT_YET = 'ពុំទាន់មាន';
    case LOST = 'បាត់';

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
