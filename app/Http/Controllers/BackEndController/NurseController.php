<?php

namespace App\Http\Controllers\BackEndController;

use App\Models\DayName;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Nurse;
use App\Models\Department;
use App\Http\Requests\NurseRequest;
use App\Http\Requests\UpdateNurseRequest;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

class NurseController extends Controller
{
    private $nurse;
    private $department;
    private $dayName;

    public function __construct(Nurse $nurse,
                                     Department $department,
                                      DayName $dayName)
    {
        $this->middleware('auth');
        $this->nurse = $nurse;
        $this->department = $department;
        $this->dayName = $dayName;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nurses = $this->nurse
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('backendview.admin.nurse.index', compact('nurses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = $this->department->all();

        return view('backendview.admin.nurse.create', compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NurseRequest $request)
    {
        $input = $request->all();
        try {
            if ($input) {
                $destinationPath = 'uploads/Nurses';
                if ($image = Input::file('image_name')) {
                    $input['image_name'] = str_random(6) . '_' . time() . "-" . $request->file('image_name')
                            ->getClientOriginalName();
                    $request->file('image_name')->move($destinationPath, $input['image_name']);
                }

                $input['nurse_code'] = 'TH-d';
                $nurseId = Nurse::create($input);
                $lastInsertedId = $nurseId->id;

                session()->flash('success', 'Record added successfully . Please assign shift');
                return redirect('/configuration/assign/shift/nurse/' . $lastInsertedId . '');

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = (int)$id;
        $nurse = $this->nurse->findOrFail($id);

        return view('backendview.admin.nurse.show', compact('nurse'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = (int)$id;
        $nurse = $this->nurse->findOrFail($id);

        return view('backendview.admin.nurse.edit', compact('nurse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNurseRequest $request, $id)
    {
        $id = (int)$id;
        $oldValue = $this->nurse->find($id);
        $input = $this->nurse->find($id);
        //dd(Input::all());
        if ($input) {
            if (Input::file('image_name')) {
                $removeimage = $oldValue->image_name;
                if (empty($removeimage)) {
                    $input['image_name'] = str_random(6) . '_' . time() . '.' . $request->file('image_name')
                            ->getClientOriginalName();
                    $destinationpath = public_path('uploads/Nurses/');
                    $request->file('image_name')->move($destinationpath, $input['image_name']);
                    Image::make($destinationpath . $input['image_name'])->resize(1440, 520)
                        ->save($destinationpath . $input['image_name']);
                    $input->update(Input::except('image_name'));
                    session()->flash('success', 'Nurse Updated Successfully.');

                    return redirect('/configuration/nurse');
                } else {
                    unlink('uploads/Nurses/' . $removeimage);
                    $destinationpath = public_path('uploads/Nurses/');
                    $request->file('image_name')->move($destinationpath, $input['image_name']);
                    Image::make($destinationpath . $input['image_name'])->resize(1440, 520)
                        ->save($destinationpath . $input['image_name']);
                    $input->update(Input::except('image_name'));
                    session()->flash('success', 'Nurse Updated Successfully.');
                    return redirect('/configuration/nurse');
                }
            } else {
                $input->fill($request->all())->save();
                session()->flash('success', 'Nurse Updated Successfully.');
                return redirect('/configuration/nurse');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $id = (int)$id;
            $data = $this->nurse->find($id);
            if ($data) {
                $image_name = $data->image_name;
                if ($image_name != '') {
                    $path = 'uploads/Doctors/' . $image_name;
                    @unlink($path);
                }
                $data->delete();
                session()->flash('success', 'Nurse Deleted Successfully!');

                return redirect()->back();
            }

            session()->flash('error', 'Sorry unable to delete nurse!');

            return redirect()->back();

        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry unable to handle the request!');

            return redirect('configuration/nurse');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shiftAssign($id)
    {
        $dayName = $this->dayName
            ->orderBy('id', 'asc')
            ->get();

        $shiftTime = DB::table('tbl_shift')
            ->leftJoin('nurse_shift_relation', 'tbl_shift.id', '=', 'nurse_shift_relation.shift_id')
            ->select('tbl_shift.id as shiftId',
                'tbl_shift.day_id',
                'tbl_shift.start_time',
                'tbl_shift.end_time',
                'tbl_shift.shift_type',
                'nurse_shift_relation.id as ScheduleShift',
                'nurse_shift_relation.shift_id as ScheduleShiftId',
                'nurse_shift_relation.nurse_id as nurseId'
            )
            ->groupBy('tbl_shift.id')
            ->orderBy('tbl_shift.id', 'desc')
            ->get();

        $nurse_id = (int)$id;
        $nurseName = $this->nurse
            ->where('id', $id)
            ->first();


        return view('backendview.admin.nurse.shiftAssign', compact('dayName',
            'shiftTime',
            'nurse_id',
            'nurseName'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function assignShiftToNurse(Request $request, $id)
    {
        $id = (int)$id;
        $shiftId = $request->get('shift_id');
        $nurseId = $id;

        $data = DB::table('nurse_shift_relation')
            ->where('nurse_id', $nurseId)
            ->delete();

        $shift_id = Input::get('shift_id');

        if ($shift_id == null) {

            session()->flash('error', 'You are unable to assign shift.Please assign at least one shift ');
            return redirect('configuration/assign/shift/' . $id);
        } else {

            for ($i = 0; $i < count($shiftId); $i++) {
                $dataSet[] = [
                    'nurse_id' => $nurseId,
                    'shift_id' => Input::get('shift_id')[$i],
                ];

            }


            DB::table('nurse_shift_relation')->insert($dataSet);
            session()->flash('success', 'Shift has been assigned Successfully');
            return redirect('configuration/assign/shift/nurse/' . $id);
        }
    }
}
