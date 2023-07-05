<?php

namespace App\Http\Controllers\Admin;


use App\DegreeType;
use App\CertificationType;
use App\Helpers\DataArrayHelper;
use App\Helpers\MiscHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CertificationTypeFormRequest;
use Auth;
use DataTables;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Input;
use Redirect;

class CertificationTypeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function indexCertificationTypes()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $degreeLevels = DataArrayHelper::defaultDegreeLevelsArray();

        return view('admin.certification_type.index')
                        ->with('languages', $languages)
                        ->with('degreeLevels', $degreeLevels);
    }

    public function createCertificationType()
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $certificationTypes = array('' => 'Select Degree Type');
        return view('admin.certification_type.add')
                        ->with('languages', $languages)
                        ->with('certificationTypes', $certificationTypes);
    }

    public function storeCertificationType(CertificationTypeFormRequest $request)
    {
        $certificationType = new CertificationType();
        $certificationType->lang = $request->input('lang');
        $certificationType->certification_name = $request->input('certification_name');
        $certificationType->is_default = $request->input('is_default');
        $certificationType->certification_type_id = $request->input('certification_type_id');
        $certificationType->is_active = $request->input('is_active');
        $certificationType->save();
        /*         * ************************************ */
        $certificationType->sort_order = $certificationType->id;
        if ((int) $request->input('is_default') == 1) {
            $certificationType->certification_type_id = $certificationType->id;
        } else {
            $certificationType->certification_type_id = $request->input('certification_type_id');
        }
        $certificationType->update();
        /*         * ************************************ */
        flash('Certification has been added!')->success();
        return \Redirect::route('edit.certification.type', array($certificationType->id));
    }

    public function editCertificationType($id)
    {
        $languages = DataArrayHelper::languagesNativeCodeArray();
        $certificationTypes = array('' => 'Select Certification Type');
        $certificationType = CertificationType::findOrFail($id);
        return view('admin.certification_type.edit')
                        ->with('languages', $languages)
                        ->with('certificationTypes', $certificationTypes)
                        ->with('certificationType', $certificationType);
    }

    public function updateCertificationType($id, CertificationTypeFormRequest $request)
    {
        $certificationType = CertificationType::findOrFail($id);
        $certificationType->lang = $request->input('lang');
        $certificationType->certification_name = $request->input('certification_name');
        $certificationType->is_default = $request->input('is_default');
        $certificationType->certification_type_id = $request->input('certification_type_id');
        $certificationType->is_active = $request->input('is_active');
        /*         * ************************************ */
        if ((int) $request->input('is_default') == 1) {
            $certificationType->certification_type_id = $certificationType->id;
        } else {
            $certificationType->certification_type_id = $request->input('degree_type_id');
        }
        /*         * ************************************ */
        $certificationType->update();
        flash('Certification has been updated!')->success();
        return \Redirect::route('edit.certification.type', array($certificationType->id));
    }

    public function deleteCertificationType(Request $request)
    {
        $id = $request->input('id');
        try {
            $certificationType = CertificationType::findOrFail($id);
            if ((bool) $certificationType->is_default) {
                CertificationType::where('certification_type_id', '=', $certificationType->certification_type_id)->delete();
            } else {
                $certificationType->delete();
            }
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchCertificationTypesData(Request $request)
    {
        $certificationTypes = CertificationType::select([
                    'certification_types.id', 'certification_types.lang','certification_types.certification_name', 'certification_types.is_default', 'certification_types.certification_type_id', 'certification_types.is_active',
                ])->sorted();
        return Datatables::of($certificationTypes)
                        ->filter(function ($query) use ($request) {
                            if ($request->has('id') && !empty($request->id)) {
                                $query->where('certification_types.id', 'like', "%{$request->get('id')}%");
                            }
                            if ($request->has('lang') && !empty($request->lang)) {
                                $query->where('certification_types.lang', 'like', "%{$request->get('lang')}%");
                            }
                            if ($request->has('certification_name') && !empty($request->certification_name)) {
                                $query->where('certification_types.certification_name', 'like', "%{$request->get('certification_name')}%");
                            }
                            if ($request->has('is_default') && !empty($request->is_default)) {
                                $query->where('certification_types.is_default', 'like', "%{$request->get('is_default')}%");
                            }
                            if ($request->has('certification_type_id') && !empty($request->certification_type_id)) {
                                $query->where('certification_types.certification_type_id', 'like', "%{$request->get('certification_type_id')}%");
                            }
                            if ($request->has('is_active') && !$request->is_active == -1) {
                                $query->where('certification_types.is_active', '=', "{$request->get('is_active')}");
                            }
                        })
                        ->addColumn('action', function ($certificationTypes) {
                            /*                             * ************************* */
                            $activeTxt = 'Make Active';
                            $activeHref = 'makeActive(' . $certificationTypes->id . ');';
                            $activeIcon = 'square-o';
                            if ((int) $certificationTypes->is_active == 1) {
                                $activeTxt = 'Make InActive';
                                $activeHref = 'makeNotActive(' . $certificationTypes->id . ');';
                                $activeIcon = 'check-square-o';
                            }
                            return '
				<div class="btn-group">
					<button class="btn blue dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action
						<i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu">
						<li>
							<a href="' . route('edit.certification.type', ['id' => $certificationTypes->id]) . '"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
						</li>						
						<li>
							<a href="javascript:void(0);" onclick="deleteCertificationType(' . $certificationTypes->id . ', ' . $certificationTypes->is_default . ');" class=""><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
						</li>
						<li>
						<a href="javascript:void(0);" onClick="' . $activeHref . '" id="onclickActive' . $certificationTypes->id . '"><i class="fa fa-' . $activeIcon . '" aria-hidden="true"></i>' . $activeTxt . '</a>
						</li>																																		
					</ul>
				</div>';
                        })

                        ->make(true);
        //$query = $dataTable->getQuery()->get();
        //return $query;
    }

    public function makeActiveCertificationType(Request $request)
    {
        $id = $request->input('id');
        try {
            $certificationType = CertificationType::findOrFail($id);
            $certificationType->is_active = 1;
            $certificationType->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }

    public function makeNotActiveCertificationType(Request $request)
    {
        $id = $request->input('id');
        try {
            $certificationType = CertificationType::findOrFail($id);
            $certificationType->is_active = 0;
            $certificationType->update();
            echo 'ok';
        } catch (ModelNotFoundException $e) {
            echo 'notok';
        }
    }


}
