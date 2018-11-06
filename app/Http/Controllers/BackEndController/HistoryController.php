<?php

namespace App\Http\Controllers\BackEndController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ipatient;

class HistoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('backendview.history.index');
    }

    public function searchDetail(Request $request) {
        $search = $request->input('search');


        $detail = Ipatient::where('patient_code', $search)
                    ->orWhere('first_name', 'like', '%'.$search.'%')
                    ->select('first_name', 'patient_code', 'gender', 'age', 'status', 'refund_status', 'patient_type', 'discharged_at', 'created_at', 'bill_number')
                    ->get();
        /*
        $detail = Ipatient::leftJoin('i_patient_histories', 'ipatient.id', '=', 'i_patient_histories.ipatient_id')
                    ->where('ipatient.patient_code', $search)
                    ->orWhere('ipatient.first_name', 'like', '%'.$search.'%')
                    ->select('ipatient.first_name', 'ipatient.patient_code', 'ipatient.status', 'ipatient.refund_status', 'ipatient.patient_type', 'ipatient.discharged_at', 'ipatient.created_at', 'ipatient.bill_number')
                    ->get();
        */
        $count = Ipatient::where('patient_code', $search)
                    ->orWhere('first_name', 'like', '%'.$search.'%')
                    ->count();

        return view('backendview.history.index', compact('detail', 'count', 'search'));
    }
}
