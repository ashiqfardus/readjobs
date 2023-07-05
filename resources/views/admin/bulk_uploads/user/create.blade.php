@extends('admin.layouts.admin_layout')

@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li> <a href="{{ route('admin.home') }}">Home</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>User Upload</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title">Upload Users</h3>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            @include('flash::message')
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">User upload form</span> </div>
                        </div>
                        <div class="portlet-body form">
                            <form method="POST" action="{{route('bulk.user.store')}}" accept-charset="UTF-8" class="form" enctype="multipart/form-data">
                                @csrf
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="Details"> <div class="form-body">
                                            <div class="form-group " id="company_id_div">
                                                <label for="company_id" class="bold">Upload file ( <span style="color: red; font-size: 11px;">xlsx, csv</span>)</label>
                                                <input type="file" class="form-control" name="file" id="file" accept=".xlsx, .csv" required>
                                            </div>
                                            <div class="form-actions">
                                                <button class="btn btn-large btn-primary" type="submit">Update <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection