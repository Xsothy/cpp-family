<?php

namespace App\Enums;

enum Occupation: string
{
    case FARMER = 'កសិករ';
    case FISHERMAN = 'នេសាទ';
    case WORKER = 'កម្មករ';
    case COUNCIL_MEMBER = 'ក្រុមប្រឹក្សា';
    case VILLAGE_CHIEF = 'មេភូមិ';
    case DEPUTY_VILLAGE_CHIEF = 'អនុភូមិ';
    case COMMUNE_CHIEF = 'ចៅសង្កាត់';
    case TEACHER = 'គ្រូបង្រៀន';
    case DOCTOR = 'ពេទ្យ';
    case MILITARY = 'កងកម្លាំង';
    case CIVIL_SERVANT = 'មន្ត្រីរាជការ';

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
