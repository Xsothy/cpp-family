<?php

namespace App\Filament\Resources\FamilyMembers\Pages;

use App\Filament\Resources\FamilyMembers\FamilyMemberResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateFamilyMember extends CreateRecord
{
    protected static string $resource = FamilyMemberResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'សាលាកបត្រព័ត៌មានសមាជិក';
    }
}
