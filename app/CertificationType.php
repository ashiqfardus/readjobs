<?php

namespace App;

use App\Traits\Active;
use App\Traits\IsDefault;
use App\Traits\Lang;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;

class CertificationType extends Model
{

    use Lang;
    use IsDefault;
    use Active;
    use Sorted;

    protected $table = 'certification_types';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $dateFormat = 'U';
    protected $dates = ['created_at', 'updated_at'];


}
