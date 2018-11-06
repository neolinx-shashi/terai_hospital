<?php

namespace App\Http\Controllers\billing;

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
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use App\Models\Discount;
use App\Models\DiscountType;

class PatientController extends Controller
{

    private $patient;
    private $nationality;
    private $doctor;
    private $department;
    private $consultingFee;
    private $fiscalYear;
    private $billing;

    public function __construct(Patient $patient,
                                Nationality $nationality,
                                Doctor $doctor,
                                Department $department,
                                ConsultingFee $consultingFee,
                                FiscalYear $fiscalYear,
                                Billing $billing)
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

        $hst = DB::table('hst')->orderBy('id', 'desc')->limit(1)->get();
        $this->hst = $hst[0]->hst;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $patients = $this->patient
            ->where('patient_type', '=', 'OPD')
            ->orderBy('id', 'DESC')
            ->groupBy('patient_code')
            ->paginate(10);
        return view('backendview.billing.opd.index', compact('patients'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $nationality = $this->nationality->all();
        $departments = $this->department
            ->where('name', '!=', 'Emergency')
            ->get();

        $doctors = $this->doctor
            ->where('status', 'Active')
            ->get();
        $consultingFee = $this->consultingFee->all();

        $patients = $this->patient
            ->orderBy('id', 'DESC')
            ->where('patient_type', 'OPD')
            //->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->whereDate('created_at', '>', Carbon::now()->subDays(15))
            ->where('user_id', Auth::user()->id)
            ->where('status', 'OPD')
            ->where('refund_status', 'Active')
            ->groupBy('patient_code')
            ->paginate(10);

        $registeredPatientToday = $this->patient
            ->where('patient_type', 'OPD')
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->where('user_id', Auth::user()->id)
            ->where('status', 'OPD')
            ->where('refund_status', 'Active')
            ->groupBy('patient_code')
            ->get();


        //$patientId = DB::table('ipatient')->max('id');
        $patientId = DB::table('token')->max('token_id');
        if ($patientId)
            $lastInsertedId = $patientId + 1;
        else
            $lastInsertedId = 1;
        $patientCode = 'TH-' . $lastInsertedId;

        return view('backendview.billing.opd.create', compact('nationality',
            'doctors',
            'departments',
            'consultingFee',
            'patients',
            'patientCode',
            'registeredPatientToday'));
    }

    /**
     * @param $id
     * @param $officeId
     * @return string
     */
    public function officeList($id, $officeId)
    {
        $offices = $this->doctor
            ->select('id', 'first_name', 'middle_name', 'last_name')
            ->where('department_id', '=', $id)
            ->where('status', 'Active')
            ->orderBy('id')
            ->get();


        if ($offices->isEmpty()) {

            $listEmpty = ' <select class="form-control" disabled="disabled">';

            $listEmpty .= ' <option value="" >No Any available doctor</option>';

            $listEmpty .= '</select>';

            return $listEmpty;
        } else {
            $list = ' <select class="form-control" name="doctor_id" id="doctor"  onchange="changeData()">';

            $list .= ' <option value="">Select Doctor Name</option>';
            foreach ($offices as $office) {

                $selected = (old('doctor_id') == $office->id) ? "selected='selected'" : null;

                $list .= '<option value="' . $office->id . '" ' . $selected . '>' . ucfirst($office->first_name) . '  ' . ucfirst($office->middle_name) . ' ' . ucfirst($office->last_name) . '</option>';


            }
            $list .= '</select>';

            return $list;
        }

    }


    /**
     * @param $id
     * @param $officeId
     * @return string
     */
    public function doctorChargeList($id, $officeId)
    {
        $offices = $this->doctor
            ->select('id', 'first_name', 'normal_fee')
            ->where('id', '=', $id)
            ->orderBy('id')
            ->get();

        foreach ($offices as $office) {
            $list = '<input type="text" value="' . $office->normal_fee . '"  disabled class="form-control" >';
            $list .= '<input type="hidden" name="doctor_fee" value="' . $office->normal_fee . '" >';

        }
        return $list;
    }


    /**
     * @param PatientRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PatientRequest $request)
    {
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

                $taxPercentage = ($this->hst / 100) * $feeAfterTax;

                $input['doctor_tax_only'] = $taxPercentage;

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

                DB::table('token')->insert(['stat' => '1']);

                /* bill number increament */
                DB::table('bill_number')->insert(['bill_fy' => $fiscalYear->id]);

                session()->put('opd_patient_id', $insertedPatientId);

                //session()->flash('success', 'Patient added Successfully');
                return redirect('configuration/patient/' . $patientId->id . '/print-invoice/pat');
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
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $id = (int)$id;
        $patient = $this->patient->findOrFail($id);

        return view('backendview.billing.opd.show', compact('patient'));
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $id = (int)$id;
        $editPatients = $this->patient->findOrFail($id);
        $departmentId = $editPatients->department_id;


        $nationality = $this->nationality->all();
        $doctors = $this->doctor->where('status', 'Active')
            ->get();

        $departments = $this->department
            ->where('name', '!=', 'Emergency')
            ->get();
        $patients = $this->patient
            ->where('patient_type', 'OPD')
            ->orderBy('id', 'DESC')
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->where('user_id', Auth::user()->id)
            ->where('status', 'OPD')
            ->where('refund_status', 'Active')
            ->groupBy('patient_code')
            ->paginate(10);

        $registeredPatientToday = $this->patient
            ->where('patient_type', 'OPD')
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->where('user_id', Auth::user()->id)
            ->where('status', 'OPD')
            ->where('refund_status', 'Active')
            ->groupBy('patient_code')
            ->get();

        return view('backendview.billing.opd.edit', compact('editPatients',
            'doctors',
            'departments',
            'nationality',
            'patients',
            'registeredPatientToday'));
    }

