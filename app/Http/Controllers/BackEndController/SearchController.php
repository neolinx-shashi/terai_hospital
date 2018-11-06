<?php

namespace App\Http\Controllers\BackEndController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboardSearch($id)
    {
        $search = $id;

        if (is_null($search)) {
            return view('backendview.dashboard.index');
        } else {
            $searchData = DB::table('patients')
                ->leftJoin('doctors', 'patients.doctor_id', '=', 'doctors.id')
                //->rightJoin('doctors', 'patients.doctorname_id', '=', 'doctors.id')
                ->select(
                    'patients.id as p_id',
                    'patients.first_name as p_fname',
                    'patients.middle_name as p_mname',
                    'patients.last_name as p_lname',
                    'patients.patient_code as p_code',
                    'patients.address as p_address',
                    'patients.phone as p_phone',
                    'patients.gender as p_gender',
                    'patients.age as p_age',
                    'patients.updated_at as p_updated_at',
                    'doctors.first_name as d_fname',
                    'doctors.middle_name as d_mname',
                    'doctors.last_name as d_lname',
                    'doctors.address as d_address',
                    'doctors.id as d_id'
                )
                ->where('patients.first_name', 'like', "%{$search}%")
                ->orWhere('patients.middle_name', 'like', "%{$search}%")
                ->orWhere('patients.last_name', 'like', "%{$search}%")
                ->orWhere('patients.address', 'like', "%{$search}%")
                ->orWhere('patients.phone', 'like', "%{$search}%")
                ->orWhere('patients.patient_code', 'like', "%{$search}%")
                ->orWhere('doctors.first_name', 'like', "%{$search}%")
                ->orWhere('doctors.middle_name', 'like', "%{$search}%")
                ->orWhere('doctors.last_name', 'like', "%{$search}%")
                //->groupBy('doctors.id')
                ->orderBy('patients.updated_at', 'DESC')
                ->get();

            /*$searchData = DB::table('patients')
                ->select(DB::raw('
                SELECT * FROM patients
                LEFT JOIN t2 ON t1.id = t2.id
                UNION
                SELECT * FROM t1
                RIGHT JOIN t2 ON t1.id = t2.id
                '))
                ->orderBy('patients.updated_at', 'desc')
                ->get();*/

            return view('backendview.dashboard.searchResult', compact('searchData'));
        }
    }
}
