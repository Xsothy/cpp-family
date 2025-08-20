<?php

namespace Database\Seeders;

use App\Models\Location;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LocationSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '256M');
        $file = storage_path('data_locations/Gazetteer_KH_2024_V1_NEW.xlsx');
        $json_file = storage_path('data_locations/locations_jsonV2.json');
        $reader = IOFactory::load($file);
        $KhetSheet = 'cKhet';
        $SrokSheet = 'cSrok';
        $KhumkSheet = 'cKhum';
        $PhumSheet = 'cPhum';
        $KhetData_raw = $reader->getSheetByName($KhetSheet)->toArray();
        $KhetData_raw = array_slice($KhetData_raw, 1);
        $SrokData_raw = $reader->getSheetByName($SrokSheet)->toArray();
        $SrokData_raw = array_slice($SrokData_raw, 1);
        $KhumData_raw = $reader->getSheetByName($KhumkSheet)->toArray();
        $KhumData_raw = array_slice($KhumData_raw, 1);
        $PhumData_raw = $reader->getSheetByName($PhumSheet)->toArray();
        $PhumData_raw = array_slice($PhumData_raw, 1);
        $data = [];
        foreach ($KhetData_raw as $khet) {
            foreach ($SrokData_raw as $srok) {
                if ($srok[1] >= (int) $khet[1] * 100 && $srok[1] < ($khet[1] + 1) * 100) {
                    $data[$khet[8].'. '.ucwords(strtolower($khet[5]))][] = [
                        'Type'         => $srok[2],
                        'Code'         => $srok[1],
                        'Name (Khmer)' => $srok[4],
                        'Name (Latin)' => $srok[5],
                        'Reference'    => $srok[6],
                    ];
                    foreach ($KhumData_raw as $khum) {
                        if ($khum[1] >= (int) $srok[1] * 100 && $khum[1] < ($srok[1] + 1) * 100) {
                            $data[$khet[8].'. '.ucwords(strtolower($khet[5]))][] = [
                                'Type'         => $khum[2],
                                'Code'         => $khum[1],
                                'Name (Khmer)' => $khum[4],
                                'Name (Latin)' => $khum[5],
                                'Reference'    => $khum[6],
                            ];
                            foreach ($PhumData_raw as $phum) {
                                if ($phum[1] >= (int) $khum[1] * 100 && $phum[1] < ($khum[1] + 1) * 100) {
                                    $data[$khet[8].'. '.ucwords(strtolower($khet[5]))][] = [
                                        'Type'         => $phum[2],
                                        'Code'         => $phum[1],
                                        'Name (Khmer)' => $phum[4],
                                        'Name (Latin)' => $phum[5],
                                        'Reference'    => $phum[6],
                                    ];
                                }
                            }
                        }
                    }
                }
            }
        }
        file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $data_array = json_decode(file_get_contents($json_file), true);
        $provinces = [];

        $data_pro = [
            'BANTEAY MEANCHEY' => 'បន្ទាយមានជ័យ',
            'BATTAMBANG'       => 'បាត់ដំបង',
            'KAMPONG CHAM'     => 'កំពង់ចាម',
            'KAMPONG CHHNANG'  => 'កំពង់ឆ្នាំង',
            'KAMPONG SPEU'     => 'កំពង់ស្ពឺ',
            'KAMPONG THOM'     => 'កំពង់ធំ',
            'KAMPOT'           => 'កំពត',
            'KANDAL'           => 'កណ្ដាល',
            'KOH KONG'         => 'កោះកុង',
            'KRATIE'           => 'ក្រចេះ',
            'MONDUL KIRI'      => 'មណ្ឌលគិរី',
            'PHNOM PENH'       => 'ភ្នំពេញ',
            'PREAH VIHEAR'     => 'ព្រះវិហារ',
            'PREY VENG'        => 'ព្រៃវែង',
            'PURSAT'           => 'ពោធិ៍សាត់',
            'RATANAK KIRI'     => 'រតនគិរី',
            'SIEMREAP'         => 'សៀមរាប',
            'SIHANOUKVILLE'    => 'ព្រះសីហនុ',
            'STUNG TRENG'      => 'ស្ទឹងត្រែង',
            'SVAY RIENG'       => 'ស្វាយរៀង',
            'TAKEO'            => 'តាកែវ',
            'OTDAR MEANCHEY'   => 'ឧត្តរមានជ័យ',
            'KEP'              => 'កែប',
            'PAILIN'           => 'ប៉ៃលិន',
            'TBOUNG KHMUM'     => 'ត្បូងឃ្មុំ',
        ];

        foreach ($data_array as $key => $items) {
            $data = [];
            foreach ($items as $item) {
                if ($item['Type'] == 'ស្រុក' || $item['Type'] == 'ក្រុង' || $item['Type'] == 'ខណ្ឌ') {
                    $srok_id = $item['Code'];
                }
                if ($item['Type'] == 'ឃុំ' || $item['Type'] == 'សង្កាត់') {
                    $item['parent_id'] = $srok_id;
                    $khum_id = $item['Code'];
                }
                if ($item['Type'] == 'ភូមិ') {
                    $item['parent_id'] = $khum_id;
                }
                $data[] = $item;
            }
            // put key
            $key = preg_replace('/^\d+\.\s/', '', $key);
            $provinces[$key] = $data;
        }

        $this->disableForeignKeys();
        $this->truncate('locations');

        // insert ខេត្ត
        $code = 1;
        foreach ($provinces as $key => $province) {
            $type = $key == 'Phnom Penh' ? 'រាជធានី' : 'ខេត្ត';
            $data = [
                'type'      => $type,
                'name'      => $key,
                'name_kh'   => $data_pro[strtoupper($key)],
                'code'      => $code++,
                'parent_id' => null,
            ];

            DB::table('locations')->insert($data);
            $parent_id = Location::where('name', $key)->whereNull('parent_id')->first()->code;

            $items = collect($province)->groupBy('parent_id');
            // insert ស្រុក​/ឃុំ/ភូមិ
            foreach ($items as $key_code => $item) {

                // ignore ស្រុក
                if ($key_code != '') {
                    $parent_id = Location::where('code', $key_code)->first()->code;
                }

                $data_item = [];
                foreach ($item as $value) {
                    $data_item[] = [
                        'type'      => $value['Type'],
                        'name'      => $value['Name (Latin)'],
                        'name_kh'   => $value['Name (Khmer)'],
                        'code'      => $value['Code'],
                        'parent_id' => $parent_id,
                    ];
                }
                DB::table('locations')->insert($data_item);
            }
        }
        $this->enableForeignKeys();
    }
}