    /**
     * @param PatientRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePatientRequest $request, $id)
    {
        $id = (int)$id;
        $feeData = $request['doctor_fee'];

        $fee = DB::table('patient_records')
            ->where('patient_id', $id)
            ->value('fee');
        $latestFee = $fee + $feeData;

        DB::table('patient_records')
            ->where('patient_id', $id)
            ->update(['fee' => $latestFee]);


        if ($request->all()) {
            $data = $this->patient->find($id);
            if ($data) {
                $doctor_fee = Input::get('doctor_fee');

                $discount_percent = Input::get('discount_percent');
                $discountedValue = ($discount_percent / 100) * $doctor_fee;
                $data['discounted_fee_value'] = $discountedValue;
                $feeAfterTax = $doctor_fee - $discountedValue;
                $taxPercentage = ($this->hst / 100) * $feeAfterTax;
                $data['doctor_tax_only'] = $taxPercentage;
                $totalFeeWithTax = $taxPercentage + $feeAfterTax;


                $data['doctor_fee_with_tax'] = round($totalFeeWithTax);
                $data->fill($request->all())->save();
                session()->flash('success', 'Patient updated Successfully');
                return redirect('configuration/patient/create');
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to handle the request');
        return redirect('configuration/patient/create');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // try {

        //     $id = (int)$id;
        //     $data = $this->patient->find($id);
        //     if ($data) {
        //         $data->delete();
        //         session()->flash('success', 'Patient Deleted Successfully');

        //     }
        //     return redirect()->back();

        //     session()->flash('error', 'Sorry unable to delete doctor');

        //     return redirect()->back();

        // } catch (QueryException $e) {
        //     session()->flash('foreignerror', 'Sorry unable to handle the request');

        //     return redirect('configuration/patient');
        // }


    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function printInvoice($id, $copy)
    {
        session()->forget('opd_patient_id');
        session()->forget('opd_patient_readmit');

        $id = (int)$id;

        $patient = $this->patient->findOrFail($id);

        $hst = $this->hst / 100 * $patient->doctor_fee;

        if ($patient) {
            return view('backendview.billing.opd.invoice', compact('patient', 'hst', 'copy', 'id'));
        } else
            abort(404);

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function printInvoiceHos($id)
    {
        session()->forget('opd_patient_id');
        session()->forget('opd_patient_readmit');

        $id = (int)$id;

        $patient = $this->patient->findOrFail($id);

        $hst = $this->hst / 100 * $patient->doctor_fee;

        if ($patient) {
            return view('backendview.billing.opd.invoice_hos', compact('patient', 'hst', 'copy', 'id'));
        } else
            abort(404);

    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function printSticker($id)
    {
        session()->forget('patient_id');
        $id = (int)$id;
        $patient = $this->patient->findOrFail($id);


        if ($patient) {
            return view('backendview.billing.opd.sticker', compact('patient'));
        } else
            abort(404);

    }

    /**
     * @param $id
     * @return string
     */
    public function doctorList($id)
    {
        $id = (int)$id;

        $doctors = $this->doctor
            ->select('id', 'first_name')
            ->where('department_id', '=', $id)
            ->where('status', 'Active')
            ->get();

        foreach ($doctors as $doctor) {
            $list = '<option value="' . $doctor->id . '" ' . '>' . $doctor->first_name . '</option>';
        }

        return $list;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function totalPatientsToday()
    {
        /*$collection = DB::table('patients')
            ->where('status', 'Active')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->sum('doctor_fee_with_tax');*/


        $patients = $this->patient
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('refund_status', 'Active')
            ->where('patient_type', '=', 'OPD')
            ->groupBy('patient_code')
            ->paginate(10);


        $testPatients = $this->billing
            ->where('status', '=', 'Active')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->get();

        $total = $this->patient
            ->where('status', '=', 'Active')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->sum('doctor_fee_with_tax');

        $testTotal = $this->billing
            ->where('status', '=', 'Active')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->sum('grand_total');

        /*$patients = $this->patient
            ->leftJoin('billing_detail', 'patients.id', '=', 'billing_detail.patient_id')
            ->select('patients.id',
                'patients.first_name',
                'patients.middle_name',
                'patients.last_name',
                'patients.patient_code',
                'patients.appointment',
                'patients.doctor_fee_with_tax',
                'patients.created_at',
                'patients.user_id',
                'billing_detail.patient_id',
                'billing_detail.grand_total',
                'billing_detail.created_at',
                'billing_detail.user_id'
            )
            //->groupBy('patients.patient_code')
            ->where('patients.user_id', '=', Auth::user()->id)
            ->whereDate('patients.created_at', '=', Carbon::now()->toDateString())
            ->where('billing_detail.user_id', '=', Auth::user()->id)
            ->whereDate('billing_detail.created_at', '=', Carbon::now()->toDateString())
            ->where('patients.status', '=', 'Active')
            ->get();

        dd($patients);*/

        return view('backendview.dashboard.billing.list', compact('patients',
            'total',
            'testTotal',
            'patients',
            'testPatients'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function printTestInvoice()
    {
        $today = $this->today;
        $test_category = Category::where('level', 1)->orderBy('title', 'asc')->get();
        $doctors = Doctor::where('status', 'Active')
            ->orderBy('first_name', 'asc')
            ->get();

        $p_id = TestPatient::latest()->first();
        $pId = $p_id['id'] + 1;

        /* get all tests */
        $tests = Category::where('level', 3)->where('status', 'Active')->orderBy('title', 'asc')->get();

        /* get discount type */
        $discount_type = DiscountType::leftJoin('discount', 'discount.dis_id', '=', 'discount_type.d_id')
            ->select('discount.*', 'discount_type.*')
            ->where('discount.cat_id', '!=', '165')
            ->groupBy('d_id')
            ->get();

        $hst = $this->hst;

        return view('backendview.billing.opd.test', compact('today', 'test_category', 'doctors', 'pId', 'tests', 'discount_type', 'hst'));
    }

    /**
     * @param $code
     * @return mixed
     */
    public function getPatientDetail($code)
    {
        $reports = DB::table('ipatient')
            ->leftJoin('doctors', 'ipatient.doctor_id', '=', 'doctors.id')
            ->where('ipatient.patient_code', $code)
            ->select("ipatient.*", "doctors.first_name as dfn", "doctors.middle_name as dmn", "doctors.last_name as dln")
            ->get();

        return $reports;
    }

    /**
     * @param Request $request
     */
    public function insertBillingDetail(Request $request)
    {
        $input = $request->all();

        $pId = 0;
        $currentBillNumber = 0;

        $fiscalYear = $this->fiscalYear
            ->where('current_fiscal_year', 'Y')
            ->first();

        /* patient */
        if ($input['code'] == 'TH-') {
            /*$full_name = $input['name'];
            $fullname = explode(" ", $full_name);
            if (count($fullname) == 2) {
                $fname = $fullname[0];
                $mname = '';
                $lname = $fullname[1];
            } else if (count($fullname) == 3) {
                $fname = $fullname[0];
                $mname = $fullname[1];
                $lname = $fullname[2];
            } else if (count($fullname) == 1) {
                $fname = $fullname[0];
                $mname = '';
                $lname = '';
            }*/

            $patientId = DB::table('token')->max('token_id');
            if ($patientId)
                $lastInsertedId = $patientId + 1;
            else
                $lastInsertedId = 1;

            /* $fiscalYear = $this->fiscalYear
                 ->where('current_fiscal_year', 'Y')
                 ->first();*/


            $patient_detail = array(
                'first_name' => $input['name'],
                'age' => $input['age'],
                'permanent_address' => $input['address'],
                'phone' => $input['phone'],
                'gender' => $input['gender'],
                'patient_code' => 'TH-' . $lastInsertedId,
                'status' => 'Active',
                'user_id' => Auth::user()->id,
                'doctor_id' => $input['doc_id'],
                //'doctor_fee' => 0,
                'symptoms' => '',
                'appointment' => date("Y-m-d"),
                //'department_id' => 3,
                'fiscal_year_id' => $fiscalYear->id,
                'patient_type' => 'test'
            );

            /* bill number */
            $billNumber = DB::table('bill_number')->max('bill_id');
            if ($billNumber)
                $currentBillNumber = $billNumber + 1;
            else
                $currentBillNumber = 1;

            $patient_detail['bill_number'] = $currentBillNumber;

            $patient = TestPatient::create($patient_detail);

            DB::table('token')->insert(['stat' => '1']);
            /* bill number increament */
            DB::table('bill_number')->insert(['bill_fy' => $fiscalYear->id]);

            $pId = $patient->id;
        }

        /* billing detail */
        $pid = ($input['pid'] == '') ? $pId : (int)$input['pid'];
        $billing = array(
            'patient_id' => $pid,
            'patient_type' => 'test',
            'doctor_id' => $input['doc_id'],
            'consulting_doctor_id' => $input['con_doc_id'],
            'date' => date("Y-m-d"),
            'sub_total' => floatval($input['stotal']),
            'discount' => floatval($input['discount']),
            'tax' => floatval($input['tax']),
            'grand_total' => floatval($input['gtotal']),
            'user_id' => Auth::user()->id,
            'consulting_doctor_rate' => $input['con_doc_rate']
        );

        /* bill number */
        $bill_stat = 0;
        if ($currentBillNumber == 0) {
            $bill_stat = 1;
            $billNumber = DB::table('bill_number')->max('bill_id');
            if ($billNumber)
                $currentBillNumber = $billNumber + 1;
            else
                $currentBillNumber = 1;
        }

        $billing['bill_number'] = $currentBillNumber;

        //var_dump($billing);die;
        $lastId = Billing::create($billing);
        $bid = $lastId->bid;

        /* bill number increament */
        if ($bill_stat == 1) {
            DB::table('bill_number')->insert(['bill_fy' => $fiscalYear->id]);
        }

        $test_arr = explode('-', $input['test_id']);
        $price_arr = explode('-', $input['price']);
        $test_discount = explode('-', $input['test_discount']);
        $count_test = count($test_arr);

        for ($i = 0; $i < $count_test; $i++) {
            $test_detail = array(
                'bid' => $bid,
                'test_id' => $test_arr[$i],
                'test_price' => $price_arr[$i],
                'test_discount' => $test_discount[$i]
            );

            TestDetail::create($test_detail);
        }

        echo $pid;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function testInvoicePrint($id, $data)
    {
        $id = (int)$id;

        if ($data == 'rep')
        {
            $billingDetail = DB::table('billing_detail')
                ->where('bid', $id)
                ->orderBy('bid', 'desc')
                ->first();

            $patient = $this->patient->findOrFail($billingDetail->patient_id);
        } else {
            $patient = $this->patient->findOrFail($id);

            $billingDetail = DB::table('billing_detail')
                ->where('patient_id', $patient->id)
                ->orderBy('bid', 'desc')
                ->first();
        }

        $testDetails = DB::table('test_detail')
            ->where('bid', $billingDetail->bid)
            //->orderBy('bid', 'desc')
            ->get();

        $user = DB::table('users')
            ->where('id', $billingDetail->user_id)
            ->first();

        $doctor = Doctor::findOrFail($billingDetail->doctor_id);

        if ($billingDetail->consulting_doctor_id != null) {
            $con_doctor = Doctor::findOrFail($billingDetail->consulting_doctor_id);
        }

        $testCharge = $billingDetail->sub_total;
        $hst = $this->hst / 100 * $testCharge;
        $total = $testCharge + $hst;

        return view('backendview.billing.opd.printtestinvoice', compact('patient', 'billingDetail', 'testDetails', 'test_price', 'testName', 'hst', 'total', 'test', 'doctor', 'testCharge', 'con_doctor', 'data', 'user'));
    }

    /**
     * @param $id
     * @param $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function testInvoicePrintHos($id, $data)
    {
        $data = 'hos';
        $id = (int)$id;
        $patient = $this->patient->findOrFail($id);

        $billingDetail = DB::table('billing_detail')
            ->where('patient_id', $patient->id)
            ->orderBy('bid', 'desc')
            ->first();

        $testDetails = DB::table('test_detail')
            ->where('bid', $billingDetail->bid)
            //->orderBy('bid', 'desc')
            ->get();

        $user = DB::table('users')
            ->where('id', $billingDetail->user_id)
            ->first();

        $doctor = Doctor::findOrFail($billingDetail->doctor_id);

        if ($billingDetail->consulting_doctor_id != null) {
            $con_doctor = Doctor::findOrFail($billingDetail->consulting_doctor_id);
        }

        $testCharge = $billingDetail->sub_total;
        $hst = $this->hst / 100 * $testCharge;
        $total = $testCharge + $hst;

        return view('backendview.billing.opd.printtestinvoicehos', compact
        (
            'patient',
            'billingDetail',
            'testDetails',
            'test_price',
            'testName',
            'hst',
            'total',
            'test',
            'doctor',
            'testCharge',
            'con_doctor',
            'data',
            'user'
        ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getTestsList(Request $request)
    {
        $test = $request->get('test');
        $testlist = Category::where('level', 2)->where('title', 'like', $test . '%')->get();
        return $testlist;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getTestPrice(Request $request)
    {
        $id = $request->get('id');
        $detail = Category::find($id);
        return $detail->price;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function emergencyPatient()
    {

        $department = DB::table('departments')
            ->where('name', 'Emergency')
            ->first();

        $patients = $this->patient
            ->where('user_id', Auth::user()->id)
            ->where('department_id', $department->id)
            ->where('status', '=', 'Active')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->orderBy('id', 'DESC')
            ->groupBy('patient_code')
            ->paginate(10);

        return view('backendview.billing.opd.emergency_patient', compact('patients'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function emergencyPatientCreate()
    {
        $nationality = $this->nationality->all();


        $departments = $this->department
            ->where('name', 'Emergency')
            ->get();

        $doctors = $this->doctor
            ->where('status', 'Active')
            ->get();
        $consultingFee = $this->consultingFee->all();

        $dataByDepartment = DB::table('departments')
            ->where('name', 'Emergency')
            ->first();

        $patients = $this->patient
            ->orderBy('id', 'DESC')
            ->where('patient_type', 'New')
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->where('user_id', Auth::user()->id)
            ->where('department_id', $dataByDepartment->id)
            ->paginate(10);

        $registeredPatientToday = $this->patient
            ->where('patient_type', 'New')
            ->whereDate('created_at', '=', Carbon::today()->toDateString())
            ->where('user_id', Auth::user()->id)
            ->where('department_id', $dataByDepartment->id)
            ->count();


        $patientId = DB::table('ipatients')->max('id');
        $lastInsertedId = $patientId + 1;
        $patientCode = 'TH-' . $lastInsertedId;

        return view('backendview.billing.opd.create', compact('nationality',
            'doctors',
            'departments',
            'consultingFee',
            'patients',
            'patientCode',
            'registeredPatientToday'));

    }

    /**
     * @param Request $request
     * @return int|mixed
     */
    public function getReprint(Request $request)
    {
        $id = $request->get('id');
        $patient = Patient::find($id);
        $reprint = $patient->reprint + 1;

        $update = Patient::where('id', $id)->update(['reprint' => $reprint]);


        return $reprint;
    }

    /**
     * @param $dtype
     * @param $id
     * @return int
     */
    public function getDiscountAmount($dtype, $id)
    {
        $cat = Category::find($id);
        $parent_id = $cat->parent_id;
        $cat_1 = Category::find($parent_id);
        $cat_id = $cat_1->parent_id;

        $discount = Discount::where('cat_id', $cat_id)->where('dis_type', $dtype)->get();
        if (count($discount) > 0) {
            $d_percent = $discount[0]->dis_percent;
            return $d_percent;
        } else {
            return 0;
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function testpatientlist()
    {

            $testPatients = $this->billing
                ->where('user_id', Auth::user()->id)
                ->where('status', 'Active')
                ->where('patient_type', 'test')
                ->whereDate('created_at', '>', Carbon::now()->subDays('15'))
                ->orderBy('created_at', 'DESC')
                ->paginate(30);




        return view('backendview.billing.opd.testpatientlist', compact('testPatients'));
    }

    public function searchTestpatientlist(Request $request)
    {

            $search = $request->get('search');
            $testPatients = $this->billing
                ->leftJoin('ipatient', 'billing_detail.patient_id', '=', 'ipatient.id')
                ->select('billing_detail.*')
                ->where('billing_detail.user_id', Auth::user()->id)
                ->where('billing_detail.status', 'Active')
                ->where('billing_detail.patient_type', 'test')
                ->where('ipatient.patient_code', $search)
                ->whereDate('billing_detail.created_at', '>', Carbon::now()->subDays('15'))
                ->orderBy('billing_detail.created_at', 'DESC')
                ->paginate(30);

        return view('backendview.billing.opd.testpatientlist', compact('testPatients'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getSubCategory($id)
    {
        $detail = Category::find($id);
        $parent_id = $detail->parent_id;
        return $parent_id;
    }
}
