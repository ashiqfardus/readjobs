<?php

namespace App\Imports;

use App\ProfileSummary;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $collection)
    {
        foreach ($collection as $row){
            $userData = [
              'name' => $row['name'],
              'email' => $row['email'],
              'date_of_birth' => $row['dob'],
              'phone' => $row['phone']
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
