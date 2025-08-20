<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case HEAD_OF_COMMUNE = 'head_of_commune';
    case SUB_OF_HEAD_OF_COMMUNE = 'sub_of_head_of_commune';
    case HEAD_OF_DISTRICT = 'head_of_district';
    case SUB_OF_DISTRICT = 'sub_of_district';

    public function getLabel(): string
    {
        return match($this) {
            self::ADMIN => 'Admin',
            self::HEAD_OF_COMMUNE => 'Head of Commune',
            self::SUB_OF_HEAD_OF_COMMUNE => 'Sub of Head of Commune',
            self::HEAD_OF_DISTRICT => 'Head of District',
            self::SUB_OF_DISTRICT => 'Sub of District',
        };
    }

    public static function getOptions(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->getLabel()];
        })->toArray();
    }
}
