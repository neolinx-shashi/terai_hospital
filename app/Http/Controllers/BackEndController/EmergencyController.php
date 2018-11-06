<?php

namespace App\Http\Controllers\BackEndController;

use App\Models\DiscountType;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\TestPatient;
use App\Models\EmergencyPatient;
use App\Models\Nationality;
use App\Models\ConsultingFee;
use App\Models\Category;
use App\Models\Billing;
use App\Models\FiscalYear;
use App\Models\EmergencyFee;
use App\Models\TestDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmergencyPatientRequest;
use App\Http\Requests\EmergencyUpdatePatientRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use DB;
use URL;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use App\Models\Ward;
use App\Models\Room;
use App\Models\Bed;

class EmergencyController extends Controller
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
                                EmergencyFee $emergencyFee)
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

        $hst = DB::table('hst')->orderBy('id', 'desc')->limit(1)->get();
        $this->hst = $hst[0]->hst;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = Carbon::now();
        $date->subDays(7);

        $patients = $this->emergencyPatient
            ->orderBy('id', 'DESC')
            ->where('patient_type', 'Emergency')
            //->where('user_id', Auth::user()->id)
            ->whereDate('created_at', '>', $date->toDateTimeString())
            ->groupBy('patient_code')
            ->paginate(10);


        $registeredPatientToday = $this->emergencyPatient
            ->where('patient_type', 'Emergency')
            ->where('user_id', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->groupBy('patient_code')
            ->get();

        return view('backendview.emergency.view', compact(
            'patients',
            'registeredPatientToday'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nationality = $this->nationality->all();
        $departments = $this->department
            ->where('name', 'Emergency')
            ->first();

        $doctors = $this->doctor
            ->where('department_id', $departments->id)
            ->where('status', 'Active')
            ->orderBy('created_at', 'DSC')
            ->get();

        $consultingFee = $this->consultingFee->all();

        $patients = $this->emergencyPatient
            ->orderBy('id', 'DESC')
            ->where('patient_type', 'Emergency')
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->where('user_id', Auth::user()->id)
            ->groupBy('patient_code')
            ->paginate(10);

        $registeredPatientToday = $this->emergencyPatient
            ->where('patient_type', 'Emergency')
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->where('user_id', Auth::user()->id)
            ->groupBy('patient_code')
            ->get();

        /*
    $patientId = DB::table('ipatient')->max('id');

    $lastInsertedId = $patientId + 1;
    */
        $patientId = DB::table('token')->max('token_id');
        if ($patientId)
            $lastInsertedId = $patientId + 1;
        else
            $lastInsertedId = 1;
        $emergencyPatientCode = 'TH-' . $lastInsertedId;


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


        return view('backendview.emergency.create', compact('nationality',
            'departments',
            'consultingFee',
            'patients',
            'emergencyPatientCode',
            'registeredPatientToday',
            'doctors',
            'wards',
            'rooms',
            'beds',
            'availableBeds',
            'totalBeds',
            'emergencyFee'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmergencyPatientRequest $request)
    {

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


                $taxPercentage = ($this->hst / 100) * $doctor_fee;

                $input['doctor_fee'] = $doctor_fee;

                /*
                $insertedId = DB::table('ipatient')->max('id');
                $lastInsertedId = $insertedId + 1;
                */
                $patientId = DB::table('token')->max('token_id');
                if ($patientId)
                    $lastInsertedId = $patientId + 1;
                else
                    $lastInsertedId = 1;
                $input['patient_code'] = 'TH-' . $lastInsertedId;

                $totalFeeWithTax = $taxPercentage + $doctor_fee;

                $emergencyFee = $this->emergencyFee
                    ->where('current_emergency_fee', 'Y')
                    ->first();

                $input['doctor_fee'] = $emergencyFee->emergency_fee;

                $emergencyDoctorFee = $emergencyFee->emergency_fee;

                $taxPercentage = ($this->hst / 100) * $emergencyDoctorFee;

                $input['doctor_tax_only'] = round($taxPercentage, 2);
                $input['doctor_fee_with_tax'] = round($taxPercentage + $emergencyDoctorFee);


                // $input['doctor_fee'] = round($totalFeeWithTax);
                $fiscalYear = $this->fiscalYear
                    ->where('current_fiscal_year', 'Y')
                    ->first();

                $input['fiscal_year_id'] = $fiscalYear->id;
                $input['status'] = 'Emergency';

                /* bill number */
                $billNumber = DB::table('bill_number')->max('bill_id');
                if ($billNumber)
                    $currentBillNumber = $billNumber + 1;
                else
                    $currentBillNumber = 1;

                $input['bill_number'] = $currentBillNumber;

                $departments = $this->department
                    ->where('name', 'Emergency')
                    ->first();


                $input['department_id'] = $departments->id;

                $wards = $this->ward
                    ->where('ward_name', 'Emergency')
                    ->first();
                $input['ward_id'] = $wards->id;
                $patientId = EmergencyPatient::create($input);
                $insertedPatientId = $patientId->id;

                session()->put('patient_id', $insertedPatientId);


                DB::table('bed')
                    ->where('id', $bedId)
                    ->update(['availability' => 'Unavailable']);


                /* token table */
                DB::table('token')->insert(['stat' => '1']);

                /* bill number increament */
                DB::table('bill_number')->insert(['bill_fy' => $fiscalYear->id]);


                //session()->flash('success', 'Emergency patient  added Successfully');
                return redirect('emergency/patient/' . $patientId->id . '/print-invoice/pat');

                /*return redirect('emergency/patient/create')
                    ->withInput();*/
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
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = (int)$id;

        $patient = $this->emergencyPatient->findOrFail($id);
        if ($patient) {

            $wardCharge = $patient->isOfRoom->room_rate;


            return view('backendview.emergency.show', compact('patient',
                'totalFee',
                'hst'));
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = (int)$id;
        $editPatients = $this->emergencyPatient->findOrFail($id);


        $departments = $this->department
            ->where('name', 'Emergency')
            ->first();

        $doctors = $this->doctor
            ->where('department_id', $departments->id)
            ->where('status', 'Active')
            ->orderBy('created_at', 'DSC')
            ->get();


        $departmentId = $editPatients->department_id;


        $nationality = $this->nationality->all();


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
            ->orderBy('bed_name', 'ASC')
            ->get();

        $departments = $this->department->all();

        $patients = $this->emergencyPatient
            ->orderBy('id', 'DESC')
            ->where('patient_type', 'Emergency')
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->where('user_id', Auth::user()->id)
            ->groupBy('patient_code')
            ->paginate(10);

        $registeredPatientToday = $this->emergencyPatient
            ->where('patient_type', 'Emergency')
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->where('user_id', Auth::user()->id)
            ->groupBy('patient_code')
            ->get();

        return view('backendview.emergency.editform', compact('editPatients',
            'doctors',
            'departments',
            'nationality',
            'patients',
            'registeredPatientToday',
            'wards',
            'rooms',
            'beds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmergencyUpdatePatientRequest $request, $id)
    {
        $bedData = Input::get('bed_id');

        if ($request->all()) {
            $data = $this->emergencyPatient->find($id);


            if ($data->bed_id != $bedData) {
                $oldBed = $this->bed->findOrFail($data->bed_id);
                $oldBed->availability = 'Available';
                $oldBed->update();

                $newBed = $this->bed->findOrFail($request->bed_id);
                $newBed->availability = 'Unavailable';
                $newBed->update();
            }


            if ($data) {
                $doctor_fee = Input::get('doctor_fee');
                // $data['doctor_fee'] = $doctor_fee;
                $data->fill($request->all())->save();


                session()->flash('success', 'Emergency Patient  updated Successfully');
                return redirect('emergency/patient/create');
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to handle the request');
        return redirect('emergency/patient/create');
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

    public function printEmergencyInvoice($id, $copy)
    {
        session()->forget('patient_id');
        session()->forget('emergency_patient_today');

        $id = (int)$id;

        $patient = $this->emergencyPatient->findOrFail($id);

        $wardCharge = $patient->isOfRoom->room_rate;

        if ($patient) {
            return view('backendview.emergency.emergency_invoice', compact('patient',
                'hst',
                'totalFee', 'copy', 'id'));
        } else
            abort(404);

    }

    public function printEmergencyInvoiceHos($id) {
        $id = (int)$id;

        $patient = $this->emergencyPatient->findOrFail($id);

        $wardCharge = $patient->isOfRoom->room_rate;

        if ($patient) {
            return view('backendview.emergency.emergency_invoicehos', compact('patient',
                'hst',
                'totalFee', 'copy', 'id'));
        } else
            abort(404);
    }

    public function discharge()
    {
        return view();
    }


    public function dischargePatient($id)
    {
        session()->forget('patient_id');
        $today = $this->today;
        $test_category = Category::where('level', 1)
            ->where('title', 'Emergency')
            ->first();

        $p_id = TestPatient::latest()->first();
        $patient = $this->emergencyPatient->findOrFail($id);

        $sub_cats = $this->category
            ->where('level', 2)
            ->where('status', 'Active')
            ->where('parent_id', $test_category->id)
            ->orderBy('id', 'asc')
            ->get();

        //dd($sub_cats);

        $tests = $this->category
            ->where('level', 3)
            ->where('status', 'Active')
            ->orderBy('parent_id', 'asc')
            ->get();

        //dd($tests);

        $i = 0;
        $result = array();
        foreach ($tests as $test) {
            foreach ($sub_cats as $sub_cat) {
                if ($test->parent_id == $sub_cat->id) {
                    $result[$i++] = $test;
                }
            }
        }

        //dd($result);

        $emr_dep = $this->department
            ->where('name', 'Emergency')
            ->first();

        $doctors = $this->doctor
            ->where('department_id', $emr_dep->id)
            ->where('status', 'Active')
            ->orderBy('first_name', 'asc')
            ->get();

        $discount_type = DiscountType::leftJoin('discount', 'discount.dis_id', '=', 'discount_type.d_id')
            ->select('discount.*', 'discount_type.*')
            ->where('discount.cat_id', '165')
            ->groupBy('d_id')
            ->get();

        return view('backendview.emergency.discharge', compact('patient',
            'today',
            'test_category',
            'subcategories',
            'tests',
            'doctors',
            'result',
            'discount_type'));
    }


    public function insertEmergencyBillingDetail(Request $request)
    {

        $input = $request->all();
        //dd($input);

        $pid = ($input['pid'] == '') ? $pId : (int)$input['pid'];
        $doctorId = ($input['doctorId'] == '') ? $doctorId : (int)$input['doctorId'];
        $conDoctorId = ($input['conDoctorId'] == '') ? 0 : (int)$input['conDoctorId'];
        $ePatientId = $this->emergencyPatient
            ->where('id', $pid)
            ->first();

        DB::table('ipatient')
            ->where('id', $pid)
            ->update(['status' => 'Discharged']);

        DB::table('ipatient')
            ->where('id', $pid)
            ->update(['discharged_at' => Carbon::now()]);

        DB::table('bed')
            ->where('id', $ePatientId->bed_id)
            ->update(['availability' => 'Available']);

        $fiscalYear = $this->fiscalYear
            ->where('current_fiscal_year', 'Y')
            ->first();

        /* bill number */
        $billNumber = DB::table('bill_number')->max('bill_id');
        if ($billNumber)
            $currentBillNumber = $billNumber + 1;
        else
            $currentBillNumber = 1;


        /* billing detail */
        $billing = array(
            'patient_id' => $pid,
            'doctor_id' => $doctorId,
            'consulting_doctor_id' => $conDoctorId,
            'date' => date("Y-m-d"),
            'sub_total' => floatval($input['stotal']),
            'discount' => floatval($input['discount']),
            'tax' => (int)$input['tax'],
            'grand_total' => floatval($input['gtotal']),
            'user_id' => Auth::user()->id,
            'patient_type' => 'Emergency',
            'bill_number' => $currentBillNumber

        );

        //var_dump($billing);die;
        $lastId = Billing::create($billing);
        $bid = $lastId->bid;

        /* bill number increament */
        DB::table('bill_number')->insert(['bill_fy' => $fiscalYear->id]);


        $test_arr = explode('-', $input['test_id']);
        $price_arr = explode('-', $input['price']);
        $test_discount = explode('-', $input['test_discount']);
        //$rate_arr = explode('-', $input['rate']);
        $qty_arr = explode('-', $input['qty']);
        $count_test = count($test_arr);

            for ($i = 0; $i < $count_test; $i++) {
            $test_detail = array(
                'bid' => $bid,
                'test_id' => $test_arr[$i],
                'test_price' => $price_arr[$i],
                //'rate' => $rate_arr[$i],
                'qty' => $qty_arr[$i],
                'test_discount' => $test_discount[$i]
            );

            TestDetail::create($test_detail);
        }


    }


    public function emergencyInvoice($id)
    {

        $id = (int)$id;
        $patient = $this->emergencyPatient->findOrFail($id);


        $billingDetail = DB::table('billing_detail')
            ->where('patient_id', $patient->id)
            ->where('patient_type', 'Emergency')
            ->orderBy('bid', 'desc')
            ->first();


        if ($billingDetail->discount == 0) {
            $hst = $this->hst / 100 * $billingDetail->sub_total;


        } else
            $hst = $this->hst / 100 * ($billingDetail->sub_total - $billingDetail->discount);


        $testDetails = DB::table('test_detail')
            ->where('bid', $billingDetail->bid)
            //->orderBy('bid', 'desc')
            ->get();


        return view('backendview.emergency.emergency_discharge_report', compact('patient',
            'billingDetail',
            'testDetails',
            'hst',
            'hstDis'
        ));
    }

    public function skipAndDischarge($id)
    {
        $ePatientId = $this->emergencyPatient->findOrFail($id);
        DB::table('ipatient')
            ->where('id', $id)
            ->update(['status' => 'Discharged']);

        DB::table('ipatient')
            ->where('id', $id)
            ->update(['discharged_at' => Carbon::now()]);

        DB::table('bed')
            ->where('id', $ePatientId->bed_id)
            ->update(['availability' => 'Available']);

        session()->flash('success', 'You have been discharged');
        return redirect('emergency/patient');

    }


    public function liveSearchEmergency(Request $request)
    {
        $search = $request->id;


        if (is_null($search)) {
            return view('backendview.billing.opd.livesearch');
        } else {
            // $posts = EmergencyPatient::where('ipatient_code', 'LIKE', "%{$search}%")
            //     ->orWhere('phone', 'LIKE', "%{$search}%")
            //     ->orWhere('first_name', 'LIKE', "%{$search}%")
            //     ->orWhere('last_name', 'LIKE', "%{$search}%")
            //     ->groupBy('ipatient_code')
            //     ->get();

            $posts = EmergencyPatient::select('ipatient.*')
                ->where('patient_type', '=', 'Emergency')
                ->where(function ($query) use ($search) {
                    $query->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('patient_code', 'like', '%' . $search . '%');


                })
                ->groupBy('patient_code')
                ->get();


            return view('backendview.emergency.livesearch')->withPosts($posts);
        }

    }


    public function getReprint(Request $request)
    {
        $id = $request->get('id');
        $patient = Patient::find($id);
        $reprint = $patient->reprint + 1;

        $update = Patient::where('id', $id)->update(['reprint' => $reprint]);


        return $reprint;
    }


}
