<?php

namespace App\Http\Controllers;

use App;
use App\Seo;
use App\Job;
use App\Company;
use App\FunctionalArea;
use App\Country;
use App\Video;
use App\Testimonial;
use App\SiteSetting;
use App\Slider;
use App\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Redirect;
use App\Traits\CompanyTrait;
use App\Traits\FunctionalAreaTrait;
use App\Traits\CityTrait;
use App\Traits\JobTrait;
use App\Traits\Active;
use App\Helpers\DataArrayHelper;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

class IndexController extends Controller
{

    use CompanyTrait;
    use FunctionalAreaTrait;
    use CityTrait;
    use JobTrait;
    use Active;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topCompanyIds = $this->getCompanyIdsAndNumJobs(16);
        $topFunctionalAreaIds = $this->getFunctionalAreaIdsAndNumJobs(32);
        $topIndustryIds = $this->getIndustryIdsFromCompanies(32);
        $topCityIds = $this->getCityIdsAndNumJobs(32);
        $featuredJobs = Job::active()->featured()->notExpire()->limit(12)->orderBy('id', 'desc')->get();
        $latestJobs = Job::active()->notExpire()->orderBy('id', 'desc')->limit(18)->get();
        $blogs = Blog::orderBy('id', 'desc')->where('lang', 'like', \App::getLocale())->limit(3)->get();
        $video = Video::getVideo();
        $testimonials = Testimonial::langTestimonials();

        $functionalAreas = DataArrayHelper::langFunctionalAreasArray();
        $countries = DataArrayHelper::langCountriesArray();
		$sliders = Slider::langSliders();

        $jobSkills = DB::table('manage_job_skills')
            ->select('manage_job_skills.job_skill_id', 'job_skills.job_skill')
            ->selectRaw('COUNT(DISTINCT manage_job_skills.job_id) job_count')
            ->leftJoin('job_skills', 'manage_job_skills.job_skill_id','=','job_skills.id')
            ->groupBy('manage_job_skills.job_skill_id')
            ->limit('32')->get();

        $jobCertifications = DB::table('manage_job_certifications')
            ->select('manage_job_certifications.certification_id', 'certification_types.certification_name')
            ->selectRaw('COUNT(DISTINCT manage_job_certifications.job_id) job_count')
            ->leftJoin('certification_types', 'manage_job_certifications.certification_id','=','certification_types.id')
            ->groupBy('manage_job_certifications.certification_id')
            ->limit('35')->get();

        $jobSkillsforSearch = DataArrayHelper::defaultJobSkillsArray();
        $jobCertificatations = DataArrayHelper::defaultCertificationArray();

        $seo = SEO::where('seo.page_title', 'like', 'front_index_page')->first();
        return view('welcome')
                        ->with('topCompanyIds', $topCompanyIds)
                        ->with('topFunctionalAreaIds', $topFunctionalAreaIds)
                        ->with('topCityIds', $topCityIds)
                        ->with('topIndustryIds', $topIndustryIds)
                        ->with('featuredJobs', $featuredJobs)
                        ->with('latestJobs', $latestJobs)
                        ->with('blogs', $blogs)
                        ->with('functionalAreas', $functionalAreas)
                        ->with('countries', $countries)
						->with('sliders', $sliders)
                        ->with('video', $video)
                        ->with('testimonials', $testimonials)
                        ->with('jobskills', $jobSkills)
                        ->with('jobCertificatations', $jobCertifications)
                        ->with('jobSkillsforSearch', $jobSkillsforSearch)
                        ->with('jobCertificationsforSearch', $jobCertificatations)
                        ->with('seo', $seo);
    }

    public function setLocale(Request $request)
    {
        $locale = $request->input('locale');
        $return_url = $request->input('return_url');
        $is_rtl = $request->input('is_rtl');
        $localeDir = ((bool) $is_rtl) ? 'rtl' : 'ltr';

        session(['locale' => $locale]);
        session(['localeDir' => $localeDir]);

        return Redirect::to($return_url);
    }
	
	public function checkTime()

    {
        $siteSetting = SiteSetting::findOrFail(1272);
        $t1 = strtotime( date('Y-m-d h:i:s'));
        $t2 = strtotime( $siteSetting->check_time );
        $diff = $t1 - $t2;
        $hours = $diff / ( 60 * 60 );
        if($hours>=1){
            $siteSetting->check_time = date('Y-m-d h:i:s');
            $siteSetting->update();
            Artisan::call('schedule:run');
            echo 'done';
        }else{
            echo 'not done';
        }

    }
    


}
