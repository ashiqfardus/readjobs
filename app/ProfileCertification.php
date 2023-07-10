<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileCertification extends Model
{

    protected $table = 'profile_certifications';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];


}
