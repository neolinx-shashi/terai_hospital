<?php

namespace App\Http\Controllers\BackEndController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IPatient;
use App\Models\IPatientHistory;
use App\Http\Requests\IPatientHistoryRequest;
use Illuminate\Support\Facades\Redirect;

class PatientHistoryController extends Controller
{
    private $iPatient;
    private $iPatientHistory;

    /**
     * PatientHistoryController constructor.
     * @param IPatient $iPatient
     */
    public function __construct(IPatient $iPatient, IPatientHistory $iPatientHistory)
    {
        $this->iPatient = $iPatient;
        $this->iPatientHistory = $iPatientHistory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $iPatients = $this->iPatient->all();
        return view('backendview.enrollment.ipd.patientHistory.index', compact('iPatients'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IPatientHistoryRequest $request)
    {
        $input = $request->all();
        $this->iPatientHistory->create($input);

        return Redirect::to('ip-enrollment/patient-history');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function insertPatientDetails($id)
    {
        $id = (int)$id;
        $patient = $this->iPatient->findOrFail($id);
        return view('backendview.enrollment.ipd.patientHistory.create', compact('patient'));
    }
}
