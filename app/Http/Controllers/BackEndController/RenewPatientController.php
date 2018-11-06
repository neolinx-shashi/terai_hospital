<?php

namespace App\Http\Controllers\BackEndController;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Nationality;
use App\Models\ConsultingFee;
use App\Models\Category;
use App\Models\Billing;
use App\Models\TestDetail;
use App\Models\FiscalYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use DB;
use Carbon\Carbon;
use App\Http\Requests\UpdatePatientRequest;


class RenewPatientController extends Controller
{

    private $patient;
    private $nationality;
    private $doctor;
    private $department;
    private $consultingFee;
    private $fiscalYear;

    public function __construct(Patient $patient,
                                Nationality $nationality,
                                Doctor $doctor,
                                Department $department,
                                ConsultingFee $consultingFee,
                                FiscalYear $fiscalYear)
    {
        $this->middleware('auth');
        $this->patient = $patient;
        $this->nationality = $nationality;
        $this->doctor = $doctor;
        $this->department = $department;
        $this->consultingFee = $consultingFee;
        $this->today = date("Y-m-d");
        $this->fiscalYear = $fiscalYear;
    }

    public function index()
    {
        //return view('backendview.billing.opd.renewpatient');
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $input = $request->all();
        try {
            if ($request->all()) {
                $user_id = Auth::user()->id;
                $input['user_id'] = $user_id;
                $input['patient_type'] = 'Renew';
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
                $patient = Patient::create($input);
                $id = $patient->id;

                session()->flash('success', 'Patient Renewed Successfully');
                return redirect('renew/patient/' . $id . '/edit');
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


    public function show($id)
    {

        $id = (int)$id;
        $viewUserData = $this->doctor->find($id);

        return view('backendview.admin.doctor.show',
            compact('viewUserData'));

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
        $editPatients = $this->patient->findOrFail($id);
        $nationality = $this->nationality->all();
        $doctors = $this->doctor->all();
        $departments = $this->department->all();
        $patients = $this->patient
            ->where('id', $id)
            ->paginate();
        return view('backendview.billing.opd.renewpatient', compact('editPatients',
            'doctors',
            'departments',
            'nationality',
            'patients'));
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }


    public function liveSearch(Request $request)
    {
        $search = $request->id;

        if (is_null($search)) {
            return view('backendview.billing.opd.livesearch');
        } else {
            $posts = Patient::select('ipatient.*')
                ->where('patient_type', '=', 'OPD')
                ->where(function ($query) use ($search) {
                    $query->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('patient_code', 'like', '%' . $search . '%');

                })
                ->groupBy('patient_code')
                ->get();

            return view('backendview.billing.opd.livesearchajax')->withPosts($posts);
        }

    }

}
