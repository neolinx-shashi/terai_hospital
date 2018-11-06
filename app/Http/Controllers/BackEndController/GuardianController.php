<?php

namespace App\Http\Controllers\BackEndController;

use App\Models\IPatient;
use Illuminate\Http\Request;
use App\Models\PatientGuardian;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\QueryException;

use DB;
use Illuminate\Support\Facades\Session;

class GuardianController extends Controller
{
    private $patientGuardian;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(PatientGuardian $patientGuardian, IPatient $IPatient)
    {
        $this->patientGuardian = $patientGuardian;
        $this->IPatient = $IPatient;
    }

    public function index()
    {
        $guardian = $this->patientGuardian->paginate(10);
        $patient = $this->IPatient->paginate(10);
        return view('backendview.enrollment.ipd.guardian.guardian', compact('guardian', 'patient'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $patient = $this->IPatient->all();
        return view('backendview.enrollment.ipd.guardian.guardian', compact('patient'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        try {
            if ($request->all()) {
                $guardian_id= Session::get('pat');
                $input['pat'] = $guardian_id;
                $user_id = Auth::user()->id;
                $input['user_id'] = $user_id;
                $input['iPatient_id'] = $input->patient_id;
//                dd($input);

                PatientGuardian::create($input);
                Session::put('guard', $input);
                dd($request->session()->get('guard'));


                session()->flash('success', 'Guardian added Successfully');
                return redirect('ip-enrollment/create');
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
}
