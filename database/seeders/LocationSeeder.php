<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create provinces
        $phnomPenh = Location::createOrFirst([
            'name' => 'Phnom Penh',
            'name_kh' => 'ភ្នំពេញ',
            'code' => '01',
            'parent_id' => null,
        ]);

        $kandal = Location::createOrFirst([
            'name' => 'Kandal',
            'name_kh' => 'កណ្ដាល',
            'code' => '07',
            'parent_id' => null,
        ]);

        // Create districts in Kandal
        $saang = Location::createOrFirst([
            'name' => 'Saang',
            'name_kh' => 'សាង',
            'code' => '0707',
            'parent_id' => $kandal->id,
        ]);

        // Create communes in Saang
        $kampongLuong = Location::createOrFirst([
            'name' => 'Kampong Luong',
            'name_kh' => 'កំពង់លួង',
            'code' => '070702',
            'parent_id' => $saang->id,
        ]);

        // Create villages in Kampong Luong
        Location::createOrFirst([
            'name' => 'Prey Khpos',
            'name_kh' => 'ព្រៃខ្ពស់',
            'code' => '07070201',
            'parent_id' => $kampongLuong->id,
        ]);

        Location::createOrFirst([
            'name' => 'Kampong Luong',
            'name_kh' => 'កំពង់លួង',
            'code' => '07070202',
            'parent_id' => $kampongLuong->id,
        ]);

        Location::createOrFirst([
            'name' => 'Prey Thmei',
            'name_kh' => 'ព្រៃថ្មី',
            'code' => '07070203',
            'parent_id' => $kampongLuong->id,
        ]);

        // Add more sample locations
        $takhmao = Location::createOrFirst([
            'name' => 'Takhmao',
            'name_kh' => 'តាខ្មៅ',
            'code' => '0701',
            'parent_id' => $kandal->id,
        ]);

        $takhmaoCommune = Location::createOrFirst([
            'name' => 'Takhmao',
            'name_kh' => 'តាខ្មៅ',
            'code' => '070101',
            'parent_id' => $takhmao->id,
        ]);

        Location::createOrFirst([
            'name' => 'Takhmao Town',
            'name_kh' => 'ក្រុងតាខ្មៅ',
            'code' => '07010101',
            'parent_id' => $takhmaoCommune->id,
        ]);
    }
}
