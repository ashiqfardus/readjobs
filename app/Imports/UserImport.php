<?php

namespace App\Imports;

use App\ProfileSummary;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class UserImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $collection)
    {
        foreach ($collection as $row){
            $userData = [
              'first_name' => $row['first_name'],
              'middle_name' => $row['middle_name'],
              'last_name' => $row['last_name'],
              'name' => $row['name'],
              'email' => $row['email'],
              'father_name' => $row['father_name'],
              'date_of_birth' => $row['date_of_birth'],
              'gender_id' => $row['gender_id'],
              'marital_status_id' => $row['marital_status_id'],
              'nationality_id' => $row['nationality_id'],
              'national_id_card_number' => $row['national_id_card_number'],
              'country_id' => $row['country_id'],
              'state_id' => $row['state_id'],
              'city_id' => $row['city_id'],
              'phone' => $row['phone'],
              'mobile_num' => $row['mobile_num'],
              'job_experience_id' => $row['job_experience_id'],
              'career_level_id' => $row['career_level_id'],
              'industry_id' => $row['industry_id'],
              'functional_area_id' => $row['functional_area_id'],
              'current_salary' => $row['current_salary'],
              'expected_salary' => $row['expected_salary'],
              'salary_currency' => $row['salary_currency'],
              'street_address' => $row['street_address'],
              'is_active' => $row['is_active'],
              'password' => Hash::make($row['password']),
              'image'=>$row['image']
            ];
            $user = DB::table('users')->insertGetId($userData);

            $summary = [
                'user_id' => $user,
                'summary' => $row['summary']
            ];
            $summary = DB::table('profile_summaries')->insert($summary);
        }
    }
}