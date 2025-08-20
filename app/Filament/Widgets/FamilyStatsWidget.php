<?php

namespace App\Filament\Widgets;

use App\Models\SimpleFamilyMember;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FamilyStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('ចំនួនសមាជិក', SimpleFamilyMember::count())
                ->description('ចំនួនសមាជិកᖆំងអស់')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
            
            Stat::make('សមាជិកបក្ស', SimpleFamilyMember::where('is_party_member', true)->count())
                ->description('សមាជិកបក្ស CPP')
                ->descriptionIcon('heroicon-m-star')
                ->color('warning'),
            
            Stat::make('បងប្អូន', SimpleFamilyMember::whereNotNull('siblings')->count())
                ->description('សមាជិកមានបងប្អូន')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
        ];
    }
}
