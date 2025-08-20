<?php

namespace App\Models;

use App\Models\Traits\GetModelClass;
use App\Models\Traits\GetTableName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperLocation
 */
class Location extends Model
{
    use GetModelClass, GetTableName, SoftDeletes;
    use HasFactory;

    protected $table = 'locations';

    protected $fillable = [
        'name',
        'name_kh',
        'code',
        'parent_id',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Location::class, 'parent_id');
    }

    public function scopeProvinces($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeDistricts($query, $provinceId)
    {
        return $query->where('parent_id', $provinceId);
    }

    public function scopeCommunes($query, $districtId)
    {
        return $query->where('parent_id', $districtId);
    }

    public function scopeVillages($query, $communeId)
    {
        return $query->where('parent_id', $communeId);
    }

    public function getFullNameAttribute(): string
    {
        return $this->name_kh ?: $this->name;
    }

    public function getHierarchyPathAttribute(): string
    {
        $path = collect();
        $current = $this;
        
        while ($current) {
            $path->prepend($current->getFullNameAttribute());
            $current = $current->parent;
        }
        
        return $path->implode(' > ');
    }
}
