<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\IdCardStatus;
use App\Enums\LifeStatus;
use App\Enums\Occupation;
use App\Enums\RelationshipType;
use App\Enums\WorkLocation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class FamilyMember extends Model
{
    protected $fillable = [
        'system_code',
        'family_code',
        'province_id',
        'district_id',
        'commune_id',
        'village_id',
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
        'relationship_type',
        'life_status',
        'related_to_member_id',
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
            'party_join_date' => 'date',
            'is_party_member' => 'boolean',
            'gender' => Gender::class,
            'id_card_status' => IdCardStatus::class,
            'relationship_type' => RelationshipType::class,
            'life_status' => LifeStatus::class,
            'work_location' => WorkLocation::class,
            'occupation' => Occupation::class,
        ];
    }

    // Location relationships
    public function province(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'province_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'district_id');
    }

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'commune_id');
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'village_id');
    }

    public function relatedToMember(): BelongsTo
    {
        return $this->belongsTo(FamilyMember::class, 'related_to_member_id');
    }

    public function relatedMembers(): HasMany
    {
        return $this->hasMany(FamilyMember::class, 'related_to_member_id');
    }

    // Helper methods
    public function getFullSystemCodeAttribute(): string
    {
        return $this->system_code;
    }

    protected function age(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->age_years && $this->age_months) {
                    return $this->age_years . ' ឦំាំ ' . $this->age_months . ' ខែ';
                }
                return $this->age_years ? $this->age_years . ' ឦំាំ' : null;
            }
        );
    }
}
