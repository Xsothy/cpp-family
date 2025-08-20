<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\IdCardStatus;
use App\Enums\LifeStatus;
use App\Enums\Occupation;
use App\Enums\WorkLocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SimpleFamilyMember extends Model
{
    protected $table = 'simple_family_members';

    protected $fillable = [
        'system_code',
        'full_name',
        'photo',
        'birth_date',
        'age_years',
        'age_months',
        'gender',
        'id_card_number',
        'id_card_status',
        'address',
        'phone_number',
        'father_status',
        'father_name',
        'father_photo',
        'father_birth_date',
        'father_age_years',
        'father_age_months',
        'father_system_code',
        'mother_status',
        'mother_name',
        'mother_photo',
        'mother_birth_date',
        'mother_age_years',
        'mother_age_months',
        'mother_system_code',
        'siblings',
        'children',
        'party_join_date',
        'party_member_number',
        'is_party_member',
        'work_location',
        'occupation',
        'work_address',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'father_birth_date' => 'date',
            'mother_birth_date' => 'date',
            'party_join_date' => 'date',
            'is_party_member' => 'boolean',
            'siblings' => 'array',
            'children' => 'array',
            'gender' => Gender::class,
            'id_card_status' => IdCardStatus::class,
            'father_status' => LifeStatus::class,
            'mother_status' => LifeStatus::class,
            'work_location' => WorkLocation::class,
            'occupation' => Occupation::class,
        ];
    }
}
