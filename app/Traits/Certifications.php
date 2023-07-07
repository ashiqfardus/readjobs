<?php

namespace App\Traits;

use App\CertificationManager;

trait Certifications
{

    private function storeJobCertifications($request, $job_id)
    {
        if ($request->has('certifications')) {
            CertificationManager::where('job_id', '=', $job_id)->delete();
            $certifications = $request->input('certifications');
            foreach ($certifications as $job_certification_id) {
                $jobCertificationManager = new CertificationManager();
                $jobCertificationManager->job_id = $job_id;
                $jobCertificationManager->certification_id = $job_certification_id;
                $jobCertificationManager->save();
            }
        }
    }

}
