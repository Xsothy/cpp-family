<?php

namespace App\Enums;

enum RelationshipType: string
{
    case SELF = 'ខ្លួន';
    case FATHER = 'ឪពុក';
    case MOTHER = 'ម្តាយ';
    case SIBLING = 'បងប្អូន';
    case CHILD = 'កូន';
    case SPOUSE = 'ប្តីប្រពន្ធ';

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
