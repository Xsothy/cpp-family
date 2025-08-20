<?php

namespace App\Filament\Resources\SimpleFamilyMembers\Pages;

use App\Filament\Resources\SimpleFamilyMembers\SimpleFamilyMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSimpleFamilyMembers extends ListRecords
{
    protected static string $resource = SimpleFamilyMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
