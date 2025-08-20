<?php

namespace App\Services;

use App\Models\FamilyMember;
use App\Models\Location;
use Carbon\Carbon;

class SystemCodeService
{
    /**
     * Generate system code for family member
     * Format: village_code-family_code-member_code
     * Example: 07070202-0001-01
     */
    public static function generateSystemCode($villageId, $familyCode): string
    {
        $village = Location::find($villageId);
        if (!$village) {
            throw new \Exception('Village not found');
        }

        // Get the next member number for this family
        $lastMember = FamilyMember::where('village_id', $villageId)
            ->where('family_code', $familyCode)
            ->orderBy('system_code', 'desc')
            ->first();

        $memberNumber = 1;
        if ($lastMember) {
            // Extract member number from system code
            $parts = explode('-', $lastMember->system_code);
            if (count($parts) >= 3) {
                $memberNumber = intval($parts[2]) + 1;
            }
        }

        $formattedFamilyCode = str_pad($familyCode, 4, '0', STR_PAD_LEFT);
        $formattedMemberCode = str_pad($memberNumber, 2, '0', STR_PAD_LEFT);

        return "{$village->code}-{$formattedFamilyCode}-{$formattedMemberCode}";
    }

    /**
     * Calculate age from birth date
     */
    public static function calculateAge($birthDate): array
    {
        if (!$birthDate) {
            return ['years' => null, 'months' => null];
        }

        $birth = Carbon::parse($birthDate);
        $now = Carbon::now();

        $years = $birth->diffInYears($now);
        $months = $birth->addYears($years)->diffInMonths($now);

        return [
            'years' => $years,
            'months' => $months,
        ];
    }

    /**
     * Get next available family code for a village
     */
    public static function getNextFamilyCode($villageId): string
    {
        $lastFamily = FamilyMember::where('village_id', $villageId)
            ->orderBy('family_code', 'desc')
            ->first();

        $nextFamilyNumber = 1;
        if ($lastFamily) {
            $nextFamilyNumber = intval($lastFamily->family_code) + 1;
        }

        return str_pad($nextFamilyNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Validate system code format
     */
    public static function validateSystemCode($code): bool
    {
        return preg_match('/^\d{8}-\d{4}-\d{2}$/', $code);
    }
}
