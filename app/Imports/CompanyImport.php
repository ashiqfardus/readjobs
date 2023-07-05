<?php

namespace App\Imports;

use App\Company;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class CompanyImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
//        return $collection;
        foreach ($collection as $row){
            $logo = isset($row['logo']) ? $row['logo']:'';
            
            $companyData = [
                'name'=>$row['name'],
                'email'=>$row['email'],
//                'ceo'=>$row['ceo'],
                'industry_id'=>$row['industry_id'],
                'ownership_type_id'=>$row['ownership_type_id'],
                'description'=>$row['description'],
                'location'=>$row['location'],
                'no_of_offices'=>$row['no_of_offices'],
                'website'=>$row['website'],
                'no_of_employees'=>$row['no_of_employees'],
                'established_in'=>$row['established_in'],
//                'fax'=>$row['fax'],
                'phone'=>$row['phone'],
                'country_id'=>$row['country_id'],
                'state_id'=>$row['state_id'],
                'city_id'=>$row['city_id'],
                'is_active'=>$row['is_active'],
                'verified'=>$row['verified'],
                'password' => Hash::make($row['password']),
                'map'=>$row['map'],
                'facebook'=>$row['facebook'],
                'twitter'=>$row['twitter'],
                'linkedin'=>$row['linkedin'],
                'google_plus'=>$row['google_plus'],
                'pinterest'=>$row['pinterest'],
                //'slug'=>$row['slug'],
                'logo' => $logo
                ];
                
            $company = DB::table('companies')->insertGetId($companyData);

            //update company slug
            $getCompanyData = DB::table('companies')->where('id',$company)->get();
            $slug = Str::slug($getCompanyData[0]->name, '-') . '-' . $company;
            $update_Company = DB::table('companies')->where('id',$company)->update(['slug'=>$slug]);
        }
    }
}
