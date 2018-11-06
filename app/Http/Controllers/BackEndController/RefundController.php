<?php

namespace App\Http\Controllers\BackEndController;

use App\Models\EmergencyPatient;
use App\Models\IPatient;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Billing;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Response;

class RefundController extends Controller
{
    private $patient;
    private $billing;
    private $emergencyPatient;

    public function __construct(IPatient $patient, Billing $billing, EmergencyPatient $emergencyPatient)
    {
        $this->middleware('auth');
        $this->patient = $patient;
        $this->billing = $billing;
        $this->emergencyPatient = $emergencyPatient;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refundView()
    {
        if (Auth::user()->user_type_id == '4') {
            $patients = $this->patient
                //->where('user_id', '=', Auth::user()->id)
                ->where('patient_type', '=', 'OPD')
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->orderBy('created_at', 'DESC')
                ->paginate(10);


            $testPatients = $this->billing
                //->where('user_id', '=', Auth::user()->id)
                ->where('patient_type', 'test')
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            $emrPatients = $this->emergencyPatient
                ->orderBy('id', 'DESC')
                ->where('patient_type', 'Emergency')
                ->where('status', '!=', 'Discharged')
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->groupBy('patient_code')
                ->paginate(10);

        } else {
            $patients = $this->patient
                ->where('user_id', '=', Auth::user()->id)
                ->where('patient_type', '=', 'OPD')
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            $testPatients = $this->billing
                ->where('patient_type', 'test')
                ->where('user_id', '=', Auth::user()->id)
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            $emrPatients = $this->emergencyPatient
                ->orderBy('id', 'DESC')
                ->where('patient_type', 'Emergency')
                ->where('status', '!=', 'Discharged')
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->groupBy('patient_code')
                ->paginate(10);
        }
        $srch = 'opd';
        return view('backendview.refund.index', compact('patients',
            'testPatients', 'emrPatients', 'srch'
        ));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function refund($id)
    {
        session()->forget('opd_patient_id');

        $id = (int)$id;
        $patient = $this->patient->find($id);
        $patient->refund_status = ($patient->refund_status == 'Active') ? 'Inactive' : 'Active';
        session(['tabName' => 'opd']);

        $patients = $this->patient
            ->where('user_id', '=', Auth::user()->id)
            ->where('patient_type', '!=', '')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->orderBy('created_at', 'DESC')->paginate(10);

        $testPatients = $this->billing
            ->where('user_id', '=', Auth::user()->id)
            ->where('patient_type', '=', 'test')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->orderBy('created_at', 'DESC')->paginate(10);

        if ($patient->save()) {
            session()->flash('success', ' Patient fee refunded successfully.');
        } else {
            session()->flash('error', 'Sorry! Could not complete the request.');
        }
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function testRefund($id)
    {
        $id = (int)$id;
        $patient = $this->billing->findOrFail($id);
        $patient->status = ($patient->status == 'Active') ? 'Inactive' : 'Active';


        session(['tabName' => 'test']);

        $patients = $this->patient
            ->where('user_id', '=', Auth::user()->id)
            ->where('patient_type', '!=', '')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->orderBy('created_at', 'DESC')->paginate(10);

        $testPatients = $this->billing
            ->where('user_id', '=', Auth::user()->id)
            ->where('patient_type', '=', 'test')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->orderBy('created_at', 'DESC')->paginate(10);

        if ($patient->save()) {

            $response = array(
                'status' => 'success',
                'msg' => 'Patient Refunded successfully',
                'refund' => 'Refunded',


            );

            return Response::json($response);
            //session()->flash('success', ' Patient fee refunded successfully.');
        } else {
            session()->flash('error', 'Sorry! Could not complete the request.');
        }
        return redirect()->back();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function cancelRefund($id)

    {

        $id = (int)$id;
        $patient = $this->patient->find($id);
        $patient->refund_status = ($patient->refund_status == 'Active') ? 'Inactive' : 'Active';
        session(['tabName' => 'opd']);

        $patients = $this->patient
            ->where('user_id', '=', Auth::user()->id)
            ->where('patient_type', '!=', '')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->orderBy('created_at', 'DESC')->paginate(10);

        $testPatients = $this->billing
            ->where('user_id', '=', Auth::user()->id)
            ->where('patient_type', '=', 'test')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->orderBy('created_at', 'DESC')->paginate(10);

        if ($patient->save()) {
            session()->flash('success', ' Refund cancelled successfully.');
        } else {
            session()->flash('error', 'Sorry! Could not complete the request.');
        }
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cancelTestRefund($id)
    {
        $id = (int)$id;
        $patient = $this->billing->find($id);
        $patient->status = ($patient->status == 'Active') ? 'Inactive' : 'Active';
        session(['tabName' => 'test']);

        $patients = $this->patient
            ->where('user_id', '=', Auth::user()->id)
            ->where('patient_type', '!=', '')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->orderBy('created_at', 'DESC')->paginate(10);

        $testPatients = $this->billing
            ->where('user_id', '=', Auth::user()->id)
            ->where('patient_type', '=', 'test')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->orderBy('created_at', 'DESC')->paginate(10);

        if ($patient->save()) {
            session()->flash('success', ' Refund cancelled successfully.');
        } else {
            session()->flash('error', 'Sorry! Could not complete the request.');
        }
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refundedPatients()
    {
        $patients = $this->patient
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('refund_status', '=', 'Inactive')
            ->orderBy('created_at', 'DESC')
            ->groupBy('patient_code')
            ->paginate(10);

        $testPatients = $this->billing
            ->where('user_id', '=', Auth::user()->id)
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->where('status', '=', 'Inactive')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('backendview.refund.refunded_patients', compact('patients',
            'testPatients'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function refundPage($id)
    {
        $id = (int)$id;
        $patient = $this->patient->findOrFail($id);
        return view('backendview.refund.refund', compact('patient'));
    }

    /* refund patient */
    public function refundPatient(Request $request)
    {
        $pid = $request->get('pid');
        $remark = $request->get('remark');
        $n = $request->get('n');

        if ($n == 1) {
            $update = Billing::where('bid', $pid)
                ->update([
                    'refund_remark' => $remark,
                    'status' => 'Inactive',
                    'refund_user_id' => Auth::user()->id
                ]);
        } else {
            $update = Patient::where('id', $pid)
                ->update([
                    'refund_remark' => $remark,
                    'refund_status' => 'Inactive',
                    'refund_user_id' => Auth::user()->id
                ]);
        }

        if ($update)
            return '1';
        else
            return '0';
    }


    /* Search OPD patient */
    public function searchOpdPatient(Request $request) {
        $srch = 'opd';
        $code = $request->input('opd_search');

        if ($code == '') {
            return redirect('/refund-view');
        }

        $p_id = $this->patient->where('patient_code', $code)->select('id')->first();
       
        if (Auth::user()->user_type_id == '4') {
            $patients = $this->patient
                //->where('user_id', '=', Auth::user()->id)
                ->where('patient_type', '=', 'OPD')
                ->where('patient_code', $code)
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->orderBy('created_at', 'DESC')
                ->paginate(10);


            $testPatients = $this->billing
                //->where('user_id', '=', Auth::user()->id)
                ->where('patient_type', 'test')
                ->where('patient_id', $p_id)
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            $emrPatients = $this->emergencyPatient
                ->orderBy('id', 'DESC')
                ->where('patient_type', 'Emergency')
                ->where('status', '!=', 'Discharged')
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->groupBy('patient_code')
                ->paginate(10);

        } else {
            $patients = $this->patient
                ->where('user_id', '=', Auth::user()->id)
                ->where('patient_type', '=', 'OPD')
                ->where('patient_code', $code)
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            $testPatients = $this->billing
                ->where('patient_type', 'test')
                ->where('user_id', '=', Auth::user()->id)
                ->where('patient_id', $p_id)
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            $emrPatients = $this->emergencyPatient
                ->orderBy('id', 'DESC')
                ->where('patient_type', 'Emergency')
                ->where('status', '!=', 'Discharged')
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->groupBy('patient_code')
                ->paginate(10);
        }
        return view('backendview.refund.index', compact('patients',
            'testPatients', 'emrPatients', 'code', 'srch'
        ));
    }


    /* Search Test patient */
    public function searchTestPatient(Request $request) {
        $srch = 'test';
        $code = $request->input('test_search');
        if ($code == '') {
            return redirect('/refund-view');
        }
        $p_id = $this->patient->where('patient_code', $code)->select('id')->first();
        
        if (Auth::user()->user_type_id == '4') {
            $patients = $this->patient
                //->where('user_id', '=', Auth::user()->id)
                ->where('patient_type', '=', 'OPD')
                ->where('patient_code', $code)
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            $testPatients = $this->billing
                //->where('user_id', '=', Auth::user()->id)
                ->where('patient_type', 'test')
                ->where('patient_id', $p_id->id)
                ->whereDate('created_at', '>', Carbon::now()->subDays(15)->toDateString())
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
               
            $emrPatients = $this->emergencyPatient
                ->orderBy('id', 'DESC')
                ->where('patient_type', 'Emergency')
                ->where('status', '!=', 'Discharged')
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->groupBy('patient_code')
                ->paginate(10);

        } else {
            $patients = $this->patient
                ->where('user_id', '=', Auth::user()->id)
                ->where('patient_type', '=', 'OPD')
                ->where('patient_code', $code)
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            $testPatients = $this->billing
                ->where('patient_type', 'test')
                ->where('user_id', '=', Auth::user()->id)
                ->where('patient_id', $p_id)
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->orderBy('created_at', 'DESC')
                ->paginate(10);

            $emrPatients = $this->emergencyPatient
                ->orderBy('id', 'DESC')
                ->where('patient_type', 'Emergency')
                ->where('status', '!=', 'Discharged')
                ->whereDate('created_at', '>', Carbon::now()->subDays(15))
                ->groupBy('patient_code')
                ->paginate(10);
        }
        return view('backendview.refund.index', compact('patients',
            'testPatients', 'emrPatients', 'code', 'srch'
        ));
    }
}