<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BulkUploadController extends Controller
{
    public function userCreate(){
        return view('admin.bulk_uploads.user.create');
    }
}
