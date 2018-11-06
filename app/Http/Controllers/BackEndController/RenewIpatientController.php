<?php

namespace App\Http\Controllers\BackEndController;

use App\Models\Department;
use App\Models\IPatient;
use App\Models\Ward;
use App\Models\Room;
use App\Models\Bed;
use App\Models\Nationality;
use App\Models\ConsultingFee;
use App\Models\BloodGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\IPatientRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use DB;

class RenewIpatientController extends Controller
{

    private $ipatient;
    private $nationality;
    private $bloodGroup;
    private $ward;
    private $room;
    private $bed;
    private $patientGuardian;
    private $patientReferrer;

    public function __construct(IPatient $ipatient,
                                Nationality $nationality,
                                BloodGroup $bloodGroup,
                                Ward $ward,
                                Room $room,
                                Bed $bed
    )
    {
        $this->ipatient = $ipatient;
        $this->nationality = $nationality;
        $this->bloodGroup = $bloodGroup;
        $this->ward = $ward;
        $this->room = $room;
        $this->bed = $bed;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
//        $patients = $this->ipatient->paginate(10);
//        $patientStatus = $this->ipatient->pluck('status');
//        if ($patientStatus == 'Active') {
//            $patientStatus = 'In Ward';
//        } else {
//            $patientStatus = 'Discharged';
//        }
//        return view('backendview.enrollment.ipd.index', compact('patients', 'patientStatus'));
    }


    public function create()
    {
//        $nationality = $this->nationality->all();
//        $bloodGroup = $this->bloodGroup->all();
//        $wards = $this->ward->all();
//        $rooms = $this->room->all();
//        $beds = $this->bed->all();
//        $patients = $this->ipatient->
//        orderBy('id', 'DESC')
//            ->paginate(7);
//        $patientId = DB::table('ipatient')->max('id');
//        $lastInsertedId = $patientId + 1;
//        $patientCode = 'TH-IP' . $lastInsertedId;
//        return view('backendview.enrollment.ipd.create', compact('nationality',
//            'patients',
//            'bloodGroup',
//            'wards',
//            'rooms',
//            'beds',
//            'patientCode'));
    }


    public function store(Request $request)
    {
        $input = $request->all();
        try {
            if ($request->all()) {
                $user_id = Auth::user()->id;
                $input['user_id'] = $user_id;
                $input['patient_type'] = 'Renew';

                // $patientId='TH-'
                $ipatient = IPatient::create($input);
                $id = $ipatient->id;

                $bed = $this->bed->findOrFail($request->bed_id);
                $bed->availability = 'Unavailable';
                $bed->save();

                session()->flash('success', 'Patient added Successfully');
                return redirect('ip-enrollment/patients');
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

        $patient = $this->ipatient->findOrFail($id);
        return view('backendview.enrollment.ipd.show', compact('patient'));
    }


    public function edit($id)
    {
        $id = (int)$id;
        $editPatients = $this->ipatient->findOrFail($id);
        $nationality = $this->nationality->all();
        $bloodGroup = $this->bloodGroup->all();
        $wards = $this->ward->all();
        $rooms = $this->room->all();
        $beds = $this->bed->all();
        $patients = $this->ipatient->
        orderBy('id', 'DESC')
            ->paginate(7);
        return view('backendview.enrollment.ipd.renewipatient', compact('editPatients',
            'bloodGroup',
            'nationality',
            'patients',
            'wards',
            'rooms',
            'beds'));
    }

    /**
     * @param PatientRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $id = (int)$id;
        if ($request->all()) {
            $data = $this->ipatient->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                $bed = $this->bed->findOrFail($request->bed_id);
                $bed->availability = ($bed->availability == 'Unavailable') ? 'Available' : 'Unavailable';
            }
            $bed->update();
            session()->flash('success', 'Patient updated Successfully');
            return redirect('ip-enrollment/patients');
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to handle the request');
        return redirect('ip-enrollment/patients');
    }


    public function editGuardian($id)
    {
        $id = (int)$id;
        $editPatients = $this->ipatient->findOrFail($id);
        return view('backendview.enrollment.ipd.guardian.guardian', compact('editPatients',
            'nationality'));
    }

    /**
     * @param PatientRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addGuardian(Request $request, $id)
    {
        $id = (int)$id;
        if ($request->all()) {
            $data = $this->ipatient->find($id);
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


    public function editReferrer($id)
    {
        $id = (int)$id;
        $editPatients = $this->ipatient->findOrFail($id);
        return view('backendview.enrollment.ipd.referrer.referrer', compact('editPatients',
            'nationality'));
    }

    /**
     * @param PatientRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addReferrer(Request $request, $id)
    {
        $id = (int)$id;
        if ($request->all()) {
            $data = $this->ipatient->find($id);
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
//        try {
//            $id = (int)$id;
//            $data = $this->ipatient->find($id);
//            if ($data) {
//                $data->delete();
//                session()->flash('success', 'Patient Deleted Successfully');
//            }
//            return redirect()->back();
//            session()->flash('error', 'Sorry unable to delete patient');
//            return redirect()->back();
//
//        } catch (QueryException $e) {
//            session()->flash('foreignerror', 'Sorry unable to handle the request');
//            return redirect('ip-enrollment');
//        }
    }

    public function Discharge()
    {
        $patients = $this->ipatient->paginate(10);
        $patientStatus = $this->ipatient->pluck('status');
        if ($patientStatus == 'Active') {
            $patientStatus = 'In Ward';
        } else {
            $patientStatus = 'Discharged';
        }
        return view('backendview.enrollment.ipd.discharge', compact('patients'));
    }

    public function dischargePatient($id)
    {
//        try {
        $id = (int)$id;
        $data = $this->ipatient->pluck('status');
        foreach ($data as $d) {
            if ($d != 'Active') {
                $data = 'Inactive';
            } else {
                $data = 'Active';
            }
        }
        return $data;
    }

    public function liveSearch(Request $request)
    {
        $search = $request->id;

        if (is_null($search)) {
            return view('backendview.enrollment.ipd.livesearch');
        } else {
            $posts = IPatient::select('ipatient.*')
                ->where('patient_type', '=', 'IPD')
                ->where(function ($query) use ($search) {
                    $query->orWhere('phone', 'like', '%' . $search . '%')
                        ->orWhere('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%')
                        ->orWhere('patient_code', 'like', '%' . $search . '%');
                       

                })
                ->groupBy('patient_code')
                ->orderBy('created_at','dsc')
                ->get();


            return view('backendview.enrollment.ipd.livesearchajax')->withPosts($posts);
        }
    }
}
