<?php

namespace App\Filament\Resources\SimpleFamilyMembers\Pages;

use App\Filament\Resources\SimpleFamilyMembers\SimpleFamilyMemberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSimpleFamilyMember extends EditRecord
{
    protected static string $resource = SimpleFamilyMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
