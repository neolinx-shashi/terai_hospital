<?php

namespace App\Http\Controllers\BackEndController;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Repository\DashboardRepo;
use App\Models\BloodGroup;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\EmergencyPatient;
use App\Models\IPatient;
use App\Models\Nationality;
use App\Models\ConsultingFee;
use App\Models\Billing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorShift;
use App\Models\ShiftDoctor;
use App\Models\DayName;
use App\Http\Requests\PatientRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * @var User
     */
//    private $user;
    /**
     * @var Feedback
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $patient;
    private $nationality;
    private $doctor;
    private $department;
    private $consultingFee;
    private $shift;
    private $shiftDoctor;
    private $dayName;
    private $billing;
    private $dashboardRepo;

    public function __construct(Patient $patient,
                                Nationality $nationality,
                                Doctor $doctor,
                                Department $department,
                                ConsultingFee $consultingFee,
                                DoctorShift $shift,
                                ShiftDoctor $shiftDoctor,
                                DayName $dayName,
                                Billing $billing,
                                DashboardRepo $dashboardRepo)
    {
        $this->middleware('auth');
        $this->patient = $patient;
        $this->nationality = $nationality;
        $this->doctor = $doctor;
        $this->department = $department;
        $this->consultingFee = $consultingFee;
        $this->billing = $billing;

        $this->shift = $shift;
        $this->shiftDoctor = $shiftDoctor;
        $this->dayName = $dayName;
        $this->dashboardRepo = $dashboardRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wardDetails = $this->dashboardRepo->getWardDetails();
        $room = $this->dashboardRepo->roomDetails();
        $beds = $this->dashboardRepo->bedDetails();
        $contacts = $this->dashboardRepo->getTotalContact();
        $tests = $this->dashboardRepo->getAllTests();
        $users = $this->dashboardRepo->getallUsers();
        $userHistory = $this->dashboardRepo->getUserHistory();


        $dayData = date("l");

        $nurseListToday = DB::table('day_name')
            ->join('tbl_shift', 'day_name.id', '=', 'tbl_shift.day_id')
            ->join('nurse_shift_relation', 'tbl_shift.id', '=', 'nurse_shift_relation.shift_id')
            ->join('nurses', 'nurse_shift_relation.nurse_id', '=', 'nurses.id')
            ->select('day_name.*', 'nurses.id as nurseId',
                'nurses.first_name',
                'nurses.middle_name',
                'nurses.last_name',
                'nurse_shift_relation.*', 'tbl_shift.*')
            ->groupBy('nurses.id')
            ->where('day_name.name', '=', $dayData)
            ->get();


        $doctorListToday = DB::table('day_name')
            ->join('tbl_shift', 'day_name.id', '=', 'tbl_shift.day_id')
            ->join('doctor_shift_relation', 'tbl_shift.id', '=', 'doctor_shift_relation.shift_id')
            ->join('doctors', 'doctor_shift_relation.doctor_id', '=', 'doctors.id')
            ->select('day_name.*', 'doctors.id as doctorId',
                'doctors.first_name',
                'doctors.middle_name',
                'doctors.last_name',
                'doctor_shift_relation.*', 'tbl_shift.*')
            ->groupBy('doctors.id')
            ->where('day_name.name', '=', $dayData)
            ->get();


        $totalShiftListOfDay = DB::table('day_name')
            ->join('tbl_shift', 'day_name.id', '=', 'tbl_shift.day_id')
            ->join('doctor_shift_relation', 'tbl_shift.id', '=', 'doctor_shift_relation.shift_id')
            ->join('doctors', 'doctor_shift_relation.doctor_id', '=', 'doctors.id')
            ->select('day_name.*', 'doctors.id as doctorAllId', 'doctors.first_name as Fname', 'doctor_shift_relation.*', 'tbl_shift.*')
            ->where('day_name.name', '=', $dayData)
            ->get();


        $test = $this->billing
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('date', '=', Carbon::now()->toDateString())
            ->where('status', 'Active')
            ->sum('grand_total');

        $checkUp = DB::table('ipatient')
            ->where('refund_status', 'Active')
            ->where('patient_type', '=', 'OPD')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->sum('doctor_fee_with_tax');


        $emergencyPatientData = DB::table('ipatient')
            ->where('patient_type', '=', 'Emergency')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->sum('doctor_fee_with_tax');

        $deposits = DB::table('ipatient')
            ->whereDate('updated_at', '=', Carbon::now()->toDateString())
            ->get();

        $total_deposit = 0;
        foreach($deposits as $key => $deposit)
        {
            $deposit_amounts = $deposit->deposit_amount;
            $dep_amt_arr = explode(',', $deposit_amounts);

            $deposit_dates = $deposit->deposit_dates;
            $dep_date_arr = explode(',', $deposit_dates);

            $deposit_user_id = $deposit->deposit_user_id;
            $dep_id_arr = explode(',', $deposit_user_id);

            foreach ($dep_id_arr as $key1 => $id)
            {
                if ($dep_date_arr[$key1] == Carbon::now()->toDateString() && $id == Auth::user()->id)
                {
                    $total_deposit += $dep_amt_arr[$key1];
                }
            }
        }

        $ipdadmissionData = DB::table('ipatient')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->sum('admission_charge_with_tax');

        $ipd_discharge_received = DB::table('discharge_details')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->sum('received_amount');

        $ipd_discharge_returned = DB::table('discharge_details')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->sum('returned_amount');

        $total = $test + $checkUp + $total_deposit + $emergencyPatientData + $ipdadmissionData + $ipd_discharge_received - $ipd_discharge_returned;

        $getEmergencyDoctors = DB::table('doctors')
            ->join('departments', 'doctors.department_id', '=', 'departments.id')
            ->join('doctor_shift_relation', 'doctors.id', '=', 'doctor_shift_relation.doctor_id')
            ->join('tbl_shift', 'doctor_shift_relation.shift_id', '=', 'tbl_shift.id')
            ->join('day_name', 'tbl_shift.day_id', '=', 'day_name.id')
            ->select('doctors.id as doctorId', 'tbl_shift.id as shitId', 'tbl_shift.day_id')
            ->where('departments.name', '=', 'emergency')
            ->where('day_name.name', '=', $dayData)
            ->get();

        $getMyPatientsToday = DB::table('ipatient')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('user_id', '=', Auth::user()->id)
            ->where('refund_status', 'Active')
            ->where('patient_type', '=', 'OPD')
            ->orwhere('patient_type', '=', 'renew')
            ->count();

        $testPatientsTodayOnly = DB::table('billing_detail')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('user_id', '=', Auth::user()->id)
            ->where('patient_type', '=', 'test')
            ->where('status', '=', 'active')
            ->count();

        $getMyIPDPatientsToday = DB::table('ipatient')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('user_id', '=', Auth::user()->id)
            ->where('patient_type', 'IPD')
            ->count();

        $refundedOPDPatientsToday = $this->patient
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('user_id', '=', Auth::user()->id)
            ->where('patient_type', '=', 'OPD')
            ->where('refund_status', '=', 'Inactive')
            ->count();

        $refundedTestPatientsToday = $this->billing
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('user_id', '=', Auth::user()->id)
            ->where('status', '=', 'Inactive')
            ->count();

        $refundedPatientsToday = $refundedOPDPatientsToday + $refundedTestPatientsToday;

        $nationality = $this->nationality->all();
        $departments = $this->department->all();
        $doctors = $this->doctor->all();
        $nurses = Nurse::all();
        $consultingFee = $this->consultingFee->all();

        $pieData = DB::table('ipatient')
            ->select('ipatient.gender as gender', DB::raw('count(*) as genderPieData'))
            ->groupBy('gender')
            ->get();

        $genderPieData = array();
        foreach ($pieData as $members) {
            $genderPieData[] = [$members->gender, (int)$members->genderPieData];
        }

        $pieDataAuthUser = DB::table('ipatient')
            ->select('ipatient.gender as gender', DB::raw('count(*) as genderPieDataAuthUser'))
            ->where('user_id', Auth::user()->id)
            ->groupBy('gender')
            ->get();


        $genderPieDataUserOnly = array();
        foreach ($pieDataAuthUser as $members) {
            $genderPieDataUserOnly[] = [$members->gender, (int)$members->genderPieDataAuthUser];
        }

        $totalOnDutyDoctorToday = DB::table('day_name')
            ->join('tbl_shift', 'day_name.id', '=', 'tbl_shift.day_id')
            ->join('doctor_shift_relation', 'tbl_shift.id', '=', 'doctor_shift_relation.shift_id')
            ->join('doctors', 'doctor_shift_relation.doctor_id', '=', 'doctors.id')
            ->select('day_name.*', 'doctors.id as doctorAllId', 'doctors.first_name as Fname', 'doctor_shift_relation.*', 'tbl_shift.*')
            ->where('day_name.name', '=', $dayData)
            ->count();

        $department = DB::table('departments')
            ->where('name', 'Emergency')
            ->first();

        $emergencyPatient = DB::table('ipatient')
            ->where('user_id', Auth::user()->id)
            ->where('department_id', $department->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('patient_type', 'Emergency')
            ->count();

        $emergencyContact = DB::table('contacts')
            ->where('type', 'emergency')
            ->get();

        /*Total Revenue Collection*/
        /* opd */
        $opd = DB::table('ipatient')
            ->leftJoin('doctors', 'ipatient.doctor_id', '=', 'doctors.id')
            ->leftJoin('users', 'ipatient.user_id', '=', 'users.id')
            ->select('ipatient.*', 'doctors.first_name as fname', 'doctors.middle_name as mname', 'doctors.last_name as lname', 'users.fullname')
            ->where('ipatient.patient_type', 'OPD')
            ->where('ipatient.refund_status', 'Active')
            ->whereDate('ipatient.created_at', '=', Carbon::now()->toDateString())
            ->sum('doctor_fee_with_tax');

        /* emergency */
        $emergency = iPatient::leftJoin('doctors', 'ipatient.doctor_id', '=', 'doctors.id')
            ->leftJoin('users', 'ipatient.user_id', '=', 'users.id')
            ->leftJoin('ward', 'ipatient.ward_id', '=', 'ward.id')
            ->leftJoin('room', 'ipatient.room_id', '=', 'room.id')
            ->leftJoin('bed', 'ipatient.bed_id', '=', 'bed.id')
            ->select('ipatient.*', 'doctors.first_name as fname', 'doctors.middle_name as mname', 'doctors.last_name as lname', 'users.fullname', 'ward.ward_name', 'room.room_name', 'bed.bed_name')
            ->where('ipatient.patient_type', 'Emergency')->where('ipatient.refund_status', 'Active')
            ->whereDate('ipatient.created_at', '=', Carbon::now()->toDateString())
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

        $emr_charge = $emr_test = 0;
        foreach ($emergency as $emr) {
            $emr_charge += $emr->doctor_fee_with_tax;
            $emr_test += $emr->grand_total;
        }
        $emergency_total = $emr_charge + $emr_test;

        /* ipd */
        $ipd = iPatient::leftJoin('doctors', 'ipatient.doctor_id', '=', 'doctors.id')
            ->leftJoin('users', 'ipatient.user_id', '=', 'users.id')
            ->select('ipatient.*', 'doctors.first_name as fname', 'doctors.middle_name as mname', 'doctors.last_name as lname', 'users.fullname')
            ->where('ipatient.patient_type', 'IPD')->where('ipatient.refund_status', 'Active')
            ->whereDate('ipatient.created_at', '=', Carbon::now()->toDateString())
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

        $ipd_total = 0;
        foreach ($ipd as $key => $data) {
            $discharge_total = DB::table('ipatient')
                ->leftJoin('discharge_details', 'discharge_details.ipatient_id', '=', 'ipatient.id')
                //->select('discharge_details.total_after_tax', 'ipatient.*')
                ->where('discharge_details.ipatient_id', $data->id)
                ->sum('total_after_tax');

            //$ipd_total += $discharge_total + $data->deposit_amount;
            $ipd_total += $discharge_total + $data->deposit_amount + $data->admission_charge_with_tax;
        }

        /****** */
        $ipd_discharge_received_1 = DB::table('discharge_details')
        ->whereDate('created_at', '=', Carbon::now()->toDateString())
        ->sum('received_amount');

    $ipd_discharge_returned_1 = DB::table('discharge_details')
        ->whereDate('created_at', '=', Carbon::now()->toDateString())
        ->sum('returned_amount');
        /***** */

        /* tests */
        $test = Billing::leftJoin('users', 'billing_detail.user_id', '=', 'users.id')
            ->leftJoin('doctors', 'billing_detail.doctor_id', '=', 'doctors.id')
            ->leftJoin('ipatient', 'billing_detail.patient_id', '=', 'ipatient.id')
            ->select('billing_detail.*', 'users.fullname', 'doctors.first_name as fname', 'doctors.middle_name as mname', 'doctors.last_name as lname', 'ipatient.first_name as patient_name', 'ipatient.patient_code')
            ->where('billing_detail.status', 'Active')
            ->whereDate('billing_detail.created_at', '=', Carbon::now()->toDateString())
            ->sum('grand_total');

        $revenue = $opd + $emergency_total + $ipd_total + $test + $ipd_discharge_received_1 -  $ipd_discharge_returned_1;

        return view('backendview.dashboard.index', compact(
            'nationality',
            'doctors',
            'departments',
            'consultingFee',
            'total',
            'doctorListToday',
            'totalShiftListOfDay',
            'getMyPatientsToday',
            'getEmergencyDoctors',
            'genderPieData',
            'genderPieDataUserOnly',
            'refundedPatientsToday',
            'totalOnDutyDoctorToday',
            'nurses',
            'getMyIPDPatientsToday',
            'emergencyPatient',
            'testPatientsTodayOnly',
            'emergencyContact',
            'nurseListToday',
            'wardDetails',
            'room',
            'beds',
            'contacts',
            'tests',
            'users',
            'userHistory',
            'revenue'
        ));
    }


    public function getTodayShiftDoctorList($id)
    {
        $dayData = date("l");
        $totalShiftListOfDay = DB::table('day_name')
            ->join('tbl_shift', 'day_name.id', '=', 'tbl_shift.day_id')
            ->join('doctor_shift_relation', 'tbl_shift.id', '=', 'doctor_shift_relation.shift_id')
            ->join('doctors', 'doctor_shift_relation.doctor_id', '=', 'doctors.id')
            ->select('day_name.*', 'doctors.id as doctorAllId', 'doctors.first_name as Fname', 'doctor_shift_relation.*', 'tbl_shift.*')
            ->where('day_name.name', '=', $dayData)
            ->where('doctors.id', '=', $id)
            ->get();

        echo '<table class="table table-hover table-bordered table-striped">';
        echo '<thead>';

        echo '<strong></strong>';

        echo '<tr>';
        // echo  '<th>S.N</th>';
        echo '<th>Start time</th>';
        echo '<th>End Time</th>';
        echo '<th>Shift Type</th>';
        echo '</tr>';

        echo '</thead>';
        foreach ($totalShiftListOfDay as $file) {
            echo '<tr>';
            $start_time_str = $file->start_time;
            $regular_time_str = date('g:i A', strtotime($start_time_str));

            $end_time_str = $file->end_time;
            $endTime = date('g:i A', strtotime($end_time_str));

            // echo '<td>'.$file->id.'</td>';
            echo '<td>' . $regular_time_str . '</td>';
            echo '<td>' . $endTime . '</td>';
            echo '<td>' . ucfirst($file->shift_type) . '</td>';
            echo '</tr>';

        }
        echo '</table>';
    }


    public function globalSearch()
    {
        $q = Input::get('q');

        if (is_null($q)) {


            return view('backendview.global_search.emptyresults');
        } else {

            $opdPatients = EmergencyPatient::
            whereIn('id', function ($query) {
                $query->select(DB::raw("MAX(id)"))
                    ->from('ipatient')
                    ->groupBy('patient_code');
            })
                ->where(function ($query) use ($q) {
                    $query->orWhere('phone', 'like', '%' . $q . '%')
                        ->orWhere('first_name', 'like', '%' . $q . '%')
                        ->orWhere('last_name', 'like', '%' . $q . '%')
                        ->orWhere('patient_code', 'like', '%' . $q . '%')
                        ->orWhere('patient_type', 'LIKE', '%' . $q . '%')
                        ->orWhere('created_at', 'like', '%' . $q . '%');


                })
                ->get();

            $testPatients = EmergencyPatient::where('patient_type', '=', 'test')
                ->whereIn('id', function ($query) {
                    $query->select(DB::raw("MAX(id)"))
                        ->from('ipatient')
                        ->groupBy('patient_code');
                })
                ->where(function ($query) use ($q) {
                    $query->orWhere('phone', 'like', '%' . $q . '%')
                        ->orWhere('first_name', 'like', '%' . $q . '%')
                        ->orWhere('last_name', 'like', '%' . $q . '%')
                        ->orWhere('patient_code', 'like', '%' . $q . '%')
                        ->orWhere('patient_type', 'LIKE', '%' . $q . '%')
                        ->orWhere('created_at', 'like', '%' . $q . '%');


                })
                ->paginate(10);


            if (count($opdPatients) > 0)
                return view('backendview.global_search.opdsearch')
                    ->withDetails($opdPatients)->withQuery($q);

            elseif (count($testPatients) > 0)
                return view('backendview.global_search.testsearch')
                    ->withDetails($testPatients)->withQuery($q);


            else return view('backendview.global_search.emptyresults')
                ->withMessage('No Details found. Try to search again !');

        }

    }

}
