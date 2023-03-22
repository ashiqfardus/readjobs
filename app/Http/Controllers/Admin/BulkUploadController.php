<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;

class BulkUploadController extends Controller
{
    public function userCreate(){
        return view('admin.bulk_uploads.user.create');
    }

    public function userStore(Request $request){
        $fileName = time().'_'.$request->file->getClientOriginalName();
        request()->file('file')->storeAs('reports', $fileName, 'public');
        Excel::import(new UserImport, $request->file);
        return 'imported';
    }
}
