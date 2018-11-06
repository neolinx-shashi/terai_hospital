<?php

namespace App\Http\Controllers\BackEndController;

use App\Models\Billing;
use App\Models\Patient;
use App\Models\IPatient;
use App\Models\Category;
use App\Models\TestDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\User;
use Carbon\Carbon;
use App\Models\DischargeDetail;
use Maatwebsite\Excel\Facades\Excel;

class CalculationController extends Controller
{

    private $patient;
    private $iPatient;
    private $billing;

    public function __construct(Patient $patient,
                                Billing $billing,
                                IPatient $iPatient)
    {
        $this->middleware('auth');
        $this->patient = $patient;
        $this->billing = $billing;
        $this->iPatient = $iPatient;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dailyRevenue()
    {

        $title = "Today's Revenue";
        $today = Carbon::now()->toDateString();

        $todayDate = date("Y/n/j");
        $localDate = str_replace("/", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = $classes[0];
        $b = $classes[1];
        $c = $classes[2];
        $currentDate = eng_to_nep($a, $b, $c);


        $now = Carbon::now();


        $reportData = 'today';

        $patients = $this->iPatient
            ->where('refund_status', 'Active')
            ->where('patient_type', 'OPD')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->orderBy('created_at', 'DESC')
            ->get();


        $ePatients = IPatient::leftJoin('billing_detail', 'billing_detail.patient_id', '=', 'ipatient.id')
            ->select(['billing_detail.*', 'ipatient.*'])
            ->where('ipatient.patient_type', 'Emergency')
            ->whereDate('ipatient.created_at', '=', Carbon::now()->toDateString())
            ->get();


        $iPatients = IPatient::leftJoin('discharge_details', 'discharge_details.ipatient_id', '=', 'ipatient.id')
            ->select(['discharge_details.*', 'ipatient.*'])
            ->where('ipatient.patient_type', 'IPD')
            ->where('ipatient.status', 'Discharged')
            ->whereDate('ipatient.created_at', '=', Carbon::now()->toDateString())
            ->get();


        $testPatients = $this->billing
            ->where('status', 'Active')
            ->where('patient_type', 'test')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->orderBy('created_at', 'DESC')
            ->get();


        return view('backendview.calculation.calculation', compact('patients',
            'testPatients',
            'today',
            'title',
            'iPatients',
            'now',
            'ePatients',
            'reportData',
            'currentDate'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function weeklyRevenue()
    {
        $now = Carbon::now();
        $title = "This Week's Revenue";
        $today = Carbon::now()->toDateString();
        //$week = date('w');
        $date = Carbon::parse('last sunday')->startOfDay();
        $reportData = 'week';

        $todayDate = date("Y/n/j");
        $localDate = str_replace("/", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = $classes[0];
        $b = $classes[1];
        $c = $classes[2];
        $currentDate = eng_to_nep($a, $b, $c);

        $patients = $this->iPatient
            ->where('refund_status', 'Active')
            ->where('patient_type', 'OPD')
            //->where('created_at', '=', $week)
            ->where('created_at', '>=', $date)
            ->orderBy('created_at', 'DESC')
            ->get();


        $ePatients = IPatient::leftJoin('billing_detail', 'billing_detail.patient_id', '=', 'ipatient.id')
            ->select(['billing_detail.*', 'ipatient.*'])
            ->where('ipatient.patient_type', 'Emergency')
            ->where('ipatient.created_at', '>=', $date)
            ->get();


        // $iPatients = $this->iPatient
        //     ->where('status', 'Discharged')
        //     ->where('patient_type', 'IPD')
        //     ->where('discharged_at', '>=', $date)
        //     ->orderBy('created_at', 'DESC')
        //     ->get();


        $iPatients = IPatient::leftJoin('discharge_details', 'discharge_details.ipatient_id', '=', 'ipatient.id')
            ->select(['discharge_details.*', 'ipatient.*'])
            ->where('ipatient.patient_type', 'IPD')
            ->where('ipatient.status', 'Discharged')
            ->where('ipatient.created_at', '>=', $date)
            ->get();


        $testPatients = $this->billing
            ->where('status', 'Active')
            ->where('patient_type', 'test')
            //->whereWeek('created_at', '=', $week)
            ->where('created_at', '>=', $date)
            ->orderBy('created_at', 'DESC')
            ->get();


        return view('backendview.calculation.calculation', compact('patients',
            'testPatients',
            'today',
            'title',
            'iPatients',
            'ePatients',
            'now',
            'reportData',
            'currentDate'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function monthlyRevenue()
    {
        $now = Carbon::now();
        $title = "This Month's Revenue";
        $today = Carbon::now()->toDateString();
        $month = date('m');
        $reportData = 'month';

        $todayDate = date("Y/n/j");
        $localDate = str_replace("/", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = $classes[0];
        $b = $classes[1];
        $c = $classes[2];
        $currentDate = eng_to_nep($a, $b, $c);

        $patients = $this->iPatient
            ->where('refund_status', 'Active')
            ->where('patient_type', 'OPD')
            ->whereMonth('created_at', '=', $month)
            //->where( 'created_at', '>', Carbon::now()->subDays(30))
            ->orderBy('created_at', 'DESC')
            ->get();


        $ePatients = IPatient::leftJoin('billing_detail', 'billing_detail.patient_id', '=', 'ipatient.id')
            ->select(['billing_detail.*', 'ipatient.*'])
            ->where('ipatient.patient_type', 'Emergency')
            ->whereMonth('ipatient.created_at', '=', $month)
            ->get();


        // $iPatients = $this->iPatient
        //     ->where('status', 'Discharged')
        //     ->where('patient_type', 'IPD')
        //     ->whereMonth('discharged_at', '=', $month)
        //     ->orderBy('created_at', 'DESC')
        //     ->get();


        $iPatients = IPatient::leftJoin('discharge_details', 'discharge_details.ipatient_id', '=', 'ipatient.id')
            ->select(['discharge_details.*', 'ipatient.*'])
            ->where('ipatient.patient_type', 'IPD')
            ->where('ipatient.status', 'Discharged')
            ->whereMonth('ipatient.created_at', '=', $month)
            ->get();


        $testPatients = $this->billing
            ->where('status', 'Active')
            ->where('patient_type', 'test')
            ->whereMonth('created_at', '=', $month)
            //->where( 'created_at', '>', Carbon::now()->subDays(30))
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('backendview.calculation.calculation', compact('patients',
            'testPatients',
            'today',
            'title',
            'iPatients',
            'ePatients',
            'now',
            'reportData',
            'currentDate'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function yearlyRevenue()
    {
        $now = Carbon::now();
        $title = "This Year's Revenue";
        $today = Carbon::now()->toDateString();
        $year = date('Y');
        $reportData = 'year';

        $todayDate = date("Y/n/j");
        $localDate = str_replace("/", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = $classes[0];
        $b = $classes[1];
        $c = $classes[2];
        $currentDate = eng_to_nep($a, $b, $c);

        $patients = $this->iPatient
            ->where('refund_status', 'Active')
            ->where('patient_type', 'OPD')
            ->whereYear('created_at', '=', $year)
            //->where('created_at', 'like', '%' . $year . '%')
            ->orderBy('created_at', 'DESC')
            ->get();


        $ePatients = IPatient::leftJoin('billing_detail', 'billing_detail.patient_id', '=', 'ipatient.id')
            ->select(['billing_detail.*', 'ipatient.*'])
            ->where('ipatient.patient_type', 'Emergency')
            ->whereYear('ipatient.created_at', '=', $year)
            ->get();


        // $iPatients = $this->iPatient
        //     ->where('status', 'Discharged')
        //     ->where('patient_type', 'IPD')
        //     ->whereYear('discharged_at', '=', $year)
        //     ->orderBy('created_at', 'DESC')
        //     ->get();

        $iPatients = IPatient::leftJoin('discharge_details', 'discharge_details.ipatient_id', '=', 'ipatient.id')
            ->select(['discharge_details.*', 'ipatient.*'])
            ->where('ipatient.patient_type', 'IPD')
            ->where('ipatient.status', 'Discharged')
            ->whereYear('ipatient.created_at', '=', $year)
            ->get();


        $testPatients = $this->billing
            ->where('status', 'Active')
            ->where('patient_type', 'test')
            ->whereYear('created_at', '=', $year)
            //->where('created_at', 'like', '%' . $year . '%')
            ->orderBy('created_at', 'DESC')
            ->get();
        //dd($testPatients);

        return view('backendview.calculation.calculation', compact('patients',
            'testPatients',
            'today',
            'title',
            'iPatients',
            'ePatients',
            'now',
            'reportData',
            'currentDate'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function revenueByDate(Request $request)
    {
        $now = Carbon::now();
        $today = Carbon::now()->toDateString();
        $input = $request->all();
        $from = $input['date_from'];
        $to = $input['date_to'];
        $time = \Carbon\Carbon::now();
        date_format($time, ' l - jS F, Y');
        $title = "Revenue from $from to $to";
        $reportData = 'customsearch';


        $todayDate = date("Y/n/j");
        $localDate = str_replace("/", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = $classes[0];
        $b = $classes[1];
        $c = $classes[2];
        $currentDate = eng_to_nep($a, $b, $c);


        $todayDate = $from;

        $localDate = str_replace("-", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = $classes[0];
        $b = $classes[1];
        $c = $classes[2];
        $currentDateEng = nep_to_eng($a, $b, $c);


        $todayDate = $to;

        $localDate = str_replace("-", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = $classes[0];
        $b = $classes[1];
        $c = $classes[2];
        $currentDateEngto = nep_to_eng($a, $b, $c);


        if ($from == $to) {
            $patients = $this->iPatient
                ->where('refund_status', 'Active')
                ->where('patient_type', 'OPD')
                ->whereDate('created_at', '=', $currentDateEng)
                ->orderBy('created_at', 'DESC')
                ->get();

            $iPatients = IPatient::leftJoin('discharge_details', 'discharge_details.ipatient_id', '=', 'ipatient.id')
                ->select(['discharge_details.*', 'ipatient.*'])
                ->where('ipatient.patient_type', 'IPD')
                ->where('ipatient.status', 'Discharged')
                ->whereDate('ipatient.created_at', '=', $currentDateEng)
                ->get();

            /*$iPatients = $this->iPatient
                ->where('status', 'Discharged')
                ->where('patient_type', 'IPD')
                ->whereDate('created_at', '=', $currentDateEng)
                ->orderBy('created_at', 'DESC')
                ->get();*/

            $ePatients = $this->iPatient
                ->where('patient_type', 'Emergency')
                ->where('status', 'Discharged')
                ->whereDate('discharged_at', '=', $currentDateEng)
                ->orderBy('created_at', 'DESC')
                ->get();

            $testPatients = $this->billing
                ->where('status', 'Active')
                ->where('patient_type', 'test')
                ->whereDate('date', '=', $currentDateEng)
                ->orderBy('created_at', 'DESC')
                ->get();
        } else {
            $patients = $this->iPatient
                ->select(DB::raw('ipatient.*', "DATE_FORMAT(ipatients.created_at, '%Y/%m/%d') as created_at"))
                ->where('refund_status', 'Active')
                ->where('patient_type', 'OPD')
                ->whereBetween('created_at', [$currentDateEng, $currentDateEngto])
                ->orderBy('created_at', 'DESC')
                ->get();

            /*$iPatients = $this->iPatient
                ->where('status', 'Discharged')
                ->where('patient_type', 'IPD')
                ->whereBetween('created_at', [$currentDateEng, $currentDateEngto])
                ->orderBy('created_at', 'DESC')
                ->get();*/

            $iPatients = IPatient::leftJoin('discharge_details', 'discharge_details.ipatient_id', '=', 'ipatient.id')
                ->select(['discharge_details.*', 'ipatient.*'])
                ->where('ipatient.patient_type', 'IPD')
                ->where('ipatient.status', 'Discharged')
                ->whereBetween('ipatient.created_at', [$currentDateEng, $currentDateEngto])
                ->get();


            $ePatients = $this->iPatient
                ->where('patient_type', 'Emergency')
                ->where('status', 'Discharged')
                ->whereBetween('created_at', [$currentDateEng, $currentDateEngto])
                ->orderBy('created_at', 'DESC')
                ->get();

            $testPatients = $this->billing
                ->where('status', 'Active')
                ->where('patient_type', 'test')
                ->whereBetween('date', [$currentDateEng, $currentDateEngto])
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        return view('backendview.calculation.calculation', compact('patients',
            'testPatients',
            'today',
            'title',
            'iPatients',
            'ePatients',
            'now',
            'reportData',
            'from',
            'to',
            'currentDate'));
    }


    public function reportGenerateforOpd($data)
    {

        if ($data == 'today') {
            $title = "Today's Revenue";
            $today = Carbon::now()->toDateString();
            $now = Carbon::now();

            $patients = $this->iPatient
                ->where('refund_status', 'Active')
                ->where('patient_type', 'OPD')
                ->whereDate('created_at', '=', Carbon::now()->toDateString())
                ->orderBy('created_at', 'DESC')
                ->get();


        }


        if ($data == 'week') {
            $now = Carbon::now();
            $title = "This Week's Revenue";
            $today = Carbon::now()->toDateString();
            //$week = date('w');
            $date = Carbon::parse('last sunday')->startOfDay();

            $patients = $this->iPatient
                ->where('refund_status', 'Active')
                ->where('patient_type', 'OPD')
                //->where('created_at', '=', $week)
                ->where('created_at', '>=', $date)
                ->orderBy('created_at', 'DESC')
                ->get();


        }


        if ($data == 'month') {
            $now = Carbon::now();
            $title = "This Month's Revenue";
            $today = Carbon::now()->toDateString();
            $month = date('m');

            $patients = $this->iPatient
                ->where('refund_status', 'Active')
                ->where('patient_type', 'OPD')
                ->whereMonth('created_at', '=', $month)
                //->where( 'created_at', '>', Carbon::now()->subDays(30))
                ->orderBy('created_at', 'DESC')
                ->get();

        }


        if ($data == 'year') {
            $now = Carbon::now();
            $title = "This Year's Revenue";
            $today = Carbon::now()->toDateString();
            $year = date('Y');
            $reportData = 'year';

            $patients = $this->iPatient
                ->where('refund_status', 'Active')
                ->where('patient_type', 'OPD')
                ->whereYear('created_at', '=', $year)
                //->where('created_at', 'like', '%' . $year . '%')
                ->orderBy('created_at', 'DESC')
                ->get();


        }

        Excel::create('Patients Reports by  Year', function ($excel) use ($patients) {
            $excel->sheet('New sheet', function ($sheet) use ($patients) {
                $sheet->loadView('backendview.revenue.yearlyreport', compact('patients'));

            });

        })->export('xls');


    }

//emergency

    public function reportGenerateforEmergency($data)
    {


        if ($data == 'today') {
            $title = "Today's Revenue";
            $today = Carbon::now()->toDateString();
            $now = Carbon::now();


            $patients = IPatient::leftJoin('billing_detail', 'billing_detail.patient_id', '=', 'ipatient.id')
                ->select(['billing_detail.*', 'ipatient.*'])
                ->where('ipatient.patient_type', 'Emergency')
                ->whereDate('ipatient.created_at', '=', Carbon::now()->toDateString())
                ->get();

        }


        if ($data == 'week') {
            $now = Carbon::now();
            $title = "This Week's Revenue";
            $today = Carbon::now()->toDateString();
            //$week = date('w');
            $date = Carbon::parse('last sunday')->startOfDay();


            $patients = IPatient::leftJoin('billing_detail', 'billing_detail.patient_id', '=', 'ipatient.id')
                ->select(['billing_detail.*', 'ipatient.*'])
                ->where('ipatient.patient_type', 'Emergency')
                ->where('ipatient.created_at', '>=', $date)
                ->get();

        }


        if ($data == 'month') {
            $now = Carbon::now();
            $title = "This Month's Revenue";
            $today = Carbon::now()->toDateString();
            $month = date('m');


            $patients = IPatient::leftJoin('billing_detail', 'billing_detail.patient_id', '=', 'ipatient.id')
                ->select(['billing_detail.*', 'ipatient.*'])
                ->where('ipatient.patient_type', 'Emergency')
                ->whereMonth('ipatient.created_at', '=', $month)
                ->get();


        }


        if ($data == 'year') {
            $now = Carbon::now();
            $title = "This Year's Revenue";
            $today = Carbon::now()->toDateString();
            $year = date('Y');
            $reportData = 'year';


            //  $patients = DB::table('ipatient')
            // ->join('billing_detail', 'ipatient.id', '=', 'billing_detail.patient_id')
            // ->select('ipatient.*', 'billing_detail.grand_total')
            // ->where('billing_detail.patient_type', 'Emergency')
            // ->whereYear('ipatient.created_at', '=', $year)
            // ->orderBy('billing_detail.created_at', 'DESC')
            // ->get();


            $patients = IPatient::leftJoin('billing_detail', 'billing_detail.patient_id', '=', 'ipatient.id')
                ->select(['billing_detail.*', 'ipatient.*'])
                ->where('ipatient.patient_type', 'Emergency')
                ->whereYear('ipatient.created_at', '=', $year)
                ->get();

        }

        Excel::create('Patients Reports by  Year', function ($excel) use ($patients) {
            $excel->sheet('New sheet', function ($sheet) use ($patients) {
                $sheet->loadView('backendview.revenue.emergency_report', compact('patients'));

            });

        })->export('xls');
    }


    public function reportGenerateforIpd($data)
    {
        if ($data == 'today') {
            $title = "Today's Revenue";
            $today = Carbon::now()->toDateString();
            $now = Carbon::now();


            // $patients = DB::table('ipatient')
            // ->join('discharge_details', 'ipatient.id', '=', 'discharge_details.ipatient_id')
            // ->select('ipatient.*', 'discharge_details.total_after_tax')
            // ->where('ipatient.patient_type','IPD')
            // ->whereDate('discharge_details.created_at', '=', Carbon::now()->toDateString())
            // ->orderBy('discharge_details.created_at', 'DESC')
            // ->get();


            $patients = IPatient::leftJoin('discharge_details', 'discharge_details.ipatient_id', '=', 'ipatient.id')
                ->select(['discharge_details.*', 'ipatient.*'])
                ->where('ipatient.patient_type', 'IPD')
                ->whereDate('ipatient.created_at', '=', Carbon::now()->toDateString())
                ->get();

        }


        if ($data == 'week') {
            $now = Carbon::now();
            $title = "This Week's Revenue";
            $today = Carbon::now()->toDateString();
            //$week = date('w');
            $date = Carbon::parse('last sunday')->startOfDay();


            // $patients = DB::table('ipatient')
            // ->join('discharge_details', 'ipatient.id', '=', 'discharge_details.ipatient_id')
            // ->select('ipatient.*', 'discharge_details.total_after_tax')
            // ->where('ipatient.patient_type','IPD')
            // ->where('ipatient.discharged_at', '>=', $date)
            // ->orderBy('discharge_details.created_at', 'DESC')
            // ->get();


            $patients = IPatient::leftJoin('discharge_details', 'discharge_details.ipatient_id', '=', 'ipatient.id')
                ->select(['discharge_details.*', 'ipatient.*'])
                ->where('ipatient.patient_type', 'IPD')
                ->where('ipatient.created_at', '>=', $date)
                ->get();
        }


        if ($data == 'month') {
            $now = Carbon::now();
            $title = "This Month's Revenue";
            $today = Carbon::now()->toDateString();
            $month = date('m');


            // $patients = DB::table('ipatient')
            // ->join('discharge_details', 'ipatient.id', '=', 'discharge_details.ipatient_id')
            // ->select('ipatient.*', 'discharge_details.total_after_tax')
            // ->where('ipatient.patient_type','IPD')
            // ->whereMonth('ipatient.discharged_at', '=', $month)
            // ->orderBy('discharge_details.created_at', 'DESC')
            // ->get();

            $patients = IPatient::leftJoin('discharge_details', 'discharge_details.ipatient_id', '=', 'ipatient.id')
                ->select(['discharge_details.*', 'ipatient.*'])
                ->where('ipatient.patient_type', 'IPD')
                ->whereMonth('ipatient.created_at', '=', $month)
                ->get();


        }


        if ($data == 'year') {
            $now = Carbon::now();
            $title = "This Year's Revenue";
            $today = Carbon::now()->toDateString();
            $year = date('Y');
            $reportData = 'year';


            // $patients = DB::table('ipatient')
            // ->join('discharge_details', 'ipatient.id', '=', 'discharge_details.ipatient_id')
            // ->select('ipatient.*', 'discharge_details.total_after_tax')
            // ->where('ipatient.patient_type','IPD')
            // ->whereYear('ipatient.discharged_at', '=', $year)
            // ->orderBy('discharge_details.created_at', 'DESC')
            // ->get();

            $patients = IPatient::leftJoin('discharge_details', 'discharge_details.ipatient_id', '=', 'ipatient.id')
                ->select(['discharge_details.*', 'ipatient.*'])
                ->where('ipatient.patient_type', 'IPD')
                ->whereYear('ipatient.created_at', '=', $year)
                ->get();

        }
        Excel::create('Patients Reports by  Month', function ($excel) use ($patients) {
            $excel->sheet('New sheet', function ($sheet) use ($patients) {
                $sheet->loadView('backendview.revenue.ipd_report', compact('patients'));

            });

        })->export('xls');
    }


    public function reportGenerateforTest($data)
    {
        if ($data == 'today') {
            $title = "Today's Revenue";
            $today = Carbon::now()->toDateString();
            $now = Carbon::now();


            $patients = DB::table('ipatient')
                ->join('billing_detail', 'ipatient.id', '=', 'billing_detail.patient_id')
                ->select('ipatient.*', 'billing_detail.grand_total', 'billing_detail.discount', 'billing_detail.tax',
                    'billing_detail.sub_total', 'billing_detail.user_id')
                ->where('billing_detail.status', 'Active')
                ->where('billing_detail.patient_type', 'test')
                ->whereDate('billing_detail.created_at', '=', Carbon::now()->toDateString())
                ->orderBy('billing_detail.created_at', 'DESC')
                ->get();


        }


        if ($data == 'week') {
            $now = Carbon::now();
            $title = "This Week's Revenue";
            $today = Carbon::now()->toDateString();
            //$week = date('w');
            $date = Carbon::parse('last sunday')->startOfDay();

            // $patients = $this->billing
            //  ->where('status', 'Active')
            //  ->where('patient_type', 'test')
            //  //->whereWeek('created_at', '=', $week)
            //  ->where('created_at', '>=', $date)
            //  ->orderBy('created_at', 'DESC')
            //  ->get();


            $patients = DB::table('ipatient')
                ->join('billing_detail', 'ipatient.id', '=', 'billing_detail.patient_id')
                ->select('ipatient.*', 'billing_detail.*')
                ->where('billing_detail.status', 'Active')
                ->where('billing_detail.patient_type', 'test')
                ->where('ipatient.created_at', '>=', $date)
                ->orderBy('billing_detail.created_at', 'DESC')
                ->get();

        }


        if ($data == 'month') {
            $now = Carbon::now();
            $title = "This Month's Revenue";
            $today = Carbon::now()->toDateString();
            $month = date('m');

            // $patients = $this->billing
            //    ->where('status', 'Active')
            //    ->where('patient_type', 'test')
            //    ->whereMonth('created_at', '=', $month)
            //    //->where( 'created_at', '>', Carbon::now()->subDays(30))
            //    ->orderBy('created_at', 'DESC')
            //    ->get();

            $patients = DB::table('ipatient')
                ->join('billing_detail', 'ipatient.id', '=', 'billing_detail.patient_id')
                ->select('ipatient.*', 'billing_detail.*')
                ->where('billing_detail.status', 'Active')
                ->where('billing_detail.patient_type', 'test')
                ->whereMonth('ipatient.created_at', '=', $month)
                ->orderBy('billing_detail.created_at', 'DESC')
                ->get();

        }


        if ($data == 'year') {
            $now = Carbon::now();
            $title = "This Year's Revenue";
            $today = Carbon::now()->toDateString();
            $year = date('Y');
            $reportData = 'year';

            // $patients =  $this->billing
            //     ->where('status', 'Active')
            //     ->where('patient_type', 'test')
            //     ->whereYear('created_at', '=', $year)
            //     //->where('created_at', 'like', '%' . $year . '%')
            //     ->orderBy('created_at', 'DESC')
            //     ->get();

            $patients = DB::table('ipatient')
                ->join('billing_detail', 'ipatient.id', '=', 'billing_detail.patient_id')
                ->select('ipatient.*', 'billing_detail.*')
                ->where('billing_detail.status', 'Active')
                ->where('billing_detail.patient_type', 'test')
                ->whereYear('ipatient.created_at', '=', $year)
                ->orderBy('billing_detail.created_at', 'DESC')
                ->get();


        }
        Excel::create('Patients Reports by  Year', function ($excel) use ($patients) {
            $excel->sheet('New sheet', function ($sheet) use ($patients) {
                $sheet->loadView('backendview.revenue.test_report', compact('patients'));

            });

        })->export('xls');
    }


    public function generateReportBycustomOpd($data, $from, $to)
    {

        $now = Carbon::now();
        $today = Carbon::now()->toDateString();
        $from = $from;


        $to = $to;
        $time = \Carbon\Carbon::now();
        date_format($time, ' l - jS F, Y');
        $title = "Revenue from $from to $to";
        $reportData = 'customsearch';

        $todayDate = $from;
        $localDate = str_replace("-", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = $classes[0];
        $b = $classes[1];
        $c = $classes[2];
        $currentDateEng = nep_to_eng($a, $b, $c);


        $todayDate = $to;

        $localDate = str_replace("-", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = $classes[0];
        $b = $classes[1];
        $c = $classes[2];
        $currentDateEngto = nep_to_eng($a, $b, $c);


        if ($from == $to) {
            $patients = $this->iPatient
                ->where('refund_status', 'Active')
                ->where('patient_type', 'OPD')
                ->whereDate('created_at', '=', $currentDateEng)
                ->orderBy('created_at', 'DESC')
                ->get();


        } else {
            $patients = $this->iPatient
                ->select(DB::raw('ipatient.*', "DATE_FORMAT(ipatients.created_at, '%Y/%m/%d') as created_at"))
                ->where('refund_status', 'Active')
                ->where('patient_type', 'OPD')
                ->whereBetween('created_at', [$currentDateEng, $currentDateEngto])
                ->orderBy('created_at', 'DESC')
                ->get();


        }

        Excel::create('Patients Reports by  Search', function ($excel) use ($patients) {
            $excel->sheet('New sheet', function ($sheet) use ($patients) {
                $sheet->loadView('backendview.revenue.yearlyreport', compact('patients'));

            });

        })->export('xls');


    }


    public function generateReportBycustomTest($data, $from, $to)
    {

        $now = Carbon::now();
        $today = Carbon::now()->toDateString();
        $from = $from;


        $to = $to;
        $time = \Carbon\Carbon::now();
        date_format($time, ' l - jS F, Y');
        $title = "Revenue from $from to $to";
        $reportData = 'customsearch';

        $todayDate = $from;
        $localDate = str_replace("-", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = $classes[0];
        $b = $classes[1];
        $c = $classes[2];
        $currentDateEng = nep_to_eng($a, $b, $c);


        $todayDate = $to;

        $localDate = str_replace("-", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = $classes[0];
        $b = $classes[1];
        $c = $classes[2];
        $currentDateEngto = nep_to_eng($a, $b, $c);


        if ($from == $to) {
            // $patients = $this->billing
            //      ->where('status', 'Active')
            //      ->where('patient_type', 'test')
            //      ->whereDate('date', '=', $from)
            //      ->orderBy('created_at', 'DESC')
            //      ->get();

            $patients = DB::table('ipatient')
                ->join('billing_detail', 'ipatient.id', '=', 'billing_detail.patient_id')
                ->select('ipatient.*', 'billing_detail.*')
                ->where('billing_detail.status', 'Active')
                ->where('billing_detail.patient_type', 'test')
                ->whereDate('billing_detail.created_at', '=', $currentDateEng)
                ->orderBy('billing_detail.created_at', 'DESC')
                ->get();


        } else {
            // $patients = $this->billing
            //     ->where('status', 'Active')
            //     ->where('patient_type', 'test')
            //     ->whereBetween('date', [$from, $to])
            //     ->orderBy('created_at', 'DESC')
            //     ->get();

            $patients = DB::table('ipatient')
                ->join('billing_detail', 'ipatient.id', '=', 'billing_detail.patient_id')
                ->select('ipatient.*', 'billing_detail.*')
                ->where('billing_detail.status', 'Active')
                ->where('billing_detail.patient_type', 'test')
                ->whereBetween('billing_detail.created_at', [$currentDateEng, $currentDateEngto])
                ->orderBy('billing_detail.created_at', 'DESC')
                ->get();


        }

        Excel::create('Patients Reports by  Year', function ($excel) use ($patients) {
            $excel->sheet('New sheet', function ($sheet) use ($patients) {
                $sheet->loadView('backendview.revenue.test_report', compact('patients'));

            });

        })->export('xls');


    }


    public function generateReportBycustomEmergency($data, $from, $to)
    {
        $now = Carbon::now();
        $today = Carbon::now()->toDateString();
        $from = $from;


        $to = $to;
        $time = \Carbon\Carbon::now();
        date_format($time, ' l - jS F, Y');
        $title = "Revenue from $from to $to";
        $reportData = 'customsearch';

        $todayDate = $from;
        $localDate = str_replace("-", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = $classes[0];
        $b = $classes[1];
        $c = $classes[2];
        $currentDateEng = nep_to_eng($a, $b, $c);


        $todayDate = $to;

        $localDate = str_replace("-", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = $classes[0];
        $b = $classes[1];
        $c = $classes[2];
        $currentDateEngto = nep_to_eng($a, $b, $c);


        if ($from == $to) {


            $patients = IPatient::leftJoin('billing_detail', 'billing_detail.patient_id', '=', 'ipatient.id')
                ->select(['billing_detail.*', 'ipatient.*'])
                ->where('ipatient.patient_type', 'Emergency')
                ->whereDate('ipatient.created_at', '=', $currentDateEng)
                ->get();

        } else {

            $patients = IPatient::leftJoin('billing_detail', 'billing_detail.patient_id', '=', 'ipatient.id')
                ->select(['billing_detail.*', 'ipatient.*'])
                ->where('ipatient.patient_type', 'Emergency')
                ->whereBetween('ipatient.created_at', [$currentDateEng, $currentDateEngto])
                ->get();


        }

        Excel::create('Patients Reports by  Emergency ', function ($excel) use ($patients) {
            $excel->sheet('New sheet', function ($sheet) use ($patients) {
                $sheet->loadView('backendview.revenue.emergency_report', compact('patients'));

            });

        })->export('xls');


    }

    public function generateReportBycustomIpd($data, $from, $to)
    {
        $now = Carbon::now();
        $today = Carbon::now()->toDateString();
        $from = $from;


        $to = $to;
        $time = \Carbon\Carbon::now();
        date_format($time, ' l - jS F, Y');
        $title = "Revenue from $from to $to";
        $reportData = 'customsearch';

        $todayDate = $from;
        $localDate = str_replace("-", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = $classes[0];
        $b = $classes[1];
        $c = $classes[2];
        $currentDateEng = nep_to_eng($a, $b, $c);


        $todayDate = $to;

        $localDate = str_replace("-", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = $classes[0];
        $b = $classes[1];
        $c = $classes[2];
        $currentDateEngto = nep_to_eng($a, $b, $c);


        if ($from == $to) {


            // $patients=IPatient::leftJoin('billing_detail', 'billing_detail.patient_id', '=', 'ipatient.id')
            // ->select(['billing_detail.*','ipatient.*'])
            // ->where('ipatient.patient_type','Emergency')
            // ->whereDate('ipatient.created_at','=', $from)
            // ->get();


            $patients = IPatient::leftJoin('discharge_details', 'discharge_details.ipatient_id', '=', 'ipatient.id')
                ->select(['discharge_details.*', 'ipatient.*'])
                ->where('ipatient.patient_type', 'IPD')
                ->whereDate('ipatient.created_at', '=', $currentDateEng)
                ->get();


        } else {

            //  $patients=IPatient::leftJoin('billing_detail', 'billing_detail.patient_id', '=', 'ipatient.id')
            // ->select(['billing_detail.*','ipatient.*'])
            // ->where('ipatient.patient_type','Emergency')
            // ->whereBetween('ipatient.created_at', [$from, $to])
            // ->get();


            $patients = IPatient::leftJoin('discharge_details', 'discharge_details.ipatient_id', '=', 'ipatient.id')
                ->select(['discharge_details.*', 'ipatient.*'])
                ->where('ipatient.patient_type', 'IPD')
                ->whereBetween('ipatient.created_at', [$currentDateEng, $currentDateEngto])
                ->get();


        }

        Excel::create('Patients Reports by  IPD Search ', function ($excel) use ($patients) {
            $excel->sheet('New sheet', function ($sheet) use ($patients) {
                $sheet->loadView('backendview.revenue.ipd_report', compact('patients'));

            });

        })->export('xls');

    }


    /* user wise data */
    public function gotoUserRevenue()
    {
        $title = 'Revenue By User';
        $data = array();
        $usersllist = User::where('user_post', 'Billing')->get();
        $uid = 0;

        return view('backendview.calculation.revenue_by_user', compact('data', 'title', 'usersllist', 'uid'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUserRevenue(Request $request)
    {
        $title = 'Revenue By User';
        $usersllist = User::where('user_post', 'Billing')->get();

        $fromOld = $request->get('from');

        $todayDate = $fromOld;
        $localDate = str_replace("/", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $from = nep_to_eng($a, $b, $c);

        $toNew = $request->get('to');

        $todayOld = $toNew;
        $localDatto = str_replace("/", "-", $todayOld);
        $classesto = explode("-", $localDatto);
        $a = sprintf('%02d', $classesto[0]);
        $b = sprintf('%02d', $classesto[1]);
        $c = sprintf('%02d', $classesto[2]);
        $to = nep_to_eng($a, $b, $c);


        $uid = $request->get('user');

        if ($uid == 0) {
            $users = User::where('user_post', 'Billing')->get();
            $refund_user_tests = '';
            $refund_user_opd = '';
        } else {
            $users = User::where('user_post', 'Billing')
                ->where('id', $uid)->get();

            $from_n = $from . " 00:00:00";
            $to_n = $to . " 23:59:59";

            $refund_user_tests = Billing::join('ipatient', 'billing_detail.patient_id', '=', 'ipatient.id')
                ->where('billing_detail.user_id', $uid)
                ->where('billing_detail.status', 'Inactive')
                ->where('billing_detail.created_at', ">=", $from_n)
                ->where('billing_detail.created_at', '<=', $to_n)
                ->get();


            $refund_user_opd = IPatient::where('user_id', $uid)
                ->where('status', 'OPD')
                ->where('refund_status', 'Inactive')
                ->where('created_at', '>=', $from_n)
                ->where('created_at', '<=', $to_n)
                ->get();
        }
        $data = array();

        $all_users_total = 0;
        foreach ($users as $key => $val) {
            $user = $val['fullname'];
            $user_id = $val['id'];
            $data[$key]['user'] = $user;

            /* get billing detail */
            $billing = Billing::where('user_id', $user_id)
                ->where('patient_type', 'test')
                ->where('status', 'Active')
                ->where('date', ">=", $from)
                ->where('date', '<=', $to)
                ->sum('grand_total');

            $billing_refund = Billing::where('user_id', $user_id)
                ->where('status', 'Inactive')
                ->where('date', ">=", $from)
                ->where('date', '<=', $to)
                ->sum('grand_total');

            $data[$key]['test']['total'] = round($billing, 2);
            $data[$key]['test']['refund'] = round($billing_refund, 2);

            /* opd, ipd, emergency */
            $from = (strpos($from, ' 00:00:00') !== false) ? $from : $from . " 00:00:00";
            $to = (strpos($to, ' 23:59:59') !== false) ? $to : $to . " 23:59:59";

            $opd = $this->iPatient
                ->where('user_id', $user_id)
                ->where('refund_status', 'Active')
                ->where('patient_type', 'OPD')
                ->where('created_at', '>=', $from)
                ->where('created_at', '<=', $to)
                ->sum('doctor_fee_with_tax');


            $opd_refund = IPatient::where('user_id', $user_id)
                ->where('patient_type', 'OPD')
                ->where('refund_status', 'Inactive')
                ->where('created_at', '>=', $from)
                ->where('created_at', '<=', $to)
                ->sum('doctor_fee_with_tax');

            $ipd_admission = IPatient::where('user_id', $user_id)
                //->where('status', 'In Ward')
                ->where('patient_type', 'IPD')
                ->where('created_at', '>=', $from)
                ->where('created_at', '<=', $to)
                ->sum('admission_charge_with_tax');

            /*
            $ipd = IPatient::where('user_id', $user_id)
                //->where('status', 'In Ward')
                ->where('patient_type', 'IPD')
                ->where('created_at', '>=', $from)
                ->where('created_at', '<=', $to)
                ->sum('deposit_amount');

            $ipd_arr = explode(',', $ipd);
            $ipd_count = count($ipd_arr);
            if ($ipd_count > 1) {
                $ipd = 0;
                for ($i = 0; $i < $ipd_count; $i++) {
                    $ipd += $ipd_arr[$i];
                }
            }
            */
            $from_date = date("Y-m-d", strtotime($from));

            $ipd_deposit = IPatient::where('patient_type', 'IPD')
                //->where('status', 'In Ward')
                ->where('patient_type', 'IPD')
                //->where('updated_at', '>=', $from)
                //->where('updated_at', '<=', $to)
                ->where('deposit_dates', 'like', '%'.$from_date.'%')
                //->sum('deposit_amount')
                ->select('deposit_amount', 'deposit_dates', 'deposit_user_id')
                ->get();
//var_dump($ipd_deposit);die;
            $ipd = 0;
            foreach ($ipd_deposit as $val) {
                $amount = $val->deposit_amount;
                $ipd_arr = explode(',', $amount);
                $ipd_count = count($ipd_arr);

                $dates = $val->deposit_dates;
                $dates_arr = explode(',', $dates);

                $users = $val->deposit_user_id;
                $users_arr = explode(',', $users);

                //if ($ipd_count > 1) {
                    for ($i = 0; $i < $ipd_count; $i++) {
                        //echo $dates_arr[$i] . ' >= ' . date("Y-m-d", strtotime($from)) . "<br>";
                        //echo $user_id . ' = ' . $users_arr[$i] . "<br>";
                        if ($user_id == $users_arr[$i] && $dates_arr[$i] >= date("Y-m-d", strtotime($from)) &&  $dates_arr[$i] <= date("Y-m-d", strtotime($to))) {
                            $ipd += $ipd_arr[$i];
                        }
                        
                    }
                //} else {
                    //$ipd += $amount;                
                //}
            }

            $ipd_discharge = DischargeDetail::where('user_id', $user_id)
                ->where('created_at', '>=', $from)
                ->where('created_at', '<=', $to)
                ->sum('received_amount');

            /*$ipd_ignore = Ipatient::rightJoin('discharge_details', 'ipatient.id', '=', 'discharge_details.ipatient_id')
                ->where('ipatient.user_id', $user_id)
                ->where('ipatient.patient_type', 'IPD')
                ->where('ipatient.created_at', '>=', $from)
                ->where('ipatient.created_at', '<=', $to)
                ->sum('ipatient.deposit_amount');
                */

            $ipd_returned = DischargeDetail::where('user_id', $user_id)
                ->where('created_at', '>=', $from)
                ->where('created_at', '<=', $to)
                ->sum('returned_amount');

            $emergency = IPatient::where('user_id', $user_id)
                ->where('patient_type', 'Emergency')
                ->where('refund_status', 'Active')
                ->where('created_at', '>=', $from)
                ->where('created_at', '<=', $to)
                ->sum('doctor_fee_with_tax');

            $emergency_discharge = Billing::where('user_id', $user_id)
                ->where('patient_type', 'Emergency')
                ->where('status', 'Active')
                ->where('date', ">=", $from)
                ->where('date', '<=', $to)
                ->sum('grand_total');

            $emergency_refund = IPatient::where('user_id', $user_id)
                ->where('status', 'Emergency')
                ->where('refund_status', 'Inactive')
                ->where('created_at', '>=', $from)
                ->where('created_at', '<=', $to)
                ->sum('doctor_fee_with_tax');
            
            $grand_total = $billing + $opd + $ipd_admission + $ipd - $ipd_returned + $ipd_discharge + $emergency + $emergency_discharge;
            $all_users_total += $grand_total;

            $data[$key]['opd']['total'] = round($opd, 2);
            $data[$key]['opd']['refund'] = round($opd_refund, 2);
            $data[$key]['ipd']['total'] = round($ipd, 2);
            $data[$key]['ipd']['admission'] = round($ipd_admission, 2);
            $data[$key]['ipd']['discharge'] = round($ipd_discharge, 2);
            $data[$key]['emergency']['total'] = round($emergency, 2);
            $data[$key]['emergency']['refund'] = round($emergency_refund, 2);
            $data[$key]['emergency']['discharge'] = round($emergency_discharge, 2);
            $data[$key]['grand']['total'] = round($grand_total, 2);
        }
//die;
        return view('backendview.calculation.revenue_by_user', compact('data', 'title', 'from', 'to', 'users', 'uid', 'refund_user_tests', 'refund_user_opd', 'fromOld', 'toNew', 'usersllist', 'all_users_total'));
    }

    public function getUserRevenueDetail($uid, $from, $to)
    {
        $title = '';

        $fromn = date("Y-m-d", strtotime($from));
        $ton = date("Y-m-d", strtotime($to));

        /* eng to nep date */
        $from_arr = explode('-', $fromn);
        $from_n = eng_to_nep($from_arr[0], $from_arr[1], $from_arr[2]);
        $to_arr = explode('-', $ton);
        $to_n = eng_to_nep($to_arr[0], $to_arr[1], $to_arr[2]);

        $user = User::select('fullname')->find($uid);

        if ($from_n < "2074-07-21" && $to_n >= "2074-07-21") {
            $wrong = 1;
            return view('backendview.calculation.user_detail_revenue', compact('from_n', 'to_n', 'user', 'title', 'wrong'));
        }

        /* opd */
        $opd = Ipatient::where('user_id', $uid)
            ->where('patient_type', 'OPD')
            ->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->get();

        $ipd = Ipatient::where('user_id', $uid)
            ->where('patient_type', 'IPD')
            ->where('status', 'In Ward')
            ->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->get();

        foreach ($ipd as $key => $item) {
            if ($item->status == 'Discharged') {
                $discharge_subtotal = DischargeDetail::where('user_id', $uid)
                    ->where('ipatient_id', $item->id)
                    ->where('created_at', '>=', $from)
                    ->where('created_at', '<=', $to)
                    ->sum('subtotal_after_discount');

                $discharge_tax = DischargeDetail::where('user_id', $uid)
                    ->where('ipatient_id', $item->id)
                    ->where('created_at', '>=', $from)
                    ->where('created_at', '<=', $to)
                    ->sum('hst');

                $discharge_grandtotal = DischargeDetail::where('user_id', $uid)
                    ->where('ipatient_id', $item->id)
                    ->where('created_at', '>=', $from)
                    ->where('created_at', '<=', $to)
                    ->sum('total_after_tax');

                $discharge_bill_number = DischargeDetail::where('user_id', $uid)
                    ->where('ipatient_id', $item->id)
                    ->where('created_at', '>=', $from)
                    ->where('created_at', '<=', $to)
                    ->select('bill_number')
                    ->first();

                $item['discharge_subtotal'] = $discharge_subtotal;
                $item['discharge_tax'] = $discharge_tax;
                $item['discharge_grandtotal'] = $discharge_grandtotal;
                $item['discharge_bill_number'] = $discharge_bill_number->bill_number;
            }
        }

        $emergency = IPatient::where('user_id', $uid)
            ->where('patient_type', 'Emergency')
            ->where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->get();

        foreach ($emergency as $key => $emr) {
            if ($emr->status == 'Discharged') {
                $discharge_subtotal = Billing::where('user_id', $uid)
                    ->where('patient_id', $emr->id)
                    ->where('patient_type', 'Emergency')
                    ->where('status', 'Active')
                    ->where('date', ">=", $from)
                    ->where('date', '<=', $to)
                    ->sum('sub_total');

                $discharge_tax = Billing::where('user_id', $uid)
                    ->where('patient_id', $emr->id)
                    ->where('patient_type', 'Emergency')
                    ->where('status', 'Active')
                    ->where('date', ">=", $from)
                    ->where('date', '<=', $to)
                    ->sum('tax');

                $discharge_grandtotal = Billing::where('user_id', $uid)
                    ->where('patient_id', $emr->id)
                    ->where('patient_type', 'Emergency')
                    ->where('status', 'Active')
                    ->where('date', ">=", $from)
                    ->where('date', '<=', $to)
                    ->sum('grand_total');

                $discharge_bill_number = Billing::where('user_id', $uid)
                    ->where('patient_id', $emr->id)
                    ->where('patient_type', 'Emergency')
                    ->where('status', 'Active')
                    ->where('date', ">=", $from)
                    ->where('date', '<=', $to)
                    ->select('bill_number')
                    ->first();

                $emr['discharge_subtotal'] = $discharge_subtotal;
                $emr['discharge_tax'] = $discharge_tax;
                $emr['discharge_grandtotal'] = $discharge_grandtotal;
                $emr['discharge_bill_number'] = @$discharge_bill_number->bill_number;
            }
        }


        /* Pathology */
        $pathology_sub = Category::where('parent_id', 1)->where('level', 2)->orderBy('title', 'asc')->get();
        $sub_id = array();
        foreach ($pathology_sub as $sub) {
            $sub_id[] = $sub->id;
        }
        $subId = implode(',', $sub_id);
        $pathology_sub_arr = array();
        $check_dupliate = array();


        foreach ($pathology_sub as $key => $ps) {
            $sid = $ps->id;


            if ($from_n < "2074-07-21" && $to_n < "2074-07-21") {
                $pathology_test = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                    ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                    ->select('billing_detail.*', 'test_detail.*', 'categories.title')
                    ->where('categories.level', '3')
                    ->where('categories.status', 'Active')
                    ->where('categories.parent_id', $sid)
                    ->where('billing_detail.user_id', $uid)
                    ->where('billing_detail.date', '>=', $fromn)
                    ->where('billing_detail.date', '<=', $ton)
                    //->where('billing_detail.status', 'Active')
                    ->groupBy('billing_detail.patient_id')
                    ->get();
            } else if ($from_n >= "2074-07-21" && $to_n >= "2074-07-21") {
                $pathology_test = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                    ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                    ->select('billing_detail.*', 'test_detail.*', 'categories.title')
                    ->where('categories.level', '3')
                    ->where('categories.status', 'Active')
                    ->where('categories.parent_id', $sid)
                    ->where('billing_detail.user_id', $uid)
                    ->where('billing_detail.date', '>=', $fromn)
                    ->where('billing_detail.date', '<=', $ton)
                    //->where('billing_detail.status', 'Active')
                    ->groupBy('billing_detail.bill_number')
                    ->get();
            } else {

            }


            foreach ($pathology_test as $akey => $val) {
                $pid = $val->patient_id;
                $patient_name = IPatient::where('id', $pid)->select('first_name', 'middle_name', 'last_name')->get();
                $pname = @$patient_name[0]->first_name . ' ' . @$patient_name[0]->middle_name . ' ' . @$patient_name[0]->last_name;

                $pathology_test[$akey]->patient_name = $pname;
                $pathology_test[$akey]->patient_id = $pid;

                $detail = IPatient::where('id', $pid)->select('patient_code')->get();
                $pathology_test[$akey]->patient_code = $detail[0]->patient_code;
            }


            if (!empty($pathology_test)) {
                foreach ($pathology_test as $pkey => $pt) {
                    if (!in_array($pt->patient_id, $check_dupliate)) {
                        $check_dupliate[] = $pt->patient_id;

                        //$total_fee = Billing::where('patient_id', $pt->patient_id)->where('status', 'Active')->where('date', '>=', $date)->where('date', '<=', $date_to)->sum('sub_total');

                        $total_fee = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                            ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                            ->select('categories.title')
                            ->whereIn('categories.parent_id', $sub_id)
                            ->where('billing_detail.patient_id', $pt->patient_id)
                            ->where('categories.status', 'Active')
                            ->where('categories.level', 3)
                            ->where('billing_detail.date', '>=', $fromn)
                            ->where('billing_detail.date', '<=', $ton)
                            ->where('billing_detail.user_id', $uid)
                            ->sum('test_detail.test_price');

                        $test_list = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                            ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                            ->select('categories.title')
                            ->whereIn('categories.parent_id', $sub_id)
                            ->where('billing_detail.patient_id', $pt->patient_id)
                            ->where('categories.status', 'Active')
                            ->where('categories.level', 3)
                            ->where('billing_detail.date', '>=', $fromn)
                            ->where('billing_detail.date', '<=', $ton)
                            ->where('billing_detail.user_id', $uid)
                            ->get();

                        $test_names = '';
                        foreach ($test_list as $tkey => $tlist) {
                            $test_names .= $tlist->title . ', ';
                        }
                        $test_names = rtrim($test_names, ', ');
                        $test_names_arr = explode(', ', $test_names);
                        $test_names_arr = array_unique($test_names_arr);
                        $test_names = implode(', ', $test_names_arr);

                        $pathology_sub_arr[$key][$pkey]['name'] = $pt->patient_name;
                        $pathology_sub_arr[$key][$pkey]['fee'] = sprintf('%.02f', $total_fee);
                        $pathology_sub_arr[$key][$pkey]['test'] = $test_names;
                        $pathology_sub_arr[$key][$pkey]['referal_doctor'] = '';
                        $pathology_sub_arr[$key][$pkey]['patient_code'] = $pt->patient_code;
                        $hst = (5 / 100) * $total_fee;
                        $pathology_sub_arr[$key][$pkey]['hst'] = round($hst, 2);
                        $pathology_sub_arr[$key][$pkey]['grand'] = $total_fee + $hst;
                        $pathology_sub_arr[$key][$pkey]['bill'] = $pt->bill_number;
                        $pathology_sub_arr[$key][$pkey]['status'] = $pt->status;
                    }
                }
            }
        }


        /* report by subcategory */
        $consulting = 0;
        $test_subcat = Category::where('level', '2')->where('parent_id', '<>', 1)->where('status', 'Active')->orderBy('title', 'asc')->get();
        $test_res = array();
        foreach ($test_subcat as $key => $subcat) {
            $sid = $subcat->id;
            $stitle = $subcat->title;

            if ($from_n < "2074-07-21" && $to_n < "2074-07-21") {
                $test = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                    ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                    ->select('billing_detail.*', 'test_detail.*', 'categories.title')
                    ->where('categories.level', '3')
                    ->where('categories.parent_id', $sid)
                    ->where('categories.status', 'Active')
                    ->where('billing_detail.user_id', $uid)
                    ->where('billing_detail.date', '>=', $fromn)
                    ->where('billing_detail.date', '<=', $ton)
                    ->groupBy('billing_detail.patient_id')
                    ->get();
            } else if ($from_n >= "2074-07-21" && $to_n >= "2074-07-21") {
                $test = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                    ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                    ->select('billing_detail.*', 'test_detail.*', 'categories.title')
                    ->where('categories.level', '3')
                    ->where('categories.parent_id', $sid)
                    ->where('categories.status', 'Active')
                    ->where('billing_detail.user_id', $uid)
                    ->where('billing_detail.date', '>=', $fromn)
                    ->where('billing_detail.date', '<=', $ton)
                    ->groupBy('billing_detail.bill_number')
                    ->get();
            }

            foreach ($test as $key => $val) {
                $pid = $val->patient_id;
                $patient_name = IPatient::where('id', $pid)->select('first_name', 'middle_name', 'last_name')->get();
                $pname = @$patient_name[0]->first_name . ' ' . @$patient_name[0]->middle_name . ' ' . @$patient_name[0]->last_name;

                $test[$key]->patient_name = $pname;

                $detail = IPatient::where('id', $pid)->select('patient_code')->get();
                $test[$key]->key = $detail[0]->patient_code;
            }

            if (!empty($test)) {
                foreach ($test as $tkey => $tst) {
                    $test_res[$stitle][$tkey]['name'] = @$tst->patient_name;
                    $test_res[$stitle][$tkey]['fee'] = $tst->test_price;
                    $test_res[$stitle][$tkey]['test'] = $tst->title;
                    $test_res[$stitle][$tkey]['patient_code'] = $detail[0]->patient_code;
                    $hst = (5 / 100) * $tst->test_price;
                    $test_res[$stitle][$tkey]['hst'] = round($hst, 2);
                    $test_res[$stitle][$tkey]['grand'] = $tst->test_price + $hst;
                    $test_res[$stitle][$tkey]['bill'] = $tst->bill_number;
                    $test_res[$stitle][$tkey]['status'] = $tst->status;
                    if ($consulting == 0)
                        $test_res[$stitle][$tkey]['referal_doctor'] = '';
                    else
                        $test_res[$stitle][$tkey]['referal_doctor'] = $tst->first_name . ' ' . $tst->middle_name . ' ' . $tst->last_name;
                }
            }
        }

        return view('backendview.calculation.user_detail_revenue', compact('from_n', 'to_n', 'user', 'opd', 'ipd', 'emergency', 'pathology_sub_arr', 'test_res', 'title'));
    }


    /* total revenue collected */

    /* OPD */
    public function totalRevenue()
    {
        $category = Category::where('level', '1')->where('status', 'Active')->where('id', '<>', 1)->where('id', '<>', 165)->orderBy('title')->get();
        $rep = 0;

        return view('backendview.calculation.total_revenue', compact('category', 'rep'));
    }

    public function operateTotalRevenue(Request $request)
    {
        $rep = 1;

        $date_from = $request->get('from');
        $date_to = $request->get('to');


        /* convert nepali date to english */
        $localDate = str_replace("/", "-", $date_from);
        $classes = explode("-", $localDate);

        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $dateFrom = nep_to_eng($a, $b, $c);

        $localDate = str_replace("/", "-", $date_to);
        $classes = explode("-", $localDate);

        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $dateTo = nep_to_eng($a, $b, $c);

        $from = $dateFrom . " 00:00:00";
        $to = $dateTo . " 23:59:59";

        /* opd */
        $opd = iPatient::leftJoin('doctors', 'ipatient.doctor_id', '=', 'doctors.id')
            ->leftJoin('users', 'ipatient.user_id', '=', 'users.id')
            ->select('ipatient.*', 'doctors.first_name as fname', 'doctors.middle_name as mname', 'doctors.last_name as lname', 'users.fullname')
            ->where('ipatient.patient_type', 'OPD')
            ->where('ipatient.refund_status', 'Active')
            ->where('ipatient.created_at', '<=', $to)
            ->where('ipatient.created_at', '>=', $from)
            ->get();

        /* emergency */
        $emergency = iPatient::leftJoin('doctors', 'ipatient.doctor_id', '=', 'doctors.id')
            ->leftJoin('users', 'ipatient.user_id', '=', 'users.id')
            ->leftJoin('ward', 'ipatient.ward_id', '=', 'ward.id')
            ->leftJoin('room', 'ipatient.room_id', '=', 'room.id')
            ->leftJoin('bed', 'ipatient.bed_id', '=', 'bed.id')
            //->leftjoin('billing_detail', 'ipatient.id', '=', 'billing_detail.patient_id')
            ->select('ipatient.*', 'doctors.first_name as fname', 'doctors.middle_name as mname', 'doctors.last_name as lname', 'users.fullname', 'ward.ward_name', 'room.room_name', 'bed.bed_name')
            ->where('ipatient.patient_type', 'Emergency')->where('ipatient.refund_status', 'Active')
            ->where('ipatient.created_at', '<=', $to)
            ->where('ipatient.created_at', '>=', $from)
            //->groupBy('patient_id')
            ->get();

        foreach ($emergency as $key => $emr) {
            $emr_test = iPatient::leftjoin('billing_detail', 'ipatient.id', '=', 'billing_detail.patient_id')
                ->select('billing_detail.sub_total', 'billing_detail.tax', 'billing_detail.grand_total')
                ->where('billing_detail.patient_type', 'Emergency')
                ->where('billing_detail.patient_id', $emr->id)
                ->first();

            if (isset($emr_test)) {
                $emergency[$key]->sub_total = $emr_test->sub_total;
                $emergency[$key]->tax = $emr_test->tax;
                $emergency[$key]->grand_total = $emr_test->grand_total;
            }
        }


        /* ipd */
        $ipd = iPatient::leftJoin('doctors', 'ipatient.doctor_id', '=', 'doctors.id')
            ->leftJoin('users', 'ipatient.user_id', '=', 'users.id')
            ->select('ipatient.*', 'doctors.first_name as fname', 'doctors.middle_name as mname', 'doctors.last_name as lname', 'users.fullname')
            ->where('ipatient.patient_type', 'IPD')->where('ipatient.refund_status', 'Active')
            ->where('ipatient.created_at', '<=', $to)
            ->where('ipatient.created_at', '>=', $from)
            ->get();

        foreach ($ipd as $key => $val) {
            $id = $val->id;

            /* ipd ward, room and bed */
            $wrb = DB::table('ipd_patient_ward')->leftJoin('ward', 'ipd_patient_ward.ward_id', '=', 'ward.id')
                ->leftJoin('room', 'ipd_patient_ward.room_id', '=', 'room.id')
                ->leftJoin('bed', 'ipd_patient_ward.bed_id', '=', 'bed.id')
                ->select('ipd_patient_ward.*', 'ward.ward_name', 'room.room_name', 'bed.bed_name')
                ->where('patient_id', $id)
                ->get();

            $list = '';
            if (count($wrb) > 0) {
                foreach ($wrb as $detail) {
                    $ward = $detail->ward_name;
                    $room = $detail->room_name;
                    $bed = $detail->bed_name;
                    $list .= $ward . '/' . $room . '/' . $bed . ', ';
                }
            }
            $ipd[$key]->ward_detail = rtrim($list, ', ');

            $dis_detail = DB::table('discharge_details')
                ->select('discharge_details.*')
                ->where('ipatient_id', $id)
                ->first();

            if (count($dis_detail)) {
                $total_after_discharge = $dis_detail->total_after_tax;
            } else {
                $total_after_discharge = 0;
            }

            $val->total_after_discharge = $total_after_discharge;


            $deposit_amounts = $val->deposit_amount;
            $dep_amt_arr = explode(',', $deposit_amounts);

            $total_deposit = 0;
            foreach ($dep_amt_arr as $key1 => $deposit) {
                $total_deposit += $deposit;
            }

            $val->total_deposit = $total_deposit;

            /* doctor and fee history */
            $doc_history = DB::table('i_patient_histories')
                ->leftJoin('doctors', 'i_patient_histories.doctor_id', '=', 'doctors.id')
                ->select('i_patient_histories.doctor_fee', 'doctors.first_name', 'doctors.middle_name', 'doctors.last_name')
                ->where('i_patient_histories.ipatient_id', $id)
                ->get();

            $doc_list = '';
            $round_fee = 0;
            if (count($doc_history) > 0) {
                foreach ($doc_history as $val) {
                    $doc_name = $val->first_name . ' ' . $val->middle_name . ' ' . $val->last_name;
                    $round_fee += $val->doctor_fee;
                    $doc_list .= $doc_name . ', ';
                }
            }
            $ipd[$key]->round_doctors = rtrim($doc_list, ', ');
            $ipd[$key]->round_doctor_fee = $round_fee;
        }

        /* tests */
        if ($date_from < "2074-07-21" && $date_to < "2074-07-21") {
            $tests = Billing::leftJoin('users', 'billing_detail.user_id', '=', 'users.id')
                ->leftJoin('doctors', 'billing_detail.doctor_id', '=', 'doctors.id')
                ->leftJoin('ipatient', 'billing_detail.patient_id', '=', 'ipatient.id')
                ->select('billing_detail.*', 'users.fullname', 'doctors.first_name as fname', 'doctors.middle_name as mname', 'doctors.last_name as lname', 'ipatient.first_name as patient_name', 'ipatient.patient_code')
                ->where('billing_detail.patient_type', 'test')
                ->where('billing_detail.status', 'Active')
                ->where('billing_detail.date', '>=', $from)
                ->where('billing_detail.date', '<=', $to)
                //->groupBy('billing_detail.patient_id')
                ->get();

        } else if ($date_from >= "2074-07-21" && $date_to >= "2074-07-21") {
            $tests = Billing::leftJoin('users', 'billing_detail.user_id', '=', 'users.id')
                ->leftJoin('doctors', 'billing_detail.doctor_id', '=', 'doctors.id')
                ->leftJoin('ipatient', 'billing_detail.patient_id', '=', 'ipatient.id')
                ->select('billing_detail.*', 'users.fullname', 'doctors.first_name as fname', 'doctors.middle_name as mname', 'doctors.last_name as lname', 'ipatient.first_name as patient_name', 'ipatient.patient_code')
                ->where('billing_detail.patient_type', 'test')
                ->where('billing_detail.status', 'Active')
                ->where('billing_detail.date', '>=', $from)
                ->where('billing_detail.date', '<=', $to)
                ->groupBy('billing_detail.bill_number')
                ->get();
        }

        foreach ($tests as $key => $val) {
            $bid = $val->bid;
            $test_list = '';
            $test_detail = TestDetail::leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                ->where('test_detail.bid', $bid)
                ->where('categories.level', 3)
                ->get();

            foreach ($test_detail as $detail) {
                $test_list .= $detail->title . ', ';
            }
            $tests[$key]->test_list = rtrim($test_list, ', ');
        }


        return view('backendview.calculation.total_revenue', compact('rep', 'opd', 'emergency', 'ipd', 'tests', 'date_from', 'date_to', 'total_after_discharge'));
    }


}