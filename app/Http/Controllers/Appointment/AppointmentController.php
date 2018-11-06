<?php

namespace App\Http\Controllers\Appointment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorShift;
use App\Models\ShiftDoctor;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function __construct() {
        $this->days = array(
            '', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'
            );

        $this->today = date("Y-m-d");
    }

    public function index() {
        $today = date("Y-m-d");
        $day = date("w");
        //$doctors = Doctor::orderBy('first_name', 'asc')->get();
        $doctors = Doctor::leftJoin('departments', 'doctors.department_id', '=', 'departments.id')
         ->select('doctors.*', 'departments.name', 'departments.department_code', 'departments.status') 
            ->orderBy('doctors.first_name', 'asc')
            ->get();

        foreach ($doctors as $key => $list) {
            $schedule = DB::table('doctor_shift_relation')
                ->leftJoin('tbl_shift', 'doctor_shift_relation.shift_id', '=', 'tbl_shift.id')
                ->leftJoin('doctors', 'doctor_shift_relation.doctor_id', '=', 'doctors.id')
                ->where('doctors.id', $list->id)
                ->get();

            $doctors[$key]['schedule'] = $schedule;
        }

        $departments = Department::orderBy('name', 'asc')->get();
        $department = 0;
        $days = $this->days;

        return view('appointment.doctorlist', compact('doctors', 'departments', 'department', 'days'));
    }

    public function reserve($doc_id, $shift_id) {
        return view('appointment.appointment_view', compact('doc_id', 'shift_id'));
    }

    public function operatereserve(Request $request) {
        $input = $request->all();



        $data = array(
            'patient_contact' => $input['patient_contact'],
            'patient_name' => $input['patient_name'],
            'res_date' => $input['appointment_date'],
            'res_doc_id' => $input['doc_id'],
            'res_shift_id' => $input['shift_id']
        );



        $insert = Appointment::create($data);

        if ($insert) {
            $message = 'Data Saved Successfully.';
        } else {
            $message = 'Data Saving Failed. Try Again.';
        }
        $request->session()->flash('message', $message);

        return redirect('appointment');
    }

    public function searchDoctor(Request $request) {
        $keyword = $request->get('keyword');
        $department = $request->get('department');

        /*
        $doctors = Doctor::leftJoin('departments', 'doctors.department_id', '=', 'departments.id')
                    ->orderBy('doctors.first_name', 'asc')
                    ->get();
        */

        if ($department == 0) {
            $doctors = Doctor::leftJoin('departments', 'doctors.department_id', '=', 'departments.id')
                ->where('doctors.first_name', 'like', '%'.$keyword.'%')
                ->orWhere('doctors.last_name', 'like', '%'.$keyword.'%')
                ->orWhere('departments.name', 'like', '%'.$keyword."%")
                ->orderBy('doctors.first_name', 'asc')
                ->get();
            } else {
                $doctors = Doctor::leftJoin('departments', 'doctors.department_id', '=', 'departments.id')
                ->where('doctors.department_id', $department)
                ->orderBy('doctors.first_name', 'asc')
                ->get();
            }

        foreach ($doctors as $key => $list) {
            $schedule = DB::table('doctor_shift_relation')
                ->leftJoin('tbl_shift', 'doctor_shift_relation.shift_id', '=', 'tbl_shift.id')
                ->leftJoin('doctors', 'doctor_shift_relation.doctor_id', '=', 'doctors.id')
                ->where('doctors.id', $list->id)
                ->get();

            $doctors[$key]['schedule'] = $schedule;
        }

        $departments = Department::orderBy('name', 'asc')->get();
        $days = $this->days;

        return view('appointment.doctorlist', compact('doctors', 'keyword', 'departments', 'department', 'days'));
    }

    /* get appointment patient list */
    public function patientList($date) {
        $doctors = Appointment::groupBy('res_doc_id')->get();

        $patient_list = array();
        foreach ($doctors as $key => $doc) {
            $doc_id = $doc->res_doc_id;

            $list = Appointment::leftJoin('doctors', 'reservation.res_doc_id', '=', 'doctors.id')
                ->leftJoin('tbl_shift', 'reservation.res_shift_id', '=', 'tbl_shift.id')
                ->where('reservation.res_date', $date)
                ->where('reservation.res_doc_id', $doc_id)
                ->orderBy('tbl_shift.start_time', 'asc')
                ->get();

            foreach ($list as $lkey => $val) {
                $patient_list[$key][$lkey]['doctor'] = $val->first_name . ' ' . $val->middle_name . ' ' . $val->last_name;
                $patient_list[$key][$lkey]['patient'] = $val->patient_name;
                $patient_list[$key][$lkey]['start_time'] = $val->start_time;
                $patient_list[$key][$lkey]['end_time'] = $val->end_time;
                $patient_list[$key][$lkey]['status'] = $val->status;
            }
        }


        

        return view('appointment.appointmentlist', compact('patient_list', 'date'));
    }

}