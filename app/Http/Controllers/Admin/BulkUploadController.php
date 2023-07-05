<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\UserImport;
use App\Imports\JobImport;
use App\Imports\CompanyImport;
use Maatwebsite\Excel\Facades\Excel;

class BulkUploadController extends Controller
{
    public function userCreate(){
        return view('admin.bulk_uploads.user.create');
    }

    public function userStore(Request $request){
        $fileName = time().'_'.$request->file->getClientOriginalName();
        request()->file('file')->storeAs('users', $fileName, 'public');
        Excel::import(new UserImport, $request->file);
        flash('Users imported successfully!')->success();
        return redirect()->back();  
    }
    
    public function jobCreate(){
        return view('admin.bulk_uploads.job.create');
    }

    public function jobStore(Request $request){
        $fileName = time().'_'.$request->file->getClientOriginalName();
        request()->file('file')->storeAs('jobs', $fileName, 'public');
        Excel::import(new JobImport, $request->file);
        flash('Jobs imported successfully!')->success();
        return redirect()->back();  
    }
    
    public function companyCreate(){
        return view('admin.bulk_uploads.company.create');
    }

    public function companyStore(Request $request){
        $fileName = time().'_'.$request->file->getClientOriginalName();
        request()->file('file')->storeAs('companies', $fileName, 'public');
        Excel::import(new CompanyImport, $request->file);
        flash('Companies imported successfully!')->success();
        return redirect()->back();  
    }
}