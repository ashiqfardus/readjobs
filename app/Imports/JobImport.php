<?php

namespace App\Imports;

use App\Company;
use App\Job;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JobImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row){
            $jobData = [
                'company_id'=>$row['company_id'],
                'title'=>$row['title'],
                'description'=>$row['description'],
                'benefits'=>$row['benefits'],
                'country_id'=>$row['country_id'],
                'state_id'=>$row['state_id'],
                'city_id'=>$row['city_id'],
                'is_freelance'=>$row['is_freelance'],
                'career_level_id'=>$row['career_level_id'],
                'salary_from'=>$row['salary_from'],
                'salary_to'=>$row['salary_to'],
                'hide_salary'=>$row['hide_salary'],
                'salary_currency'=>$row['salary_currency'],
                'salary_period_id'=>$row['salary_period_id'],
                'functional_area_id'=>$row['functional_area_id'],
                'job_type_id'=>$row['job_type_id'],
                'job_shift_id'=>$row['job_shift_id'],
                'num_of_positions'=>$row['num_of_positions'],
                'gender_id'=>$row['gender_id'],
                'expiry_date'=>$row['expiry_date'],
                'degree_level_id'=>$row['degree_level_id'],
                'job_experience_id'=>$row['job_experience_id'],
                'is_active'=>$row['is_active']
                ];
                
            $job = DB::table('jobs')->insertGetId($jobData);

            //update job slug
            $getJobData = DB::table('jobs')->where('id',$job)->get();

            $slug = Str::slug($getJobData[0]->title, '-') . '-' . $job;
            $search = $this->updateSearchText($getJobData[0]);

            $update_job = DB::table('jobs')->where('id',$job)->update(['slug'=>$slug, 'search'=>$search]);

            $strJobSkill = $row['job_skill'];
            if (!empty($strJobSkill)){
                $jobSkill = explode(',',$strJobSkill);
                foreach ($jobSkill as $skill){
                    $data = ['job_id'=>$job, 'job_skill_id'=>$skill];
                    $insertJobSkill = DB::table('manage_job_skills')->insert($data);
                }
            }

        }
    }

    public function updateSearchText($job){

        $job = Job::find($job->id);

        $str = '';

        $str .= $job->getCompany('name');

        $str .= ' ' . $job->getCountry('country');

        $str .= ' ' . $job->getState('state');

        $str .= ' ' . $job->getCity('city');

        $str .= ' ' . $job->title;

        $str .= ' ' . $job->description;

        $str .= $job->getJobSkillsStr();

        $str .= ((bool) $job->is_freelance) ? ' freelance remote work from home multiple cities' : '';

        $str .= ' ' . $job->getCareerLevel('career_level');

        $str .= ((bool) $job->hide_salary === false) ? ' ' . $job->salary_from . ' ' . $job->salary_to : '';

        $str .= $job->getSalaryPeriod('salary_period');

        $str .= ' ' . $job->getFunctionalArea('functional_area');

        $str .= ' ' . $job->getJobType('job_type');

        $str .= ' ' . $job->getJobShift('job_shift');

        $str .= ' ' . $job->getGender('gender');

        $str .= ' ' . $job->getDegreeLevel('degree_level');

        $str .= ' ' . $job->getJobExperience('job_experience');

        return $str;
    }
}
