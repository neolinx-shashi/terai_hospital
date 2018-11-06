<?php

namespace App\Http\Controllers\BackEndController;

use Intervention\Image\Facades\Image;
use App\Models\ConsultingFee;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\DoctorShift;
use App\Models\ShiftDoctor;
use App\Models\DayName;
use App\Http\Requests\DoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use DB;

class DoctorController extends Controller
{

    private $doctor;
    private $consultingFee;
    private $department;
    private $shift;
    private $shiftDoctor;
    private $dayName;

    public function __construct(Doctor $doctor,
                                ConsultingFee $consultingFee,
                                Department $department,
                                DoctorShift $shift,
                                ShiftDoctor $shiftDoctor,
                                DayName $dayName)
    {
        $this->middleware('auth');
        $this->doctor = $doctor;
        $this->consultingFee = $consultingFee;
        $this->department = $department;
        $this->shift = $shift;
        $this->shiftDoctor = $shiftDoctor;
        $this->dayName = $dayName;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewDoctor = $this->doctor
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('backendview.admin.doctor.index', compact('viewDoctor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $consultingFee = $this->consultingFee->all();
        $department = $this->department->all();
        return view('backendview.admin.doctor.create', compact('consultingFee',
            'department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoctorRequest $request)
    {
        $input = $request->all();
        try {
            if ($input) {
                $destinationPath = 'uploads/Doctors';
                if ($image = Input::file('image_name')) {
                    $input['image_name'] = str_random(6) . '_' . time() . "-" . $request->file('image_name')
                            ->getClientOriginalName();
                    $request->file('image_name')->move($destinationPath, $input['image_name']);
                }

                $input['doctor_code'] = 'TH-d';
                $doctorId = Doctor::create($input);
                $lastInsertedId = $doctorId->id;

                session()->flash('success', 'Record added successfully . Please assign shift');
                return redirect('/configuration/assign/shift/' . $lastInsertedId . '');

            } else {
                session()->flash('error', 'Sorry! Could not proceed the Request.');
                return redirect()
                    ->back()
                    ->withInput();
            }
        } catch
        (Exception $e) {
            session()->flash('error', 'Sorry! Could not proceed the Request.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
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
    public
    function edit($id)
    {
        $id = (int)$id;
        $editDoctor = $this->doctor->find($id);
        $consultingFee = $this->consultingFee->all();
        $department = $this->department->all();
        return view('backendview.admin.doctor.edit',
            compact('editDoctor', 'consultingFee', 'department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(UpdateDoctorRequest $request, $id)
    {
        $id = (int)$id;
        $oldValue = Doctor::find($id);
        $input = $this->doctor->find($id);
        if ($input) {
            if (Input::file('image_name')) {
                $removeimage = $oldValue->image_name;
                if (empty($removeimage)) {
                    $input['image_name'] = str_random(6) . '_' . time() . '.' . $request->file('image_name')
                            ->getClientOriginalName();
                    $destinationpath = public_path('uploads/Doctors/');
                    $request->file('image_name')->move($destinationpath, $input['image_name']);
                    Image::make($destinationpath . $input['image_name'])->resize(1440, 520)
                        ->save($destinationpath . $input['image_name']);
                    $input->update(Input::except('image_name'));
                    session()->flash('success', 'Doctors Updated Successfully.');

                    return redirect('/configuration/doctor');
                } else {
                    unlink('uploads/Doctors/' . $removeimage);
                    $destinationpath = public_path('uploads/Doctors/');
                    $request->file('image_name')->move($destinationpath, $input['image_name']);
                    Image::make($destinationpath . $input['image_name'])->resize(1440, 520)
                        ->save($destinationpath . $input['image_name']);
                    $input->update(Input::except('image_name'));
                    session()->flash('success', 'Doctors Updated Successfully.');
                    return redirect('/configuration/doctor');
                }
            } else {
                $input->fill($request->all())->save();
                session()->flash('success', 'Doctors Updated Successfully.');
                return redirect('/configuration/doctor');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        try {

            $id = (int)$id;
            $data = $this->doctor->find($id);
            if ($data) {
                $image_name = $data->image_name;
                if ($image_name != '') {
                    $path = 'uploads/Doctors/' . $image_name;
                    @unlink($path);
                }
                $data->delete();
                session()->flash('success', 'Doctor Deleted Successfully');

                return redirect()->back();
            }

            session()->flash('error', 'Sorry unable to delete doctor');

            return redirect()->back();

        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry unable to handle the request');

            return redirect('configuration/doctor');
        }
    }


    public function shiftAssign($id) {
        $doctor = Doctor::find($id);
        $days = $this->dayName->orderBy('id', 'asc')->get();
        $today = date("l");

        $data_list = array();

        foreach ($days as $key => $day) {
            $data_list[$key]['day'] = $day->name;

            $shifts = DoctorShift::where('day_id', $day->id)->orderBy('id', 'asc')->get();
            foreach ($shifts as $skey => $shift) {
                $data_list[$key]['shift'][$skey]['start_time'] = $shift->start_time;
                $data_list[$key]['shift'][$skey]['end_time'] = $shift->end_time;
                $data_list[$key]['shift'][$skey]['shift_type'] = $shift->shift_type;
                $data_list[$key]['shift'][$skey]['status'] = $shift->status;
                $data_list[$key]['shift'][$skey]['shift_id'] = $shift->id;
                $sid = $shift->id;

                $doc_rel = ShiftDoctor::where('shift_id', $shift->id)->get();
                foreach ($doc_rel as $dkey => $doc) {
                    if ($id == $doc->doctor_id && $sid == $doc->shift_id) {
                        $checked = 1;
                        $data_list[$key]['shift'][$skey]['rel_stat'] = $checked;
                    } else {
                        $checked = 0;
                    }
                }
            }
        }

        //var_dump($data_list);die;

        return view('backendview.admin.doctor.shiftAssign', compact('days', 'data_list', 'doctor', 'id','today'));
    }

    public function assignShiftToDoctor(Request $request, $id)
    {
        $id = (int)$id;
        $shiftId = $request->get('shift_id');
        $doctorId = $id;

        $data = DB::table('doctor_shift_relation')
            ->where('doctor_id', $doctorId)
            ->delete();

        $shift_id = Input::get('shift_id');

        if ($shift_id == null) {

            session()->flash('error', 'You are unable to assign shift.Please assign at least one shift ');
            return redirect('configuration/assign/shift/' . $id);
        } else {

            for ($i = 0; $i < count($shiftId); $i++) {
                $dataSet[] = [
                    'doctor_id' => $doctorId,
                    'shift_id' => Input::get('shift_id')[$i],
                ];

            }


            DB::table('doctor_shift_relation')->insert($dataSet);
            session()->flash('success', 'Shift has been assigned Successfully');
            return redirect('configuration/assign/shift/' . $id);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function DoctorStatus($id)
    {
        $doctor = $this->doctor->find($id);
        $doctor->status = ($doctor->status == 'Active') ? 'Inactive' : 'Active';
        if ($doctor->update()) {
            session()->flash('success', ' Status has been updated successfully!');
        } else {
            session()->flash('error', 'Sorry! Could not complete the request.');
        }
        return redirect('/configuration/doctor');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
}
