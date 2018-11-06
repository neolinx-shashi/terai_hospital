<?php

namespace App\Http\Controllers\BackEndController;

use App\Models\Department;
use App\Models\DoctorCharge;
use App\Models\IPatient;
use App\Models\IPDAdmissionCharge;
use App\Models\Ward;
use App\Models\Room;
use App\Models\Bed;
use App\Models\Nationality;
use App\Models\ConsultingFee;
use App\Models\BloodGroup;
use App\Models\FiscalYear;
use App\Models\Doctor;
use App\Models\DischargeDetail;
use App\Models\DischargeInvoiceItem;
use App\Models\IPatientHistory;
use App\Models\Category;
use App\Models\Discount;
use App\Models\DiscountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\IPatientRequest;
use App\Http\Requests\GuardianRequest;
use App\http\Requests\IPatientHistoryRequest;
use App\Http\Requests\ReferrerRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use DB;
use Carbon\Carbon;
use function Sodium\compare;

class IPDController extends Controller
{

    private $iPatient;
    private $nationality;
    private $bloodGroup;
    private $ward;
    private $room;
    private $bed;
    private $patientGuardian;
    private $patientReferrer;
    private $fiscalYear;
    private $dischargeDetail;
    private $iPatientHistory;
    private $department;
    private $admissionCharge;
    private $doctor;
    private $doctorCharge;

    public function __construct(IPatient $iPatient,
                                Nationality $nationality,
                                BloodGroup $bloodGroup,
                                Ward $ward,
                                Room $room,
                                Bed $bed,
                                FiscalYear $fiscalYear,
                                DischargeDetail $dischargeDetail,
                                IPatientHistory $iPatientHistory,
                                Department $department,
                                IPDAdmissionCharge $admissionCharge,
                                Doctor $doctor,
                                DoctorCharge $doctorCharge
    )
    {
        $this->middleware('auth');
        $this->iPatient = $iPatient;
        $this->nationality = $nationality;
        $this->bloodGroup = $bloodGroup;
        $this->ward = $ward;
        $this->room = $room;
        $this->bed = $bed;
        $this->fiscalYear = $fiscalYear;
        $this->dischargeDetail = $dischargeDetail;
        $this->iPatientHistory = $iPatientHistory;
        $this->department = $department;
        $this->admissionCharge = $admissionCharge;
        $this->doctor = $doctor;
        $this->doctorCharge = $doctorCharge;

        $hst = DB::table('hst')->orderBy('id', 'desc')->limit(1)->get();
        $this->hst = $hst[0]->hst;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->has('patient-code')) {
            $code = $request->get('patient-code');
        } else {
            $code = '';
        }

        if ($code == '') {
            $iPatients = $this->iPatient
                ->where('patient_type', 'IPD')
                //->whereDate('created_at', '=', Carbon::today()->toDateString())
                //->groupBy('patient_code')
                //->orderBy('created_at', 'DSC')
                ->orderBy('updated_at', 'DSC')
                //->get();
                ->paginate(25);
        } else {
            /*
            $iPatients = $this->iPatient
                ->where('patient_code', 'TH-'.$code)
                ->orWhere('first_name', 'like', '%'.$code.'%')
                ->where('patient_type', 'IPD')
                //->whereDate('created_at', '=', Carbon::today()->toDateString())
                //->groupBy('patient_code')
                //->orderBy('created_at', 'DSC')
                ->orderBy('updated_at', 'DSC')
                //->get();
                ->paginate(25);
                */
                $iPatients = $this->iPatient
                    ->where('patient_type', 'IPD')
                    ->where(function($query) use ($code, $code) {
                        $query->where('patient_code', 'TH-'.$code)
                        ->orWhere('first_name', 'like', '%'.$code.'%');
                    })
                    ->orderBy('updated_at', 'DSC')
                    ->paginate(25);
        }


