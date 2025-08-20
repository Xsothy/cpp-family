<?php

namespace App\Filament\Resources\SimpleFamilyMembers;

use App\Filament\Resources\SimpleFamilyMembers\Pages\CreateSimpleFamilyMember;
use App\Filament\Resources\SimpleFamilyMembers\Pages\EditSimpleFamilyMember;
use App\Filament\Resources\SimpleFamilyMembers\Pages\ListSimpleFamilyMembers;
use App\Filament\Resources\SimpleFamilyMembers\Schemas\SimpleFamilyMemberForm;
use App\Filament\Resources\SimpleFamilyMembers\Tables\SimpleFamilyMembersTable;
use App\Models\FamilyMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SimpleFamilyMemberResource extends Resource
{
    protected static ?string $model = FamilyMember::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $recordTitleAttribute = 'full_name';

    protected static ?string $navigationLabel = 'សមាជិកគ្រួសារ';

    protected static ?string $modelLabel = 'សមាជិកគ្រួសារ';

    protected static ?string $pluralModelLabel = 'សមាជិកគ្រួសារ';

    public static function form(Schema $schema): Schema
    {
        return SimpleFamilyMemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SimpleFamilyMembersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSimpleFamilyMembers::route('/'),
            'create' => CreateSimpleFamilyMember::route('/create'),
            'edit' => EditSimpleFamilyMember::route('/{record}/edit'),
        ];
    }
}
