<?php

namespace App\Filament\Widgets;

use App\Models\FamilyMember;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FamilyStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('ចំនួនសមាជិក', FamilyMember::count())
                ->description('ចំនួនសមាជិកទាំងអស់')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('សមាជិកបក្ស', FamilyMember::where('is_party_member', true)->count())
                ->description('សមាជិកបក្ស CPP')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),

            Stat::make('បងប្អូន', FamilyMember::whereNotNull('siblings')->count())
                ->description('សមាជិកមានបងប្អូន')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
        ];
    }
}
