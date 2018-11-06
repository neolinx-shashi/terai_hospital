<?php

namespace App\Http\Controllers\BackEndController;
use Illuminate\Http\Request;
use App\Http\Requests\DoctorShiftRequest;
use Illuminate\Support\Facades\Input;
use App\Models\Department;
use App\Models\DoctorShift;
use App\Models\DayName;
use App\Http\Controllers\Controller;
use DB;
use DateTime;

class DoctorShiftController extends Controller
{

    private $department;
    private $shift;
    private $dayName;


    public function __construct(Department $department,
                                DoctorShift $shift,
                                DayName $dayName)
    {
        $this->middleware('auth');
        $this->department=$department;
        $this->shift=$shift;
        $this->dayName=$dayName;
    }
   

    public function index()
    {

           $dayName =$this->dayName
         ->orderBy('id','asc')
         ->get();
    
           $shiftTime =$this->shift->orderBy('id','asc')->get();
            return view('backendview.admin.shiftSetup.index',compact('dayName','shiftTime'));
    }

    
    public function create()
    {
         $dayName =$this->dayName
         ->orderBy('id','asc')
         ->get();


        return view('backendview.admin.shiftSetup.create',compact('dayName'));
    }

    
    public function store(DoctorShiftRequest $request)
    {
        $input=$request->all();

    
        try {
            if ($request->all()) {

                $names = $request->get('day_id');
                $startTime = $request->get('start_time');
                $endTime = $request->get('end_time');
                $shiftType=$request->get('shift_type');

               
                 
                for ($i = 0; $i < count($startTime); $i++) {
                   $dataSet[] = [
                            'day_id' => Input::get('day_id'),
                            'start_time' => Input::get('start_time')[$i],
                            'end_time' => Input::get('end_time')[$i],
                            'shift_type'=>Input::get('shift_type')[$i]
                        ];
                 
                }
                 if($startTime!=$endTime)
                {
                 DB::table('tbl_shift')->insert($dataSet);

                session()->flash('success', 'Shift added successfully');
                return redirect('/configuration/shift-setup');
            }

            else
            {
               session()->flash('error', 'Start and End time cannot be same'); 
               return redirect()
                    ->back();
            }
            } else {
                return redirect()
                    ->back()
                    ->withInput();
                    
            }
        } catch (Exception $e) {
            session()->flash('error', 'Sorry unable to handle the request');
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
       $id = (int)$id;
        if ($request->all()) {
            $data = $this->shift->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                session()->flash('edit', 'Shift updated Successfully');
                return redirect('configuration/shift-setup');
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to handle the request');
        return redirect('configuration/shift-setup');
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
            $data = $this->shift->find($id);
            if ($data) {
                $data->delete();
                session()->flash('success', 'Shift Deleted Successfully');
                return redirect()->back();
            }
            session()->flash('error', 'Sorry unable to handle the request');
            return redirect()->back();

        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry unable to handle the request');
            return redirect('configuration/shift-setup');
        }
    }
}
