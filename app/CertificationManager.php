<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificationManager extends Model
{

    protected $table = 'manage_job_certifications';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];

    public function job()
    {
        return $this->belongsTo('App\Job', 'job_id', 'id');
    }

    public function getJob($field = '')
    {
        if (null !== $job = $this->job()->first()) {
            if (!empty($field)) {
                return $job->$field;
            } else {
                return $job;
            }
        }
    }

    public function jobCertification()
    {
        return $this->belongsTo('App\CertificationType', 'certification_id', 'id');
    }


}
