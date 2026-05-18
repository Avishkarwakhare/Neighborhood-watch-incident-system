<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\City;

class CitySeeder extends Seeder {
    public function run(): void {
        $stateCities = [
            'AP' => ['Visakhapatnam', 'Vijayawada', 'Guntur', 'Nellore', 'Tirupati'],
            'AR' => ['Itanagar', 'Tawang', 'Pasighat', 'Ziro'],
            'AS' => ['Guwahati', 'Dibrugarh', 'Silchar', 'Jorhat', 'Tezpur'],
            'BR' => ['Patna', 'Gaya', 'Bhagalpur', 'Muzaffarpur', 'Darbhanga'],
            'CG' => ['Raipur', 'Bilaspur', 'Durg', 'Bhilai', 'Korba'],
            'GA' => ['Panaji', 'Margao', 'Vasco da Gama', 'Mapusa'],
            'GJ' => ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot', 'Bhavnagar', 'Gandhinagar'],
            'HR' => ['Gurugram', 'Faridabad', 'Ambala', 'Karnal', 'Panipat', 'Rohtak', 'Panchkula'],
            'HP' => ['Shimla', 'Dharamshala', 'Manali', 'Solan', 'Mandi', 'Bilaspur'],
            'JH' => ['Ranchi', 'Jamshedpur', 'Dhanbad', 'Bokaro', 'Deoghar'],
            'KA' => ['Bengaluru', 'Mysuru', 'Hubballi', 'Mangaluru', 'Belagavi', 'Davanagere'],
            'KL' => ['Thiruvananthapuram', 'Kochi', 'Kozhikode', 'Thrissur', 'Alappuzha', 'Kollam'],
            'MP' => ['Indore', 'Bhopal', 'Jabalpur', 'Gwalior', 'Ujjain', 'Sagar'],
            'MH' => ['Mumbai', 'Pune', 'Nagpur', 'Thane', 'Nashik', 'Aurangabad', 'Solapur'],
            'MN' => ['Imphal', 'Churachandpur', 'Thoubal'],
            'ML' => ['Shillong', 'Tura', 'Jowai'],
            'MZ' => ['Aizawl', 'Lunglei', 'Champhai'],
            'NL' => ['Kohima', 'Dimapur', 'Mokokchung'],
            'OR' => ['Bhubaneswar', 'Cuttack', 'Rourkela', 'Sambalpur', 'Puri'],
            'PB' => ['Jalandhar', 'Ludhiana', 'Amritsar', 'Patiala', 'Bathinda', 'Mohali', 'Phagwara', 'Hoshiarpur', 'Pathankot', 'Gurdaspur'],
            'RJ' => ['Jaipur', 'Jodhpur', 'Udaipur', 'Kota', 'Bikaner', 'Ajmer', 'Alwar'],
            'SK' => ['Gangtok', 'Namchi', 'Geyzing'],
            'TN' => ['Chennai', 'Coimbatore', 'Madurai', 'Tiruchirappalli', 'Salem', 'Tirunelveli'],
            'TG' => ['Hyderabad', 'Warangal', 'Nizamabad', 'Karimnagar', 'Khammam'],
            'TR' => ['Agartala', 'Dharmanagar', 'Udaipur'],
            'UP' => ['Lucknow', 'Kanpur', 'Noida', 'Ghaziabad', 'Agra', 'Varanasi', 'Allahabad', 'Meerut', 'Bareilly'],
            'UT' => ['Dehradun', 'Haridwar', 'Rishikesh', 'Haldwani', 'Roorkee'],
            'WB' => ['Kolkata', 'Howrah', 'Darjeeling', 'Siliguri', 'Asansol', 'Durgapur'],
            'AN' => ['Port Blair'],
            'CH' => ['Chandigarh'],
            'DN' => ['Silvassa', 'Daman', 'Diu'],
            'DL' => ['New Delhi', 'Dwarka', 'Rohini', 'Laxmi Nagar', 'Janakpuri'],
            'JK' => ['Srinagar', 'Jammu', 'Anantnag', 'Kathua'],
            'LA' => ['Leh', 'Kargil'],
            'LD' => ['Kavaratti'],
            'PY' => ['Puducherry', 'Karaikal']
        ];

        foreach ($stateCities as $code => $cities) {
            $state = State::where('code', $code)->first();
            if ($state) {
                foreach ($cities as $c) {
                    City::firstOrCreate([
                        'state_id' => $state->id,
                        'name' => $c
                    ]);
                }
            }
        }
    }
}
