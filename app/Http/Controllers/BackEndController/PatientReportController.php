<?php

namespace App\Http\Controllers\BackEndController;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IPatient;
use App\Models\Doctor;
use App\Models\PatientReport;
use DB;


class PatientReportController extends Controller
{
    private $ipatient;
    private $doctor;
    private $patientReport;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(IPatient $ipatient,
                                             Doctor $doctor,
                                              PatientReport $patientReport)
    {
        $this->ipatient = $ipatient;
        $this->doctor = $doctor;
        $this->patientReport = $patientReport;
    }

    public function index()
    {
        $reports = $this->patientReport->paginate(10);
        return view('backendview.enrollment.ipd.patientReport.index',compact('reports'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        dd('1');
//        $doctor = $this->doctor->all();
//        return view('backendview.enrollment.ipd.patientReport.create', compact('doctor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function createReport($id)
    {
        $id = (int)$id;
        $patient = $this->ipatient->findOrFail($id);
        $doctors = $this->doctor->all();
        $reports = $this->patientReport->all();
        $patient_id = $patient->id;
//        dd($patient_id);
        $reportId = DB::table('patientReport')->max('id');
        $lastInsertedId = $reportId + 1;
        $reportCode = 'RP-' . $lastInsertedId;
//        $patient_code = $patient->ipatient_code;
        return view('backendview.enrollment.ipd.patientReport.create', compact('patient',
            'doctors',
            'reportCode',
            'patient_code',
            'reports',
            'patient_id'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        try {
            if ($request->all()) {
//                $reportId = DB::table('patientReport')->max('id');
//                $lastInsertedId = $reportId + 1;
//                $input['report_number'] = 'RP-' . $lastInsertedId;



                PatientReport::create($input);
                session()->flash('success', 'Report Created Successfully');
                return redirect('ip-enrollment/patient-report/');
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

    public function printReport($id){
        $id = (int)$id;
        $report = $this->patientReport->findOrFail($id);
        return view ('backendview.enrollment.ipd.patientReport.report',compact('report'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = int($id);
        $report = $this->patientReport->findOrFail($id);
//        $patient_code = $this->ipatient->ipatient_code;
        return view ('backendview.enrollment.ipd.patientReport.show', compact('report'));
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

    public function liveSearch(Request $request)
    {
        $search = $request->id;

       
        if (is_null($search)) {
            return view('backendview.enrollment.ipd.patientReport.livesearch');
        } else {
            $posts = $this->ipatient->where('patient_code', 'LIKE', "%{$search}%")
//                ->where('status', 'LIKE', 'Discharged')
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->groupBy('patient_code')
                ->get();


            return view('backendview.enrollment.ipd.patientReport.livesearchajax')->withPosts($posts);
        }
    }
}
