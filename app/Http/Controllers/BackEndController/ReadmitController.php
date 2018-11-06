<?php

namespace App\Http\Controllers\BackEndController;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\TestPatient;
use App\Models\Nationality;
use App\Models\ConsultingFee;
use App\Models\Category;
use App\Models\Billing;
use App\Models\FiscalYear;
use App\Models\TestDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use DB;
use URL;
use App\Models\Ward;
use App\Models\Room;
use App\Models\Bed;
use Carbon\Carbon;
use App\Models\EmergencyPatient;
use App\Models\EmergencyFee;
use App\Models\IPatient;
use App\Models\IPDAdmissionCharge;
use Response;
use Illuminate\Support\Facades\Redirect;


class ReadmitController extends Controller
{

    private $patient;
    private $nationality;
    private $doctor;
    private $department;
    private $consultingFee;
    private $fiscalYear;
    private $billing;
    private $ward;
    private $room;
    private $bed;
    private $emergencyPatient;
    private $category;
    private $emergencyFee;
    private $iPatient;
    private $admissionCharge;

    public function __construct(Patient $patient,
                                Nationality $nationality,
                                Doctor $doctor,
                                Department $department,
                                ConsultingFee $consultingFee,
                                FiscalYear $fiscalYear,
                                Billing $billing,
                                Ward $ward,
                                Room $room,
                                Bed $bed,
                                EmergencyPatient $emergencyPatient,
                                Category $category,
                                EmergencyFee $emergencyFee,
                                IPDAdmissionCharge $admissionCharge,
                                IPatient $iPatient)
    {
        $this->middleware('auth');
        $this->patient = $patient;
        $this->nationality = $nationality;
        $this->doctor = $doctor;
        $this->department = $department;
        $this->consultingFee = $consultingFee;
        $this->today = date("Y-m-d");
        $this->fiscalYear = $fiscalYear;
        $this->billing = $billing;
        $this->ward = $ward;
        $this->room = $room;
        $this->bed = $bed;
        $this->emergencyPatient = $emergencyPatient;
        $this->category = $category;
        $this->emergencyFee = $emergencyFee;
        $this->iPatient = $iPatient;
        $this->admissionCharge = $admissionCharge;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reAdmitPatient($id)
    {
        $id = (int)$id;

        $editPatients = $this->patient->findOrFail($id);

        $nationality = $this->nationality->all();

        $doctors = $this->doctor
            ->where('status', 'Active')
            ->get();

        $departments = $this->department->all();

        $patients = $this->patient
            ->where('id', $id)
            ->paginate();

        $wards = $this->ward
            ->where('ward_name', 'Emergency')
            ->first();

        $rooms = $this->room
            ->where('ward_id', $wards->id)
            ->orderBy('room_name', 'DSC')
            ->first();

        $beds = $this->bed
            ->where('availability', 'Available')
            ->where('room_id', $rooms->id)
            ->orderBy('id', 'ASC')
            ->get();

        $availableBeds = $this->bed
            ->where('availability', 'Available')
            ->where('room_id', $rooms->id)
            ->count();

        $totalBeds = $this->bed
            ->where('ward_id', $wards->id)
            ->count();

        $emergencyFee = $this->emergencyFee
            ->where('current_emergency_fee', 'Y')
            ->first();

        $departmentByName = $this->department
            ->where('name', 'Emergency')
            ->first();

        $doctorByDepartment = $this->doctor
            ->where('department_id', $departmentByName->id)
            ->where('status', 'Active')
            ->orderBy('created_at', 'DSC')
            ->get();


        $wardsIpd = $this->ward
            ->where('ward_name', '!=', 'Emergency')
            ->get();

        $roomsIpd = $this->room->all();

        $bedsIpd = $this->bed->all();

        return view('backendview.readmitPatient.index', compact('editPatients',
            'doctors',
            'departments',
            'nationality',
            'patients',
            'wards',
            'rooms',
            'beds',
            'availableBeds',
            'totalBeds',
            'emergencyFee',
            'doctorByDepartment',
            'wardsIpd',
            'roomsIpd',
            'bedsIpd'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this
     */
    public function readmitOpdSection(Request $request, $id)
    {
        $id = (int)$id;

        $input = $request->all();


        try {
            if ($request->all()) {
                $user_id = Auth::user()->id;
                $input['user_id'] = $user_id;
                $input['patient_type'] = 'OPD';
                $input['status'] = 'OPD';
                $doctor_fee = Input::get('doctor_fee');

                $discount_percent = Input::get('discount_percent');

                $discountedValue = ($discount_percent / 100) * $doctor_fee;

                $input['discounted_fee_value'] = $discountedValue;

                $feeAfterTax = $doctor_fee - $discountedValue;

                $taxPercentage = (5 / 100) * $feeAfterTax;

                $input['doctor_tax_only'] = $taxPercentage;


                $totalFeeWithTax = $taxPercentage + $feeAfterTax;

                $input['doctor_fee_with_tax'] = round($totalFeeWithTax);
                $fiscalYear = $this->fiscalYear
                    ->where('current_fiscal_year', 'Y')
                    ->first();

                $input['fiscal_year_id'] = $fiscalYear->id;

                /* bill number */
                $billNumber = DB::table('bill_number')->max('bill_id');
                if ($billNumber)
                    $currentBillNumber = $billNumber + 1;
                else
                    $currentBillNumber = 1;

                $input['bill_number'] = $currentBillNumber;

                $patientId = Patient::create($input);
                $insertedPatientId = $patientId->id;

                DB::table('bill_number')->insert(['bill_fy' => $fiscalYear->id]);

                session()->put('opd_patient_readmit', $insertedPatientId);

                session()->flash('success', 'Patient Readmitted to OPD Successfully');
                return redirect('re-admit/patient/' . $id . ' ')
                    ->withInput();
                //      $url = URL::to('/').'#loginModal';
                // return redirect::to($url);
            } else {
                return redirect()
                    ->back()
                    ->withInput();
            }
        } catch
        (Exception $e) {
            session()->flash('error', 'Sorry Unable to handle the request');
        }

    }

    /**
     * @param Request $request
     * @param $id
     * @return $this
     */
    public function readmitEmergencyPatient(Request $request, $id)
    {

        $id = (int)$id;

        $input = $request->all();
        $bedId = $request->input('bed_id');
        try {
            if ($request->all()) {

                $departments = $this->department
                    ->where('name', 'Emergency')
                    ->first();

                $user_id = Auth::user()->id;
                $input['user_id'] = $user_id;
                $input['patient_type'] = 'Emergency';
                $doctor_fee = Input::get('doctor_fee');


                $emergencyFee = $this->emergencyFee
                    ->where('current_emergency_fee', 'Y')
                    ->first();

                $input['doctor_fee'] = $emergencyFee->emergency_fee;

                $emergencyDoctorFee = $emergencyFee->emergency_fee;

                $taxPercentage = (5 / 100) * $emergencyDoctorFee;

                $input['doctor_tax_only'] = round($taxPercentage, 2);
                $input['doctor_fee_with_tax'] = round($taxPercentage + $emergencyDoctorFee);


                // $input['doctor_fee'] = round($totalFeeWithTax);
                $fiscalYear = $this->fiscalYear
                    ->where('current_fiscal_year', 'Y')
                    ->first();

                $input['fiscal_year_id'] = $fiscalYear->id;
                $input['status'] = 'Emergency';

                $departments = $this->department
                    ->where('name', 'Emergency')
                    ->first();


                $input['department_id'] = $departments->id;

                $wards = $this->ward
                    ->where('ward_name', 'Emergency')
                    ->first();


                /* bill number */
                $billNumber = DB::table('bill_number')->max('bill_id');
                if ($billNumber)
                    $currentBillNumber = $billNumber + 1;
                else
                    $currentBillNumber = 1;

                $input['bill_number'] = $currentBillNumber;

                $input['ward_id'] = $departments->id;
                $patientId = EmergencyPatient::create($input);
                $insertedPatientId = $patientId->id;

                /* bill number increament */
                DB::table('bill_number')->insert(['bill_fy' => $fiscalYear->id]);

                // session()->put('emergency_patient_today', $insertedPatientId);


                DB::table('bed')
                    ->where('id', $bedId)
                    ->update(['availability' => 'Unavailable']);


                $response = array(
                    'status' => 'success',
                    'msg' => 'Emergency Patient Admitted successfully',
                    'emergency' => $insertedPatientId,

                );

                return Response::json($response);

                // session()->flash('success', 'Patient Readmitted to emergency Successfully');
                // return redirect('re-admit/patient/'.$id .'')
                //     ->withInput();
                //      $url = URL::to('/').'#loginModal';
                // return redirect::to($url);
            } else {
                return redirect()
                    ->back()
                    ->withInput();
            }
        } catch
        (Exception $e) {
            session()->flash('error', 'Sorry Unable to handle the request');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function readmitIpdPatient(Request $request, $id)
    {
        $input = $request->all();

        $admissionCharge = $this->admissionCharge
            ->where('current_admission_charge', 'Y')
            ->first();
        $admChrg = $admissionCharge->admission_charge;
        $admChrgTax = 5 / 100 * $admChrg;
        $admChrgWithTax = $admChrg + $admChrgTax;

        try {
            if ($request->all()) {
                $user_id = Auth::user()->id;
                $input['user_id'] = $user_id;
                $input['patient_type'] = 'IPD';
                $input['admission_charge'] = $admChrg;
                $input['admission_charge_hst'] = $admChrgTax;
                $input['admission_charge_with_tax'] = $admChrgWithTax;

                $fiscalYear = $this->fiscalYear
                    ->where('current_fiscal_year', 'Y')
                    ->first();

                $input['fiscal_year_id'] = $fiscalYear->id;

                /* bill number */
                $billNumber = DB::table('bill_number')->max('bill_id');
                if ($billNumber)
                    $currentBillNumber = $billNumber + 1;
                else
                    $currentBillNumber = 1;

                $input['bill_number'] = $currentBillNumber;

                $test_deposit = $request->deposit_amount;
                if ($test_deposit != '') {
                    $input['deposit_dates'] = Carbon::now()->toDateString();
                    $input['deposit_user_id'] = Auth::user()->id;
                }

                $iPatient = iPatient::create($input);
                $ipatient_id = $iPatient->id;
                //session()->put('renew_ipatient', $ipatient_id);

                /* bill number increament */
                DB::table('bill_number')->insert(['bill_fy' => $fiscalYear->id]);

                $bed = $this->bed->findOrFail($request->bed_id);
                $bed->availability = 'Unavailable';
                $bed->save();

                /* ipd_patient_ward */
                DB::table('ipd_patient_ward')->where('patient_id', $ipatient_id)->update(['status' => 0]);

                $old_bed = $this->bed->findOrFail($input['bed_id']);
                $old_room_charge = $old_bed->isOfRoom->room_rate;

                $ward = array(
                    'patient_id' => $ipatient_id,
                    'ward_id' => $input['ward_id'],
                    'room_id' => $input['room_id'],
                    'bed_id' => $input['bed_id'],
                    'room_charge' => $old_room_charge,
                    'date_from' => Carbon::now(),
                    'status' => 1
                );

                DB::table('ipd_patient_ward')->insert($ward);

                $response = array(
                    'status' => 'success',
                    'msg' => 'IPD Patient Admitted successfully',
                    'ipdadmit' => $ipatient_id,

                );

                return Response::json($response);

                // session()->flash('success', ' Patient readmitted to IPD Successfully!');
                // return redirect('re-admit/patient/'.$id .'')
                //     ->withInput();
            } else {
                return redirect()
                    ->back();
            }
        } catch
        (Exception $e) {
            session()->flash('error', 'Sorry Unable to handle the request');
        }
    }
}
