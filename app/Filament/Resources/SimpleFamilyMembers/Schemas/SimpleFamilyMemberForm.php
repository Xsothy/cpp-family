<?php

namespace App\Filament\Resources\SimpleFamilyMembers\Schemas;

use App\Enums\Gender;
use App\Enums\IdCardStatus;
use App\Enums\LifeStatus;
use App\Enums\Occupation;
use App\Enums\WorkLocation;
use App\Services\SystemCodeService;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class SimpleFamilyMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('I. ព័ត៌មានសមាជិក')
                    ->schema([
                        TextInput::make('system_code')
                            ->label('លេខក្នុងប្រព័ន្ធ')
                            ->placeholder('07070202-0001-01')
                            ->required(),

                        TextInput::make('full_name')
                            ->label('នាម និងគោត្តនាម')
                            ->required(),

                        FileUpload::make('photo')
                            ->label('រូបថត')
                            ->image()
                            ->directory('family-photos'),

                        DatePicker::make('birth_date')
                            ->label('ថ្ងៃខែឆ្នាំកំណើត')
                            ->live()
                            ->afterStateUpdated(function (Set $set, $state) {
                                if ($state) {
                                    $age = SystemCodeService::calculateAge($state);
                                    $set('age_years', $age['years']);
                                    $set('age_months', $age['months']);
                                }
                            })
                            ->required(),

                        TextInput::make('age_years')
                            ->label('អាយុ (ឆ្នាំ)')
                            ->numeric()
                            ->disabled()
                            ->dehydrated()
                            ->suffix('ឆ្នាំ'),

                        TextInput::make('age_months')
                            ->label('អាយុ (ខែ)')
                            ->numeric()
                            ->disabled()
                            ->dehydrated()
                            ->suffix('ខែ'),

                        Select::make('gender')
                            ->label('ភេទ')
                            ->options(Gender::getOptions())
                            ->required(),

                        TextInput::make('id_card_number')
                            ->label('លេខអត្តសញ្ញាណបណ្ណ'),

                        Select::make('id_card_status')
                            ->label('សុពលភាព')
                            ->options(IdCardStatus::getOptions()),

                        Textarea::make('address')
                            ->label('អាសយដ្ឋាន')
                            ->rows(2),

                        TextInput::make('phone_number')
                            ->label('លេខទំនាក់ទំនង')
                            ->tel(),
                    ]),

                Section::make('II. ព័ត៌មានគ្រួសារ')
                    ->schema([
                        // Father Information
                        Section::make('ឪពុក')
                            ->schema([
                                Select::make('father_status')
                                    ->label('ស្ថានភាព')
                                    ->options(LifeStatus::getOptions()),

                                TextInput::make('father_name')
                                    ->label('នាម និងគោត្តនាម'),

                                FileUpload::make('father_photo')
                                    ->label('រូបថត')
                                    ->image()
                                    ->directory('family-photos'),

                                DatePicker::make('father_birth_date')
                                    ->label('ថ្ងៃខែឆ្នាំកំណើត')
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if ($state) {
                                            $age = SystemCodeService::calculateAge($state);
                                            $set('father_age_years', $age['years']);
                                            $set('father_age_months', $age['months']);
                                        }
                                    }),

                                TextInput::make('father_age_years')
                                    ->label('អាយុ (ឆ្នាំ)')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated()
                                    ->suffix('ឆ្នាំ'),

                                TextInput::make('father_age_months')
                                    ->label('អាយុ (ខែ)')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated()
                                    ->suffix('ខែ'),

                                TextInput::make('father_system_code')
                                    ->label('លេខក្នុងប្រព័ន្ធ')
                                    ->placeholder('07070202-0001-01'),
                            ]),

                        // Mother Information
                        Section::make('ម្តាយ')
                            ->schema([
                                Select::make('mother_status')
                                    ->label('ស្ថានភាព')
                                    ->options(LifeStatus::getOptions()),

                                TextInput::make('mother_name')
                                    ->label('នាម និងគោត្តនាម'),

                                FileUpload::make('mother_photo')
                                    ->label('រូបថត')
                                    ->image()
                                    ->directory('family-photos'),

                                DatePicker::make('mother_birth_date')
                                    ->label('ថ្ងៃខែឆ្នាំកំណើត')
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        if ($state) {
                                            $age = SystemCodeService::calculateAge($state);
                                            $set('mother_age_years', $age['years']);
                                            $set('mother_age_months', $age['months']);
                                        }
                                    }),

                                TextInput::make('mother_age_years')
                                    ->label('អាយុ (ឆ្នាំ)')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated()
                                    ->suffix('ឆ្នាំ'),

                                TextInput::make('mother_age_months')
                                    ->label('អាយុ (ខែ)')
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated()
                                    ->suffix('ខែ'),

                                TextInput::make('mother_system_code')
                                    ->label('លេខក្នុងប្រព័ន្ធ')
                                    ->placeholder('07070202-0001-01'),
                            ]),

                        // Siblings Information
                        Section::make('បងប្អូន')
                            ->schema([
                                Repeater::make('siblings')
                                    ->label('ចំនួនបងប្អូន')
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('នាម និងគោត្តនាម'),
                                        FileUpload::make('photo')
                                            ->label('រូបថត')
                                            ->image()
                                            ->directory('family-photos'),
                                        DatePicker::make('birth_date')
                                            ->label('ថ្ងៃខែឆ្នាំកំណើត'),
                                        TextInput::make('age_years')
                                            ->label('អាយុ (ឆ្នាំ)')
                                            ->numeric()
                                            ->suffix('ឆ្នាំ'),
                                        TextInput::make('age_months')
                                            ->label('អាយុ (ខែ)')
                                            ->numeric()
                                            ->suffix('ខែ'),
                                        Select::make('gender')
                                            ->label('ភេទ')
                                            ->options(Gender::getOptions()),
                                        TextInput::make('system_code')
                                            ->label('លេខក្នុងប្រព័ន្ធ'),
                                    ])
                                    ->collapsible()
                                    ->defaultItems(0),
                            ]),

                        // Children Information
                        Section::make('កូន')
                            ->schema([
                                Repeater::make('children')
                                    ->label('ចំនួនកូន')
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('នាម និងគោត្តនាម'),
                                        FileUpload::make('photo')
                                            ->label('រូបថត')
                                            ->image()
                                            ->directory('family-photos'),
                                        DatePicker::make('birth_date')
                                            ->label('ថ្ងៃខែឆ្នាំកំណើត'),
                                        TextInput::make('age_years')
                                            ->label('អាយុ (ឆ្នាំ)')
                                            ->numeric()
                                            ->suffix('ឆ្នាំ'),
                                        TextInput::make('age_months')
                                            ->label('អាយុ (ខែ)')
                                            ->numeric()
                                            ->suffix('ខែ'),
                                        Select::make('gender')
                                            ->label('ភេទ')
                                            ->options(Gender::getOptions()),
                                        TextInput::make('system_code')
                                            ->label('លេខក្នុងប្រព័ន្ធ'),
                                    ])
                                    ->collapsible()
                                    ->defaultItems(0),
                            ]),
                    ]),

                Section::make('III. ព័ត៌មានក្នុងបក្ស')
                    ->schema([
                        DatePicker::make('party_join_date')
                            ->label('កាលបរិច្ឆេទចូលជាសមាជិក'),

                        TextInput::make('party_member_number')
                            ->label('លេខសមាជិក'),

                        Toggle::make('is_party_member')
                            ->label('ជាសមាជិកបក្ស'),
                    ]),

                Section::make('IV. មុខរបរ')
                    ->schema([
                        Select::make('work_location')
                            ->label('ទីកន្លែង')
                            ->options(WorkLocation::getOptions()),

                        Select::make('occupation')
                            ->label('មុខរបរ')
                            ->options(Occupation::getOptions()),

                        Textarea::make('work_address')
                            ->label('អាសយដ្ឋានកន្លែងធ្វើការ')
                            ->rows(2),
                    ]),
            ]);
    }
}