        $deposits = array();
        foreach ($iPatients as $key => $patient)
        //$patient->deposit = array();
        {
            if ($patient->deposit_amount != "" && $patient->status == "In Ward") {
                $deposit_amounts = $patient->deposit_amount;
                $dep_amt_arr = explode(',', $deposit_amounts);

                $deposit_dates = $patient->deposit_dates;
                $dep_date_arr = explode(',', $deposit_dates);

                foreach ($dep_amt_arr as $key1 => $value) {
                    //$patient->deposit = $value;
                    $deposits[$key][$key1]['amount'] = $value;
                    if (!empty($dep_date_arr[$key1])) {
                        //$deposits[$key][$key1]['date'] = $dep_date_arr[$key1];

                        /* convert nepali date to english */
                        $localDate = str_replace("/", "-", $dep_date_arr[$key1]);
                        $classes = explode("-", $localDate);

                        $a = sprintf('%02d', $classes[0]);
                        $b = sprintf('%02d', $classes[1]);
                        $c = sprintf('%02d', $classes[2]);
                        $dateFrom = eng_to_nep($a, $b, $c);
                        $deposits[$key][$key1]['date'] = $dateFrom;
                        //$patient->deposit[$key1]->date = $dateFrom;
                    }
                }
            }
        }
        //dd($iPatients);

