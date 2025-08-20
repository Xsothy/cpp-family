<?php

namespace App\Filament\Resources\FamilyMembers\Pages;

use App\Filament\Resources\FamilyMembers\FamilyMemberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditFamilyMember extends EditRecord
{
    protected static string $resource = FamilyMemberResource::class;


    public function getTitle(): string|Htmlable
    {
        return 'សាលាកបត្រព័ត៌មានសមាជិក';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
