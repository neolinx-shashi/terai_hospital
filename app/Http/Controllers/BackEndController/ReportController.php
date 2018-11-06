<?php

namespace App\Http\Controllers\BackEndController;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Billing;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    private $patient;
    private $billing;

    public function __construct(Patient $patient, Billing $billing)
    {
        $this->middleware('auth');
        $this->patient = $patient;
        $this->billing = $billing;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dailyReport()
    {
        $opdPatient = DB::table('ipatient')
            ->where('refund_status', 'Active')
            ->where('patient_type', '=', 'OPD')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->sum('doctor_fee_with_tax');

        $countPatients = $this->patient
            ->where('refund_status', 'Active')
            ->where('patient_type', '=', 'OPD')
            ->where('user_id', '=', Auth::user()->id)
            ->where('patient_type', '=', 'OPD')
            //->orWhere('patient_type', '=', 'renew')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->count();

        $testTotal = $this->billing
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('status', 'Active')
            ->sum('grand_total');

        $testPatients = $this->billing
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('status', 'Active')
            ->get();

        $emergencyPatientData = DB::table('ipatient')
            ->where('patient_type', '=', 'Emergency')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->sum('doctor_fee_with_tax');

        $emergencyCount = DB::table('ipatient')
            ->where('patient_type', '=', 'Emergency')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->count();

        $deposits = DB::table('ipatient')
            ->whereDate('updated_at', '=', Carbon::now()->toDateString())
            ->get();

        $total_deposit = 0;
        foreach ($deposits as $key => $deposit) {
            $deposit_amounts = $deposit->deposit_amount;
            $dep_amt_arr = explode(',', $deposit_amounts);

            $deposit_dates = $deposit->deposit_dates;
            $dep_date_arr = explode(',', $deposit_dates);

            $deposit_user_id = $deposit->deposit_user_id;
            $dep_id_arr = explode(',', $deposit_user_id);

            foreach ($dep_id_arr as $key1 => $id) {
                if ($dep_date_arr[$key1] == Carbon::now()->toDateString() && $id == Auth::user()->id) {
                    $total_deposit += $dep_amt_arr[$key1];
                }
            }
        }

        $ipdadmissionData = DB::table('ipatient')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->sum('admission_charge_with_tax');

        $ipdCount = DB::table('ipatient')
            ->where('patient_type', '=', 'IPD')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->count();

        $ipd_discharge_received = DB::table('discharge_details')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->sum('received_amount');

        $ipd_discharge_returned = DB::table('discharge_details')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->sum('returned_amount');

        /*$discharged_patients = DB::table('discharge_details')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->get();

        $total_returned_amt = 0;
        foreach ($discharged_patients as $patient)
        {
            $deposits = DB::table('ipatient')
                ->get();

            $total_deposit_amt = 0;
            foreach ($deposits as $key => $deposit) {
                if ($patient->ipatient_id == $deposit->id) {
                    $deposit_amounts = $deposit->deposit_amount;
                    $dep_amt_arr = explode(',', $deposit_amounts);

                    foreach ($dep_amt_arr as $dep) {
                        $total_deposit_amt += $dep;
                    }
                    if ($total_deposit_amt > $patient->total_after_tax) {
                        $returned_amount = $total_deposit_amt - $patient->total_after_tax;
                    } else {
                        $returned_amount = 0;
                    }
                }
            }
            $total_returned_amt += $returned_amount;
        }*/

        $ipdDischargeCount = DB::table('discharge_details')
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->count();

        $totalCollection = $opdPatient + $total_deposit + $emergencyPatientData + $testTotal + $ipd_discharge_received - $ipd_discharge_returned + $ipdadmissionData;

        $refundedOPDPatientsToday = $this->patient
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('user_id', '=', Auth::user()->id)
            ->where('patient_type', '=', 'OPD')
            ->where('refund_status', '=', 'Inactive')
            ->count();

        $refundedOPDPatientsTotal = $this->patient
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('user_id', '=', Auth::user()->id)
            ->where('patient_type', '=', 'OPD')
            ->where('refund_status', '=', 'Inactive')
            ->sum('doctor_fee_with_tax');

        $refundedTestPatientsToday = $this->billing
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('user_id', '=', Auth::user()->id)
            ->where('status', '=', 'Inactive')
            ->count();

        $refundedTestPatientsTotal = $this->billing
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('user_id', '=', Auth::user()->id)
            ->where('status', '=', 'Inactive')
            ->sum('grand_total');

        return view('backendview.dashboard.billing.report', compact('countPatients', 'opdPatient',
            'patients',
            'testTotal',
            'testPatients',
            'emergencyPatientData',
            'total_deposit',
            'emergencyCount',
            'ipdCount',
            'totalCollection',
            'ipdDischargeCount',
            'refundedOPDPatientsToday',
            'refundedTestPatientsToday',
            'refundedOPDPatientsTotal',
            'refundedTestPatientsTotal',
            'ipdadmissionData',
            'ipd_discharge_received',
            'ipd_discharge_returned'
        ));
    }
}