        return view('backendview.enrollment.ipd.index', compact('iPatients', 'deposits', 'code'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $department = $this->department
            ->where('name', '!=', 'Emergency')
            ->first();

        /*$doctors = Doctor::where('department_id', '!=', $department->id)
        ->get();*/

        $doctors = $this->doctor->all();

        $nationality = $this->nationality->all();
        $bloodGroup = $this->bloodGroup->all();
        $wards = $this->ward
            ->where('ward_name', '!=', 'Emergency')
            ->orderBy('ward_name', 'ASC')
            ->get();
        $rooms = $this->room->all();
        $beds = $this->bed->all();

        $patients = $this->iPatient
            ->orderBy('created_at', 'DESC')
            ->where('status', 'In Ward')
            ->where('patient_type', 'IPD')
            ->paginate(7);

        $registeredPatientsToday = $this->iPatient
            ->orderBy('id', 'DESC')
            ->where('patient_type', 'IPD')
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->where('user_id', Auth::user()->id)
            ->where('status', 'In Ward')
            ->paginate(10);

        $patientId = DB::table('token')->max('token_id');
        if ($patientId)
            $lastInsertedId = $patientId + 1;
        else
            $lastInsertedId = 1;
        $patientCode = 'TH-' . $lastInsertedId;

        return view('backendview.enrollment.ipd.create', compact('nationality',
            'patients',
            'bloodGroup',
            'wards',
            'rooms',
            'beds',
            'patientCode',
            'registeredPatientsToday',
            'doctors'));
    }


    /**
     * @param IPatientRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(IPatientRequest $request)
    {
        $admissionCharge = $this->admissionCharge
            ->where('current_admission_charge', 'Y')
            ->first();
        $admChrg = $admissionCharge->admission_charge;
        $admChrgTax = $this->hst / 100 * $admChrg;
        $admChrgWithTax = $admChrg + $admChrgTax;
        $input = $request->all();
        try {
            if ($request->all()) {
                $user_id = Auth::user()->id;
                $input['user_id'] = $user_id;
                $input['patient_type'] = 'IPD';
                $input['admission_charge'] = $admChrg;
                $input['admission_charge_hst'] = $admChrgTax;
                $input['admission_charge_with_tax'] = $admChrgWithTax;

                $test_deposit = $request->deposit_amount;
                if ($test_deposit != '') {
                    $input['deposit_dates'] = Carbon::now()->toDateString();
                    $input['deposit_times'] = date("H:i:s");
                    $input['deposit_user_id'] = Auth::user()->id;
                }

                // $patientId='TH-'
                $patientId = DB::table('token')->max('token_id');
                if ($patientId)
                    $lastInsertedId = $patientId + 1;
                else
                    $lastInsertedId = 1;
                $input['patient_code'] = 'TH-' . $lastInsertedId;

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

                $iPatient = iPatient::create($input);

                DB::table('token')->insert(['stat' => '1']);

                /* bill number increament */
                DB::table('bill_number')->insert(['bill_fy' => $fiscalYear->id]);

                $ipatient_id = $iPatient->id;
                session()->put('ipatient_id', $ipatient_id);

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

                session()->flash('success', 'Patient created Successfully!');
                return redirect('ip-enrollment/ipatient/'.$iPatient->id.'/print-admit-invoice');
            } else {
                return redirect()->back()->withInput();
            }
        } catch
        (Exception $e) {
            session()->flash('error', 'Sorry Unable to handle the request');
        }
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $id = (int)$id;

        $patient = $this->iPatient->findOrFail($id);
        return view('backendview.enrollment.ipd.show', compact('patient'));
    }

    /**
     * @param $id
     * @param $shift
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, $shift)
    {
        $id = (int)$id;
        $department = $this->department
            ->where('name', '!=', 'Emergency')
            ->first();

        $editPatients = $this->iPatient->findOrFail($id);
        $departmentId = $editPatients->department_id;

        $doctors = $this->doctor
            ->where('status', 'Active')
            ->get();

        $nationality = $this->nationality->all();
        $bloodGroup = $this->bloodGroup->all();
        $wards = $this->ward
            ->where('ward_name', '!=', 'Emergency')
            ->orderBy('ward_name', 'ASC')
            ->get();
        $rooms = $this->room->all();
        $beds = $this->bed->all();
        $patients = $this->iPatient
            ->orderBy('created_at', 'DESC')
            ->where('status', 'In Ward')
            ->paginate(7);
        return view('backendview.enrollment.ipd.edit', compact('editPatients',
            'bloodGroup',
            'nationality',
            'patients',
            'wards',
            'rooms',
            'doctors',
            'beds',
            'shift'
        ));
    }

    /**
     * @param PatientRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $now = Carbon::now()->toDateTimeString();
        $id = (int)$id;
        $input = $request->all();
        if ($request->all()) {
            $data = $this->iPatient->find($id);

            if ($data->bed_id != $request->bed_id) {
                $oldBed = $this->bed->findOrFail($data->bed_id);
                $oldBed->availability = 'Available';
                $oldBed->update();

                $newBed = $this->bed->findOrFail($request->bed_id);
                $newBed->availability = 'Unavailable';
                $newBed->update();
            }

            /* ipd_patient_ward */

            $pw_detail = DB::table('ipd_patient_ward')->where('patient_id', $id)->orderBy('created_at', 'desc')->first();

            if (!empty($pw_detail)) {
                $bed_id = $pw_detail->bed_id;
                $bed = $this->bed->findOrFail($bed_id);
                $room_charge = $bed->isOfRoom->room_rate;

                DB::table('bed')->where('id', $bed_id)->update(['availability' => 'Available']);

                $pw_detail->date_to = $now;

                DB::table('ipd_patient_ward')->where('patient_id', $id)->where('status', '1')->update(['date_to' => $now]);
            } else {
                $old_bed = $this->bed->findOrFail($data->bed_id);
                $old_room_charge = $old_bed->isOfRoom->room_rate;
                $old_ward = array(
                    'patient_id' => $data->id,
                    'ward_id' => $data->ward_id,
                    'room_id' => $data->room_id,
                    'room_charge' => $old_room_charge,
                    'bed_id' => $data->bed_id,
                    'date_from' => $data->created_at,
                    'date_to' => $now,
                    'status' => "1"
                );
                DB::table('ipd_patient_ward')->insert($old_ward);

                $bed = $this->bed->findOrFail($data->bed_id);
                $room_charge = $bed->isOfRoom->room_rate;
            }


            if ($data) {
                if ($data->bed_id != $request->bed_id) {

                    DB::table('ipd_patient_ward')->where('patient_id', $id)->update(['status' => "0"]);

                    $ward = array(
                        'patient_id' => $id,
                        'ward_id' => $input['ward_id'],
                        'room_id' => $input['room_id'],
                        'room_charge' => $room_charge,
                        'bed_id' => $input['bed_id'],
                        'date_from' => $now,
                        'status' => "1"
                    );
                    DB::table('ipd_patient_ward')->insert($ward);
                }
                $data->fill($request->all())->save();
            }


            session()->flash('success', 'Patient updated Successfully');
            return redirect('ip-enrollment/patients');
        } else {
            session()->flash('error', 'Sorry unable to handle the request');
            return redirect()
                ->back()
                ->withInput();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editGuardian($id)
    {
        $id = (int)$id;
        $editPatients = $this->iPatient->findOrFail($id);
        return view('backendview.enrollment.ipd.guardian.guardian', compact('editPatients',
            'nationality'));
    }

    /**
     * @param PatientRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addGuardian(GuardianRequest $request, $id)
    {
        $id = (int)$id;
        if ($request->all()) {
            $data = $this->iPatient->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                session()->flash('success', 'Patient updated Successfully');
                return redirect('ip-enrollment/patients');
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to handle the request');
        return redirect('ip-enrollment/patients');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editReferrer($id)
    {
        $id = (int)$id;
        $editPatients = $this->iPatient->findOrFail($id);
        return view('backendview.enrollment.ipd.referrer.referrer', compact('editPatients',
            'nationality'));
    }

    /**
     * @param PatientRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addReferrer(ReferrerRequest $request, $id)
    {
        $id = (int)$id;
        if ($request->all()) {
            $data = $this->iPatient->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                session()->flash('success', 'Patient updated Successfully');
                return redirect('ip-enrollment/patients/47/edit');
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to handle the request');
        return redirect('ip-enrollment/patients/47/edit/tabs-3');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $id = (int)$id;
            $data = $this->iPatient->find($id);
            if ($data) {
                $data->delete();
                session()->flash('success', 'Patient Deleted Successfully');
            }
            return redirect()->back();
            session()->flash('error', 'Sorry unable to delete patient');
            return redirect()->back();

        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry unable to handle the request');
            return redirect('ip-enrollment');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Discharge()
    {
        $patients = $this->iPatient
            ->where('patient_type', '=', 'IPD')
            ->orderBy('created_at', 'DSC')
            ->groupBy('patient_code')
            ->get();


        return view('backendview.enrollment.ipd.discharge', compact('patients'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function dischargePatient($id)
    {
        $id = (int)$id;
        $dischargePatients = $this->iPatient->findOrFail($id);
        $dischargePatients->status = 'Discharged';
        $dischargePatients->discharged_at = Carbon::now()->toDateTimeString();
        $dischargePatients->discharge_user_id = Auth::user()->id;
        $dischargePatients->update();

        $bed = $this->bed->findOrFail($dischargePatients->bed_id);
        $bed->availability = 'Available';
        $bed->update();
        session()->flash('success', 'Patient discharged Successfully');

        return redirect('ip-enrollment/patients');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function cancelDischarge($id)
    {
        $id = (int)$id;
        $patient = $this->iPatient->findOrFail($id);

        if ($patient->isOfBed->availability == 'Available') {
            $patient->status = 'In Ward';
            $patient->discharged_at = '';
            $patient->update();

            $bed = $this->bed->findOrFail($patient->bed_id);
            $bed->availability = 'Unavailable';
            $bed->update();
            session()->flash('success', 'Patient discharge cancelled Successfully');
        } else {
            session()->flash('foreignerror', 'Sorry, the bed assigned to the patient is unavailable!');
        }

        return redirect('ip-enrollment/discharge-patient');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function printInvoice($id, $stat=0)
    {
        $id = (int)$id;

        $patient = $this->iPatient->findOrFail($id);

        $test_category = Category::where('level', 1)->orderBy('title', 'asc')->get();

        $tests = Category::where('level', 3)
            ->where('status', 'Active')
            ->orderBy('title', 'asc')
            ->get();

        $now = Carbon::now();
        $admitted_at = $patient->created_at;
        $daysInHospital = $admitted_at->diffInDays($now) + 1;

        $roomRate = $patient->isOfRoom->room_rate;
        $roomName = $patient->isOfRoom->room_name;

        /*room charge details*/
        $room_trf = DB::table('ipatient')
            ->leftjoin('ipd_patient_ward', 'ipatient.id', '=', 'ipd_patient_ward.patient_id')
            ->select('ipd_patient_ward.date_from', 'ipd_patient_ward.date_to', 'ipd_patient_ward.ward_id', 'ipd_patient_ward.room_id', 'ipd_patient_ward.bed_id', 'ipd_patient_ward.room_charge')
            ->where('ipd_patient_ward.patient_id', $id)
            //->groupBy('ipd_patient_ward.room_id')
            ->get();
        //dd($room_trf);

        $roomCharge = 0;
        foreach ($room_trf as $key => $data) {
            $room = $this->room->findOrFail($data->room_id);
            $room_data[$key]['room_id'] = $room->id;
            $room_data[$key]['room_name'] = $room->room_name;
            $room_data[$key]['room_charge'] = $room->room_rate;
            $roomCharge += $room->room_rate;
        }

        /*if (count($room_trf)) {
            $roomCharge = 0;
            foreach ($room_trf as $key => $data) {
                $room = $this->room->findOrFail($data->room_id);

                $roomCharge += $room->room_rate;
            }
        } else {
            $roomCharge = $roomRate * $daysInHospital;
        }*/

        if (count($patient->hasHistory)) {
            $doctorVisits = $patient->hasHistory;

            $docs = DB::table('i_patient_histories')
                ->where('ipatient_id', $id)
                ->groupBy('doctor_id')
                ->get();

            $doctorVisitCharge = 0;

            $i = 0;
            $j = 0;
            $k = 0;

            foreach ($docs as $doc) {
                $charge[$i++] = DB::table('i_patient_histories')
                    ->where('ipatient_id', $id)
                    ->where('doctor_id', $doc->doctor_id)
                    ->sum('doctor_fee');

                $count[$j++] = DB::table('i_patient_histories')
                    ->where('ipatient_id', $id)
                    ->where('doctor_id', $doc->doctor_id)
                    ->count();

                $name = $this->doctor->findOrFail($doc->doctor_id);
                $full_name[$k++] = $name->first_name . ' ' . $name->middle_name . ' ' . $name->last_name;
                //dd($full_name);
            }

            $cnt = (count($docs));

            for ($m = 0; $m < $cnt; $m++) {
                $docs[$m]->charge = $charge[$m];
                $docs[$m]->count = $count[$m];
                $docs[$m]->full_name = $full_name[$m];
            }

            foreach ($doctorVisits as $doctorVisit) {
                $doctorVisitCharge += $doctorVisit->doctor_fee;
            }

            $subTotal = $roomCharge + $doctorVisitCharge;
        } else {
            $subTotal = $roomCharge;
            $doctorVisitCharge = '';
        }

        /* test list (added later SX) */
        if ($stat == '1') {
            $test_list = DischargeDetail::leftJoin('discharge_invoice_items', 'discharge_details.id', '=', 'discharge_invoice_items.discharge_id')->leftJoin('categories', 'discharge_invoice_items.test_id', '=', 'categories.id')->select('categories.title', 'categories.price', 'discharge_invoice_items.test_price', 'discharge_invoice_items.quantity')->where('discharge_details.ipatient_id', $id)->get();
            //var_dump($test_list);die;
            foreach ($test_list as $key => $val) {
                $subTotal += $val->test_price;
            }
        } else {
            $test_list = array();
        }   

        $hst = $this->hst / 100 * $subTotal;

        /* bill number */
        $billNumber = DB::table('bill_number')->max('bill_id');
        if ($billNumber)
            $currentBillNumber = $billNumber + 1;
        else
            $currentBillNumber = 1;

        /*total deposit calculation*/
        $deposits = explode(',', $patient->deposit_amount);

        $deposit_amount = 0;

        foreach ($deposits as $deposit)
        {
            $deposit_amount += $deposit;
        }

        /* get discount type */
        $discount_type = DiscountType::leftJoin('discount', 'discount.dis_type', '=', 'discount_type.d_id')
            ->select('discount.*', 'discount_type.*')
            //->where('discount.cat_id', '!=', '165')
            ->groupBy('d_id')
            ->get();

        if ($patient) {
            return view('backendview.enrollment.ipd.invoice', compact(
                'patient',
                'roomRate',
                'roomName',
                'roomCharge',
                'daysInHospital',
                'doctorVisits',
                'doctorVisitCharge',
                'subTotal',
                'hst',
                'test_category',
                'docs',
                'room_data',
                'room_trf',
                'tests',
                'currentBillNumber',
                'deposit_amount',
                'discount_type',
                'stat',
                'test_list'
            ));
        } else
            abort(404);

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function printAdmitInvoice($id, $stat=0)
    {
        session()->forget('ipatient_id');
        $id = (int)$id;
        $patient = $this->iPatient->findOrFail($id);
        $doctor = Doctor::findOrFail($patient->doctor_id);
        $ward = $patient->isOfWard->ward_name;
        $room = $patient->isOfRoom->room_name;
        $bed = $patient->isOfBed->bed_name;
        $roomCharge = $patient->isOfRoom->room_rate;
        $doctorCharge = $doctor->normal_fee;
        $subTotal = $roomCharge + $doctorCharge;
        $hst = $this->hst / 100 * $subTotal;
        $total = $subTotal + $hst;

        /*$now = Carbon::now();
        $admitted_at = $patient->created_at;

        $daysInHospital = $admitted_at->diffInDays($now);

        $roomRate = $patient->isOfRoom->room_rate;
        $roomCharge = $roomRate * $daysInHospital;

        if (count($patient->hasHistory)) {
            $doctorVisits = $patient->hasHistory;

            $doctorVisitCharge = 0;
            foreach ($doctorVisits as $doctorVisit) {
                $doctorVisitCharge += $doctorVisit->doctor_fee;
            }

            $subTotal = $roomCharge + $doctorVisitCharge;
        } else {
            $subTotal = $roomCharge;
        }

        $hst = 5 / 100 * $subTotal;*/

        $deposit = $patient->deposit_amount;

        /*if ($total > $deposit) {
            $due = $total - $deposit;
            $return = 0;
        } else {
            $return = $deposit - $total;
            $due = 0;
        }*/

        if ($patient) {
            return view('backendview.enrollment.ipd.admit_invoice', compact(
                'patient',
                'deposit',
                'ward',
                'room',
                'bed',
                'doctor',
                'roomCharge',
                'doctorCharge',
                'subTotal',
                'hst',
                'total',
                'stat',
                'id'
            ));
        } else
            abort(404);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function DoctorDetails()
    {
        $iPatients = $this->iPatient->all();
        return view('backendview.enrollment.ipd.patientHistory.index', compact('iPatients'));
    }

    /**
     * @param Request $request
     */
    public function insertDischargeInvoiceDetail(Request $request)
    {
        $input = $request->all();

        $fiscalYear = $this->fiscalYear
            ->where('current_fiscal_year', 'Y')
            ->first();

        /* bill number */
        $billNumber = DB::table('bill_number')->max('bill_id');
        if ($billNumber)
            $currentBillNumber = $billNumber + 1;
        else
            $currentBillNumber = 1;

        $discharge_detail = array(
            'user_id' => Auth::user()->id,
            'ipatient_id' => $input['ipatient_id'],
            'room_id' => $input['room_id'],
            'room_charge' => $input['room_charge'],
            'doctor_charge' => $input['doctor_charge'],
            'discount' => $input['discount'],
            'subtotal_after_discount' => $input['subtotal_after_discount'],
            'total_after_tax' => $input['total_after_tax'],
            'hst' => $input['hst'],
            'bill_number' => $currentBillNumber,
            'returned_amount' => $input['returned_amount'],
            'received_amount' => $input['received_amount']
        );
        $discharge = $this->dischargeDetail->create($discharge_detail);

        /* bill number increament */
        DB::table('bill_number')->insert(['bill_fy' => $fiscalYear->id]);

        if ($input['test_id']) {
            $test_arr = explode('-', $input['test_id']);
            $price_arr = explode('-', $input['test_price']);
            $qty_arr = explode('-', $input['test_quantity']);
            $count_test = count($test_arr);
            $did = $discharge->id;

            for ($i = 0; $i < $count_test; $i++) {
                $discharge_item_detail = array(
                    'discharge_id' => $did,
                    'test_id' => $test_arr[$i],
                    'test_price' => $price_arr[$i],
                    'quantity' => $qty_arr[$i]
                );
                DischargeInvoiceItem::create($discharge_item_detail);
            }
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function insertDoctorDetails($id)
    {
        $id = (int)$id;
        $patient = $this->iPatient->findOrFail($id);
        $doctorCharges = $this->doctorCharge->all();
        $doctors = Doctor::all();

        return view('backendview.enrollment.ipd.insert_doctor_detail', compact('patient', 'doctors', 'doctorCharges'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getDoctorDetails($id)
    {
        $id = (int)$id;
        $patient = $this->iPatient->findOrFail($id);
        if ($patient->hasHistory) {
            $items = $patient->hasHistory;
            foreach ($items as $item) {
                $doctor = Doctor::findOrFail($item->doctor_id);
                $doctor_name = $doctor->first_name . ' ' . $doctor->middle_name . ' ' . $doctor->last_name;
                $item->doctor_name = $doctor_name;
            }
            return response()->json($items);
        } else {
            session()->flash('error', 'Sorry Unable to handle the request');
            return redirect()->back();
        }
    }

    /**
     * @param IPatientHistoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeDoctorDetails(IPatientHistoryRequest $request)
    {
        $input = $request->all();

        $date_from = $request->get('appointment');

        /* convert nepali date to english */
        $localDate = str_replace("/", "-", $date_from);
        $classes = explode("-", $localDate);

        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $dateFrom = nep_to_eng($a, $b, $c);
        $input['appointment'] = $dateFrom;
        $create = $this->iPatientHistory->create($input);
        return response()->json($create);
    }

    /**
     * @param $id
     * @param $pid
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteDoctorDetails($id, $pid)
    {
        $pid = (int)$pid;
        $this->iPatientHistory->findOrFail($pid)->delete();
        return response()->json(['done']);
    }

    /**
     * @param IPatientHistoryRequest $request
     * @param $id
     * @param $pid
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDoctorDetails(IPatientHistoryRequest $request, $id, $pid)
    {
        $pid = (int)$pid;
        $edit = $this->iPatientHistory->findOrFail($pid)->update($request->all());
        return response()->json($edit);
        $id = (int)$id;
        $this->iPatientHistory->findOrFail($id)->delete();
        return response()->json(['done']);
    }

    /**
     * @param Request $request
     */
    public function getTotalInWords(Request $request)
    {
        $total = $request->total;
        $total_in_words = 'In Words: ';
        $total_in_words .= convert_number_to_words(round($total, 2));
        $total_in_words .= ' Only';
        echo $total_in_words;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function insertDischargeSummary($id)
    {
        $patient = $this->iPatient->findOrFail($id);
        return view('backendview.enrollment.ipd.discharge_summary', compact('patient'));
    }

    /**
     * @param Request $request
     */
    public function saveDischargeSummary(Request $request)
    {
        $patient = $this->iPatient->findOrFail($request->pid);
        $patient->discharge_summary = $request->discharge_summary;
        $patient->diagnosis = $request->diagnosis;
        $patient->treatment = $request->treatment;
        $patient->follow_up = $request->follow_up;
        $patient->update();
        echo $patient->id;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function AddDeposit($id)
    {
        return view('backendview.enrollment.ipd.add_deposit', compact('id'));
    }

    /**
     * @param Request $request
     * @param $id
     */
    public function storeDeposit(Request $request, $id)
    {
        $patient = $this->iPatient->findOrFail($id);
        $doctor = $this->doctor->findOrFail($patient->doctor_id);
        $ward = $patient->isOfWard->ward_name;
        $room = $patient->isOfRoom->room_name;
        $bed = $patient->isOfBed->bed_name;
        $test_deposit = $patient->deposit_amount;


        if ($test_deposit == '') {
            $patient->deposit_amount = $request->deposit;
            $patient->deposit_dates = Carbon::now()->toDateString();
            $patient->deposit_times = date("H:i:s");
            $patient->deposit_user_id = Auth::user()->id;
        } else {
            $patient->deposit_amount .=','.$request->deposit;
            $patient->deposit_dates .=','.Carbon::now()->toDateString();
            $patient->deposit_times .= ','.date("H:i:s");
            $patient->deposit_user_id .= ','.Auth::user()->id;
        }
        $patient->update();
        $deposits = explode(',', $patient->deposit_amount);
        $deposit = end($deposits);
        return view('backendview.enrollment.ipd.deposit_slip', compact('deposit', 'patient', 'doctor', 'ward', 'room', 'bed'));
    }
}
