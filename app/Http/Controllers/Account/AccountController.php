<?php

namespace App\Http\Controllers\Account;

use App\Models\DischargeInvoiceItem;
use App\Models\DoctorCharge;
use App\Models\IPatientHistory;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Billing;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\IPatient;
use App\Models\TestDetail;
use App\Models\Category;
use App\Models\User;
use DB;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->today = date("Y-m-d");
    }

    public function index()
    {
        //
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function billingReport()
    {
        $from = $this->today;
        $to = $this->today;


        $today = $this->today;
        $title = 'Daily Report';
        //$report = Billing::whereBetween('date', [$from, $to])->get();
        $report = DB::table('billing_detail')
            ->leftJoin('ipatient', 'billing_detail.patient_id', '=', 'ipatient.id')
            ->whereBetween('billing_detail.date', [$from, $to])
            ->get();

        $test_report = DB::table('test_detail')
            ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
            ->leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
            ->whereBetween('billing_detail.date', [$from, $to])
            ->get();

        $doctor_report = DB::table('billing_detail')
            ->leftJoin('patients', 'billing_detail.patient_id', '=', 'patients.id')
            ->leftJoin('doctors', 'patients.doctor_id', '=', 'doctors.id')
            ->selectRaw('sum(patients.doctor_fee) as total, doctors.first_name, doctors.middle_name, doctors.last_name')
            ->whereBetween('billing_detail.date', [$from, $to])
            ->groupBy('doctors.id')
            ->orderBy('doctors.first_name', 'asc')
            ->get();
        //dd($doctor_report);

        return view('account.billing_report', compact('report', 'test_report', 'doctor_report', 'today'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function monthlyReport()
    {
        $month = date("m");
        $today = $this->today;
        $title = 'Monthly Report';

        $report = DB::table('billing_detail')
            ->leftJoin('ipatient', 'billing_detail.patient_id', '=', 'ipatient.id')
            ->where('billing_detail.date', 'like', '%-' . $month . '-%')
            ->get();

        $test_report = DB::table('test_detail')
            ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
            ->leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
            ->where('billing_detail.date', 'like', '%-' . $month . '-%')
            ->get();

        $doctor_report = DB::table('billing_detail')
            ->leftJoin('patients', 'billing_detail.patient_id', '=', 'patients.id')
            ->leftJoin('doctors', 'patients.doctor_id', '=', 'doctors.id')
            ->selectRaw('sum(patients.doctor_fee) as total, doctors.first_name, doctors.middle_name, doctors.last_name')
            ->where('billing_detail.date', 'like', '%-' . $month . '-%')
            ->groupBy('doctors.id')
            ->orderBy('doctors.first_name', 'asc')
            ->get();


        return view('account.billing_report', compact('report', 'test_report', 'doctor_report', 'today'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function yearlyReport()
    {
        $year = date("Y");
        $today = $this->today;
        $title = 'Yearly Report';

        $report = DB::table('billing_detail')->leftJoin('ipatient', 'billing_detail.patient_id', '=', 'ipatient.id')->where('billing_detail.date', 'like', '%' . $year . '-%')->get();

        $test_report = DB::table('test_detail')
            ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
            ->leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
            ->where('billing_detail.date', 'like', '%' . $year . '-%')
            ->get();

        $doctor_report = DB::table('billing_detail')
            ->leftJoin('patients', 'billing_detail.patient_id', '=', 'patients.id')
            ->leftJoin('doctors', 'patients.doctor_id', '=', 'doctors.id')
            ->selectRaw('sum(patients.doctor_fee) as total, doctors.first_name, doctors.middle_name, doctors.last_name')
            ->where('billing_detail.date', 'like', '%' . $year . '-%')
            ->groupBy('doctors.id')
            ->orderBy('doctors.first_name', 'asc')
            ->get();


        return view('account.billing_report', compact('report', 'test_report', 'doctor_report', 'today'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dateReport(Request $request)
    {
        $input = $request->all();

        $fromToday = $input['date_from'];
        $todayDate = $fromToday;
        $localDate = str_replace("/", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $from = nep_to_eng($a, $b, $c);


        $toDate = $input['date_to'];
        $todayDateOnly = $toDate;
        $localDateToday = str_replace("/", "-", $todayDateOnly);
        $classesTo = explode("-", $localDateToday);
        $a = sprintf('%02d', $classesTo[0]);
        $b = sprintf('%02d', $classesTo[1]);
        $c = sprintf('%02d', $classesTo[2]);
        $to = nep_to_eng($a, $b, $c);

        $today = $this->today;
        $title = 'Report';
        //$report = Billing::whereBetween('date', [$from, $to])->get();
        $report = DB::table('billing_detail')
            ->leftJoin('ipatient', 'billing_detail.patient_id', '=', 'ipatient.id')
            ->whereBetween('billing_detail.date', [$from, $to])
            ->get();

        $test_report = DB::table('test_detail')
            ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
            ->leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
            ->whereBetween('billing_detail.date', [$from, $to])
            ->get();

        $doctor_report = DB::table('billing_detail')
            ->leftJoin('patients', 'billing_detail.patient_id', '=', 'patients.id')
            ->leftJoin('doctors', 'patients.doctor_id', '=', 'doctors.id')
            ->selectRaw('sum(patients.doctor_fee) as total, doctors.first_name, doctors.middle_name, doctors.last_name')
            ->whereBetween('billing_detail.date', [$from, $to])
            ->groupBy('doctors.id')
            ->orderBy('doctors.first_name', 'asc')
            ->get();

        return view('account.billing_report', compact('report', 'test_report', 'doctor_report', 'today'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function doctorReport(Request $request)
    {
        $doctors = Doctor::orderBy('first_name', 'asc')->get();

        foreach ($doctors as $key => $list) {
            $patients = IPatient::where('doctor_id', $list->id)
                ->select('id', 'first_name', 'middle_name', 'last_name', 'gender', 'doctor_fee', 'doctor_fee_with_tax', 'appointment')
                ->where('patient_type', 'OPD')
                ->get();
            $doctors[$key]['patients'] = $patients;

            $tests = DB::table('test_detail')
                ->leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                ->where('billing_detail.doctor_id', $list->id)
                ->get();

            $doctors[$key]['tests'] = $tests;
        }
        $consulting = 0;
        return view('account.doctor_report', compact('doctors', 'consulting'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function operateDoctorReport(Request $request)
    {
        $doctors = Doctor::orderBy('first_name', 'asc')->get();
        $test_cat = $request->get('test_cat');

        $doctor = $request->get('doctor_list');
        $dateNepali = $request->get('date');
        $dateToNepali = $request->get('dateto');

        /* check if doctor department is ultrasound (id of ultrasound = 17 in department table) */
        $department = Doctor::find($doctor);
        $doctor_name = $department->first_name . ' ' . $department->middle_name . ' ' . $department->last_name;
        $dept_id = $department->department_id;
        if ($dept_id == 17) {
            $consulting = 1;
        } else {
            $consulting = 0;
        }

        $todayDate = $dateNepali;
        /* date from nep to eng */
        $localDate = str_replace("/", "-", $todayDate);
        $classes = explode("-", $localDate);

        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $date = nep_to_eng($a, $b, $c);

        /* date to nep to eng */
        $localDateTo = str_replace("/", "-", $dateToNepali);
        $classes = explode("-", $localDateTo);

        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $date_to = nep_to_eng($a, $b, $c);

        /**/
        if ($dateNepali >= "2074-07-21" && $dateToNepali >= "2074-07-21") {
            $class = '';
        } else {
            $class = 'ninja';
        }

        //echo $timestamp = date("Y-m-d H:i:s", strtotime($date));die;
        $timestamp_from = $date . " 00:00:00";
        $timestamp_to = $date_to . " 23:59:59";
        $patients = IPatient::where('doctor_id', $doctor)
            ->where('created_at', '>=', $timestamp_from)
            ->where('created_at', '<=', $timestamp_to)
            ->where('patient_type', 'OPD')
            ->where('refund_status', 'Active')
            ->select('first_name', 'middle_name', 'last_name', 'doctor_fee', 'patient_code', 'doctor_tax_only', 'doctor_fee_with_tax', 'bill_number')
            ->get();

        /* IPD */
        $patients_ipd = IPatient::where('doctor_id', $doctor)
            ->where('created_at', '>=', $timestamp_from)
            ->where('created_at', '<=', $timestamp_to)
            ->where('patient_type', 'IPD')
            ->where('refund_status', 'Active')
            ->select('first_name', 'middle_name', 'last_name', 'doctor_fee', 'patient_code', 'doctor_tax_only', 'doctor_fee_with_tax', 'bill_number', 'admission_charge', 'admission_charge_hst', 'admission_charge_with_tax')
            ->get();

        /*IPD Doctor Round Charge*/
        $round_charge_type = DB::table('doctor_charges')
            ->select('id', 'title')
            ->get();

        $ipd_round_charge = array();
        foreach ($round_charge_type as $key => $charge) {
            $round_charge = DB::table('ipatient')
                ->leftJoin('i_patient_histories', 'ipatient.id', '=', 'i_patient_histories.ipatient_id')
                ->leftJoin('discharge_details', 'ipatient.id', '=', 'discharge_details.ipatient_id')
                ->select('ipatient.first_name', 'ipatient.status', 'ipatient.patient_type', 'ipatient.patient_code', 'i_patient_histories.*', 'discharge_details.bill_number', 'discharge_details.created_at')
                ->where('ipatient.patient_type', 'IPD')
                ->where('ipatient.status', 'Discharged')
                ->where('i_patient_histories.charge_id', $charge->id)
                ->where('i_patient_histories.doctor_id', $doctor)
                ->where('discharge_details.created_at', '>=', $timestamp_from)
                ->where('discharge_details.created_at', '<=', $timestamp_to)
                ->get();
            $round_charge->charge_title = $charge->title;

            foreach ($round_charge as $patient) {
                $doctor_fee = $patient->doctor_fee;
                $hst = 5 / 100 * $doctor_fee;
                $doctor_fee_with_tax = $doctor_fee + $hst;
                $patient->hst = $hst;
                $patient->doctor_fee_with_tax = $doctor_fee_with_tax;
            }
            $ipd_round_charge[$key] = $round_charge;
        }

        /* Pathology */
        $pathology_sub = Category::where('parent_id', 1)
            ->where('level', 2)
            ->orderBy('title', 'asc')
            ->get();
        $sub_id = array();
        foreach ($pathology_sub as $sub) {
            $sub_id[] = $sub->id;
        }
        $subId = implode(',', $sub_id);
        $pathology_sub_arr = array();
        $check_dupliate = array();

        foreach ($pathology_sub as $key => $ps) {
            $sid = $ps->id;
            if ($class == 'ninja') {
                $pathology_test = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                    ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                    ->where('categories.level', '3')
                    ->where('categories.parent_id', $sid)
                    ->where('categories.status', 'Active')
                    ->where('billing_detail.doctor_id', $doctor)
                    ->where('billing_detail.date', '>=', $date)
                    ->where('billing_detail.date', '<=', $date_to)
                    ->where('billing_detail.status', 'Active')
                    ->groupBy('billing_detail.patient_id')
                    ->get();
            } else {
                $pathology_test = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                    ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                    ->where('categories.level', '3')
                    ->where('categories.parent_id', $sid)
                    ->where('categories.status', 'Active')
                    ->where('billing_detail.doctor_id', $doctor)
                    ->where('billing_detail.date', '>=', $date)
                    ->where('billing_detail.date', '<=', $date_to)
                    ->where('billing_detail.status', 'Active')
                    ->groupBy('billing_detail.bill_number')
                    ->get();
            }

            foreach ($pathology_test as $akey => $val) {
                $pid = $val->patient_id;
                $patient_name = IPatient::where('id', $pid)->select('first_name', 'middle_name', 'last_name')->get();
                $pat_name = @$patient_name[0]->first_name . ' ' . @$patient_name[0]->middle_name . ' ' . @$patient_name[0]->last_name;
                $pname = strtoupper($pat_name);

                $pathology_test[$akey]->patient_name = $pname;
                $pathology_test[$akey]->patient_id = $pid;

                $detail = IPatient::where('id', $pid)->select('patient_code')->get();
                $pathology_test[$akey]->patient_code = $detail[0]->patient_code;
            }

            if (!empty($pathology_test)) {
                foreach ($pathology_test as $pkey => $pt) {
                    if ($class == 'ninja')
                        $check_var = $pt->patient_id;
                    else
                        $check_var = $pt->bill_number;
                    if (!in_array($check_var, $check_dupliate)) {
                        if ($class == 'ninja')
                            $check_dupliate[] = $pt->patient_id;
                        else
                            $check_dupliate[] = $pt->bill_number;

                        //$total_fee = Billing::where('patient_id', $pt->patient_id)->where('status', 'Active')->where('date', '>=', $date)->where('date', '<=', $date_to)->sum('sub_total');

                        if ($class == 'ninja') {

                            $total_fee = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')->select('categories.title')->whereIn('categories.parent_id', $sub_id)->where('billing_detail.status', 'Active')->where('billing_detail.patient_id', $pt->patient_id)->where('categories.level', 3)->where('billing_detail.date', '>=', $date)->where('billing_detail.date', '<=', $date_to)->sum('test_detail.test_price');

                            $tax = $total_fee * 5 / 100;
                            $grand_total = $total_fee + $tax;

                            $test_list = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')->select('categories.title')->whereIn('categories.parent_id', $sub_id)->where('billing_detail.status', 'Active')->where('billing_detail.patient_id', $pt->patient_id)->where('categories.level', 3)->where('billing_detail.date', '>=', $date)->where('billing_detail.date', '<=', $date_to)->get();
                        } else {
                            $total_fee = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')->select('categories.title')->whereIn('categories.parent_id', $sub_id)->where('billing_detail.status', 'Active')->where('billing_detail.bill_number', $pt->bill_number)->where('categories.level', 3)->where('billing_detail.date', '>=', $date)->where('billing_detail.date', '<=', $date_to)->sum('test_detail.test_price');

                            $tax = $total_fee * 5 / 100;
                            $grand_total = $total_fee + $tax;

                            $test_list = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')->select('categories.title')->whereIn('categories.parent_id', $sub_id)->where('billing_detail.status', 'Active')->where('billing_detail.bill_number', $pt->bill_number)->where('categories.level', 3)->where('billing_detail.date', '>=', $date)->where('billing_detail.date', '<=', $date_to)->get();
                        }

                        $test_names = '';
                        foreach ($test_list as $tkey => $tlist) {
                            $test_names .= $tlist->title . ', ';
                        }
                        $test_names = rtrim($test_names, ', ');
                        $test_names_arr = explode(', ', $test_names);
                        $test_names_arr = array_unique($test_names_arr);
                        $test_names = implode(', ', $test_names_arr);

                        $pathology_sub_arr[$key][$pkey]['name'] = $pt->patient_name;
                        $pathology_sub_arr[$key][$pkey]['fee'] = sprintf('%.02f', $total_fee);
                        $pathology_sub_arr[$key][$pkey]['test'] = $test_names;
                        $pathology_sub_arr[$key][$pkey]['referal_doctor'] = '';
                        $pathology_sub_arr[$key][$pkey]['patient_code'] = $pt->patient_code;
                        $pathology_sub_arr[$key][$pkey]['tax'] = sprintf('%.02f', $tax);
                        $pathology_sub_arr[$key][$pkey]['grand_total'] = sprintf('%.02f', $grand_total);
                        $pathology_sub_arr[$key][$pkey]['bill_number'] = $pt->bill_number;
                    }
                }
            }
        }

        /* report by subcategory */
        $test_subcat = Category::where('level', '2')
            ->where('parent_id', '<>', 1)
            //->where('status', 'Active')
            ->orderBy('title', 'asc')
            ->get();
        $test_res = array();
        foreach ($test_subcat as $key => $subcat) {
            $sid = $subcat->id;
            $stitle = $subcat->title;
            if ($consulting == 0) {
                $cs = 8;
                $test = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                    ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                    ->where('categories.level', '3')
                    ->where('categories.parent_id', $sid)
                    //->where('categories.status', 'Active')
                    ->where('billing_detail.doctor_id', $doctor)
                    ->where('billing_detail.status', 'Active')
                    ->where('billing_detail.date', '>=', $date)
                    ->where('billing_detail.date', '<=', $date_to)
                    ->get();
            } else if ($consulting == 1) {
                $cs = 8;
                $test = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                    ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                    ->leftJoin('doctors', 'billing_detail.doctor_id', '=', 'doctors.id')
                    ->where('categories.level', '3')
                    ->where('categories.parent_id', $sid)
                    //->where('categories.status', 'Active')
                    ->where('billing_detail.consulting_doctor_id', $doctor)
                    ->where('billing_detail.status', 'Active')
                    ->where('billing_detail.date', '>=', $date)
                    ->where('billing_detail.date', '<=', $date_to)
                    ->get();
            }
            foreach ($test as $key => $val) {
                $pid = $val->patient_id;
                $patient_name = IPatient::where('id', $pid)->select('first_name', 'middle_name', 'last_name')->get();
                $pname = @$patient_name[0]->first_name . ' ' . @$patient_name[0]->middle_name . ' ' . @$patient_name[0]->last_name;

                $test[$key]->patient_name = $pname;

                $detail = IPatient::where('id', $pid)->select('patient_code')->get();
                $test[$key]->key = $detail[0]->patient_code;
            }

            if (!empty($test)) {
                foreach ($test as $tkey => $tst) {
                    $tax = $tst->test_price * 5 / 100;
                    $grand_total = round($tax, 2) + $tst->test_price;
                    $test_res[$stitle][$tkey]['name'] = @$tst->patient_name;
                    $test_res[$stitle][$tkey]['fee'] = $tst->test_price;
                    $test_res[$stitle][$tkey]['tax'] = round($tax, 2);
                    $test_res[$stitle][$tkey]['grand_total'] = $grand_total;
                    $test_res[$stitle][$tkey]['test'] = $tst->title;
                    $test_res[$stitle][$tkey]['patient_code'] = $tst->key;
                    //$detail[0]->patient_code;
                    $test_res[$stitle][$tkey]['bill_number'] = $tst->bill_number;
                    if ($consulting == 0)
                        $test_res[$stitle][$tkey]['referal_doctor'] = '';
                    else
                        $test_res[$stitle][$tkey]['referal_doctor'] = $tst->first_name . ' ' . $tst->middle_name . ' ' . $tst->last_name;
                }
            }
        }

        /*IPD bed charge report*/
        $rooms = Room::all();

        foreach ($rooms as $room) {
            $j = 0;
            $roomId = $room->id;

            $discharge_details = DB::table('discharge_details')
                ->leftJoin('ipatient', 'discharge_details.ipatient_id', 'ipatient.id')
                ->leftJoin('doctors', 'ipatient.doctor_id', 'doctors.id')
                ->select('discharge_details.room_id', 'discharge_details.room_charge', 'discharge_details.bill_number', 'ipatient.first_name as patient_name', 'ipatient.patient_code', 'doctors.first_name', 'doctors.middle_name', 'doctors.last_name')
                ->where('ipatient.doctor_id', $doctor)
                ->whereDate('discharge_details.created_at', '>=', $date)
                ->whereDate('discharge_details.created_at', '<=', $date_to)
                ->get();

            foreach ($discharge_details as $key => $detail) {
                $room_id_arr = explode('-', $detail->room_id);
                $room_charge_arr = explode('-', $detail->room_charge);
                $count = count($room_id_arr);

                if ($detail->room_id != "" && $count == count($room_charge_arr)) {
                    for ($i = 0; $i < $count; $i++) {
                        $room_id = $room_id_arr[$i];
                        if ($room_id == $roomId) {
                            $room_charge = $room_charge_arr[$i];
                            $tax = 5 / 100 * $room_charge;
                            $grand_total = $room_charge + $tax;
                            $room = Room::findOrFail($room_id);
                            $room_name = $room->room_name;
                            $doctor_name = $detail->first_name . ' ' . $detail->middle_name . ' ' . $detail->last_name;
                            $bed_charge_detail[$room_name][$j++] = array(
                                'patient_name' => $detail->patient_name,
                                'patient_code' => $detail->patient_code,
                                'doctor_name' => $doctor_name,
                                'room_name' => $room_name,
                                'room_charge' => $room_charge,
                                'tax' => $tax,
                                'grand_total' => $grand_total,
                                'bill_number' => $detail->bill_number,
                            );
                        }
                    }
                }
            }
        }
        //dd($bed_charge_detail);

        /*IPD test report by subcategorycategory*/
        $test_subcategory = Category::where('level', '2')
            ->where('parent_id', '<>', 1)
            //->where('status', 'Active')
            ->orderBy('title', 'asc')
            ->get();

        $ipd_test = array();
        foreach ($test_subcategory as $key => $subcat) {
            $sid = $subcat->id;
            $stitle = $subcat->title;
            $test = DischargeInvoiceItem::leftJoin('discharge_details', 'discharge_invoice_items.discharge_id', '=', 'discharge_details.id')
                ->leftJoin('ipatient', 'discharge_details.ipatient_id', 'ipatient.id')
                ->leftJoin('categories', 'discharge_invoice_items.test_id', '=', 'categories.id')
                ->select('discharge_details.created_at as discharge_date', 'discharge_details.*', 'discharge_invoice_items.*', 'categories.*', 'ipatient.doctor_id')
                ->where('ipatient.doctor_id', $doctor)
                ->where('categories.level', '3')
                ->where('categories.parent_id', $sid)
                ->whereDate('discharge_details.created_at', '>=', $date)
                ->whereDate('discharge_details.created_at', '<=', $date_to)
                ->get();

            foreach ($test as $key => $val) {
                $pid = $val->ipatient_id;
                $patient_name = IPatient::where('id', $pid)->select('first_name', 'middle_name', 'last_name')->get();
                $pname = @$patient_name[0]->first_name . ' ' . @$patient_name[0]->middle_name . ' ' . @$patient_name[0]->last_name;
                $test[$key]->patient_name = $pname;

                $detail = IPatient::where('id', $pid)->select('patient_code')->first();
                $test[$key]->patient_code = $detail->patient_code;
            }
            if (!empty($test)) {
                foreach ($test as $tkey => $tst) {
                    $tax = $tst->test_price * 5 / 100;
                    $grand_total = round($tax, 2) + $tst->test_price;
                    $ipd_test[$stitle][$tkey]['name'] = @$tst->patient_name;
                    $ipd_test[$stitle][$tkey]['fee'] = $tst->test_price;
                    $ipd_test[$stitle][$tkey]['tax'] = round($tax, 2);
                    $ipd_test[$stitle][$tkey]['grand_total'] = $grand_total;
                    $ipd_test[$stitle][$tkey]['test'] = $tst->title;
                    $ipd_test[$stitle][$tkey]['patient_code'] = $tst->patient_code;
                    $ipd_test[$stitle][$tkey]['bill_number'] = $tst->bill_number;
                }
            }
        }
        //dd($ipd_test);

        /*IPD Pathology test report*/
        $test_pathology = Category::where('parent_id', 1)
            ->where('level', 2)
            ->orderBy('title', 'asc')
            ->get();

        $ipd_test_path = array();
        foreach ($test_pathology as $pkey => $subcat) {
            $sid = $subcat->id;
            $stitle = $subcat->title;
            $test = DischargeInvoiceItem::leftJoin('discharge_details', 'discharge_invoice_items.discharge_id', '=', 'discharge_details.id')
                ->leftJoin('ipatient', 'discharge_details.ipatient_id', 'ipatient.id')
                ->leftJoin('categories', 'discharge_invoice_items.test_id', '=', 'categories.id')
                ->select('discharge_details.created_at as discharge_date', 'discharge_details.*', 'discharge_invoice_items.*', 'categories.*', 'ipatient.doctor_id')
                ->where('ipatient.doctor_id', $doctor)
                ->where('categories.level', '3')
                ->where('categories.parent_id', $sid)
                ->whereDate('discharge_details.created_at', '>=', $date)
                ->whereDate('discharge_details.created_at', '<=', $date_to)
                ->get();

            foreach ($test as $key => $val) {
                $pid = $val->ipatient_id;
                $patient_name = IPatient::where('id', $pid)->select('first_name', 'middle_name', 'last_name')->get();
                $pname = @$patient_name[0]->first_name . ' ' . @$patient_name[0]->middle_name . ' ' . @$patient_name[0]->last_name;
                $test[$key]->patient_name = $pname;

                $detail = IPatient::where('id', $pid)->select('patient_code')->first();
                $test[$key]->patient_code = $detail->patient_code;
            }
            if (!empty($test)) {
                foreach ($test as $tkey => $tst) {
                    $tax = $tst->test_price * 5 / 100;
                    $grand_total = round($tax, 2) + $tst->test_price;
                    $ipd_test_path[$pkey][$tkey]['name'] = @$tst->patient_name;
                    $ipd_test_path[$pkey][$tkey]['fee'] = $tst->test_price;
                    $ipd_test_path[$pkey][$tkey]['tax'] = round($tax, 2);
                    $ipd_test_path[$pkey][$tkey]['grand_total'] = $grand_total;
                    $ipd_test_path[$pkey][$tkey]['test'] = $tst->title;
                    $ipd_test_path[$pkey][$tkey]['patient_code'] = $tst->patient_code;
                    $ipd_test_path[$pkey][$tkey]['bill_number'] = $tst->bill_number;
                }
            }
        }
        //dd($ipd_test_path);

        return view('account.doctor_report', compact('doctor',
            'date',
            'patients',
            'patients_ipd',
            'test',
            'doctors',
            'dateNepali',
            'dateToNepali',
            'consulting',
            'test_res',
            'pathology_sub_arr',
            'cs',
            'class',
            'doctor_name',
            'ipd_round_charge',
            'bed_charge_detail',
            'ipd_test',
            'ipd_test_path'
        ));
    }


    /* Pathology Report */
    public
    function pathologyReport()
    {
        return view('account.pathology_report');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function operatePathologyReport(Request $request)
    {
        $date_from = $request->get('datefrom');
        $date_to = $request->get('dateto');

        /* convert nepali date to english */
        $localDate = str_replace("/", "-", $date_from);
        $classes = explode("-", $localDate);

        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $dateFrom = nep_to_eng($a, $b, $c);

        $localDate = str_replace("/", "-", $date_to);
        $classes = explode("-", $localDate);

        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $dateTo = nep_to_eng($a, $b, $c);


        /* get subcategory id of pathology */
        $subcat = Category::where('parent_id', 1)->where('level', 2)->where('status', 'Active')->select('id')->get();
        $subcat_id_arr = array();

        foreach ($subcat as $sub) {
            $subcat_id_arr[] = $sub->id;
        }

        /* get test of subcategories of pathology */
        $tests = Category::where('level', 3)->where('status', 'Active')->whereIn('parent_id', $subcat_id_arr)->select('id')->get();
        $tests_arr = array();

        foreach ($tests as $tst) {
            $test_arr[] = $tst->id;
        }

        /* get report of the tests */
        $report = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
            ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
            ->leftJoin('doctors', 'billing_detail.doctor_id', '=', 'doctors.id')
            ->whereIn('categories.id', $test_arr)
            ->where('billing_detail.date', '>=', $dateFrom)
            ->where('billing_detail.date', '<=', $dateTo)
            ->where('billing_detail.status', 'Active')
            ->orderBy('billing_detail.date', 'asc')
            //->groupBy('billing_detail.date')
            //->groupBy('billing_detail.patient_id')
            ->get();

        foreach ($report as $k => $val) {
            $date_en = $val->date;
            $date_arr = explode('-', $date_en);
            $date_np = eng_to_nep($date_arr[0], $date_arr[1], $date_arr[2]);
            $report[$k]->date_nep = $date_np;

            /* get patient name */
            $pid = $val->patient_id;
            $patient_name = IPatient::where('id', $pid)->select('first_name', 'middle_name', 'last_name')->get();
            @$pat_name = $patient_name[0]->first_name . ' ' . $patient_name[0]->middle_name . ' ' . $patient_name[0]->last_name;
            $pname = strtoupper($pat_name);

            $report[$k]->patient_name = $pname;
        }

        return view('account.pathology_report_old', compact('report', 'date_from', 'date_to'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function operatePathologyReportByBillNumber(Request $request)
    {
        $date_from = $request->get('datefrom');
        $date_to = $request->get('dateto');

        /* convert nepali date to english */
        $localDate = str_replace("/", "-", $date_from);
        $classes = explode("-", $localDate);

        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $dateFrom = nep_to_eng($a, $b, $c);

        $localDate = str_replace("/", "-", $date_to);
        $classes = explode("-", $localDate);

        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $dateTo = nep_to_eng($a, $b, $c);


        /* check date for report type */
        if ($date_from < "2074-07-21" && $date_to < "2074-07-21") {
            /* get subcategory id of pathology */
            $subcat = Category::where('parent_id', 1)->where('level', 2)->where('status', 'Active')->select('id')->get();
            $subcat_id_arr = array();

            foreach ($subcat as $sub) {
                $subcat_id_arr[] = $sub->id;
            }

            /* get test of subcategories of pathology */
            $tests = Category::where('level', 3)->where('status', 'Active')->whereIn('parent_id', $subcat_id_arr)->select('id')->get();
            $tests_arr = array();

            foreach ($tests as $tst) {
                $test_arr[] = $tst->id;
            }

            /* get report of the tests */
            $report = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                ->leftJoin('doctors', 'billing_detail.doctor_id', '=', 'doctors.id')
                ->whereIn('categories.id', $test_arr)
                ->where('billing_detail.date', '>=', $dateFrom)
                ->where('billing_detail.date', '<=', $dateTo)
                ->where('billing_detail.status', 'Active')
                ->orderBy('billing_detail.date', 'asc')
                //->groupBy('billing_detail.date')
                //->groupBy('billing_detail.patient_id')
                ->get();

            foreach ($report as $k => $val) {
                $date_en = $val->date;
                $date_arr = explode('-', $date_en);
                $date_np = eng_to_nep($date_arr[0], $date_arr[1], $date_arr[2]);
                $report[$k]->date_nep = $date_np;

                /*insert hst and grand total*/
                $test_price = $report[$k]->test_price;
                $hst = $test_price * 5 / 100;
                $gtotal = $test_price + $hst;
                $report[$k]->hst = $hst;
                $report[$k]->gtotal = $gtotal;

                /* get patient name */
                $pid = $val->patient_id;
                $patient_name = IPatient::where('id', $pid)->select('first_name', 'middle_name', 'last_name')->get();
                @$pat_name = $patient_name[0]->first_name . ' ' . $patient_name[0]->middle_name . ' ' . $patient_name[0]->last_name;
                $pname = strtoupper($pat_name);

                $report[$k]->patient_name = $pname;
            }

            //var_dump($report);die;
            return view('account.pathology_report_old', compact('report', 'date_from', 'date_to'));
        } else if ($date_from >= "2074-07-21" && $date_to >= "2074-07-21") {
            /* report list */
            $subcat = Category::where('parent_id', 1)->get();
            $parent_id = array();
            foreach ($subcat as $key => $val) {
                $parent_id[] = $val->id;
            }

            $test = Category::whereIn('parent_id', $parent_id)->where('level', 3)->get();
            $pathology = array();
            foreach ($test as $pat) {
                $pathology[] = $pat->id;
            }

            /* report */
            $report = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                ->leftJoin('doctors', 'billing_detail.doctor_id', '=', 'doctors.id')
                ->whereIn('categories.id', $pathology)
                ->where('billing_detail.date', '>=', $dateFrom)
                ->where('billing_detail.status', 'Active')
                ->where('billing_detail.date', '<=', $dateTo)
                ->groupBy('billing_detail.bill_number')
                ->orderBy('billing_detail.date', 'asc')
                ->get();

            foreach ($report as $key => $val) {
                /* patient name */
                $pid = $val->patient_id;
                $patient_name = IPatient::where('id', $pid)->select('first_name', 'middle_name', 'last_name')->get();
                @$pat_name = $patient_name[0]->first_name . ' ' . $patient_name[0]->middle_name . ' ' . $patient_name[0]->last_name;
                $pname = strtoupper($pat_name);

                $report[$key]->patient_name = $pname;

                /* convert eng date to nep */
                $date_en = $val->date;
                $date_arr = explode('-', $date_en);
                $date_np = eng_to_nep($date_arr[0], $date_arr[1], $date_arr[2]);
                $report[$key]->date_nep = $date_np;

                /* total fee */
                $total_fee = 0;
                $bill_number = $val->bill_number;
                $total_fee = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                    ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                    ->whereIn('categories.id', $pathology)
                    ->where('billing_detail.bill_number', $bill_number)
                    ->sum('test_detail.test_price');

                $report[$key]->total_fee = number_format($total_fee, 2, '.', '');;

                /* test list */
                $test_list = '';
                $list = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                    ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                    ->whereIn('categories.id', $pathology)
                    ->where('billing_detail.bill_number', $bill_number)
                    ->select('categories.title')
                    ->get();

                foreach ($list as $res) {
                    $test_list .= $res->title . ', ';
                }
                $report[$key]->test_list = rtrim($test_list, ', ');
            }

            return view('account.pathology_report_bill', compact('report', 'date_from', 'date_to'));
        } else {
            return view('account.pathology_report_bill', compact('date_from', 'date_to'));
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function operatePathologyReport__(Request $request)
    {
        $date_from = $request->get('datefrom');
        $date_to = $request->get('dateto');

        /* convert nepali date to english */
        $localDate = str_replace("/", "-", $date_from);
        $classes = explode("-", $localDate);

        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $dateFrom = nep_to_eng($a, $b, $c);

        $localDate = str_replace("/", "-", $date_to);
        $classes = explode("-", $localDate);

        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $dateTo = nep_to_eng($a, $b, $c);

        /* report list */
        $subcat = Category::where('parent_id', 1)->get();
        $parent_id = array();
        foreach ($subcat as $key => $val) {
            $parent_id[] = $val->id;
        }
        $pid = implode(',', $parent_id);

        $test = Category::whereIn('parent_id', [$pid])->where('level', 3)->get();
        $pathology = array();
        foreach ($test as $pat) {
            $pathology[] = $pat->id;
        }
        $tid = implode(',', $pathology);

        $repo = array();
        for ($i = 0; $i < count($pathology); $i++) {
            $report = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                ->leftJoin('doctors', 'billing_detail.doctor_id', '=', 'doctors.id')
                ->where('categories.id', '=', $pathology[$i])
                ->where('billing_detail.date', '>=', $dateFrom)
                ->where('billing_detail.date', '<=', $dateTo)
                ->orderBy('billing_detail.date', 'asc')
                ->get();

            foreach ($report as $key => $val) {
                $pid = $val->patient_id;
                $patient_name = IPatient::where('id', $pid)->select('first_name', 'middle_name', 'last_name')->get();
                @$pname = $patient_name[0]->first_name . ' ' . $patient_name[0]->middle_name . ' ' . $patient_name[0]->last_name;

                $report[$key]->patient_name = $pname;

                /* convert eng date to nep */
                $date_en = $val->date;
                $date_arr = explode('-', $date_en);
                $date_np = eng_to_nep($date_arr[0], $date_arr[1], $date_arr[2]);
                $report[$key]->nep_date = $date_np;
            }
            $repo[] = $report;
        }
        $cnt = count($repo);

        return view('account.pathology_report', compact('report', 'date_from', 'date_to', 'repo', 'cnt'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function generalReport()
    {
        $category = Category::where('level', '1')->where('status', 'Active')->orderBy('title')->get();
        $cat = 0;

        return view('account.general_report_chooser', compact('category', 'cat'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function operateGeneralReport(Request $request)
    {
        $category = Category::where('level', '1')
            ->where('status', 'Active')
            ->orderBy('title')
            ->get();

        $date_from = $request->get('datefrom');
        $date_to = $request->get('dateto');
        $cat = $request->get('category');

        /* convert nepali date to english */
        $localDate = str_replace("/", "-", $date_from);
        $classes = explode("-", $localDate);

        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $dateFrom = nep_to_eng($a, $b, $c);

        $localDate = str_replace("/", "-", $date_to);
        $classes = explode("-", $localDate);

        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $dateTo = nep_to_eng($a, $b, $c);

        /* get title */
        $cat_title = Category::findOrFail($cat);
        $title = $cat_title->title;

        if ($date_from < "2074-07-21" && $date_to < "2074-07-21") {
            /* get subcategory id of pathology */
            $subcat = Category::where('parent_id', $cat)
                ->where('level', 2)
                //->where('status', 'Active')
                ->select('id')
                ->get();
            $subcat_id_arr = array();

            foreach ($subcat as $sub) {
                $subcat_id_arr[] = $sub->id;
            }

            /* get test of subcategories of pathology */
            $tests = Category::where('level', 3)
                //->where('status', 'Active')
                ->whereIn('parent_id', $subcat_id_arr)
                ->select('id')
                ->get();
            $tests_arr = array();

            foreach ($tests as $tst) {
                $test_arr[] = $tst->id;
            }

            /* get report of the tests */
            $report = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                ->leftJoin('doctors', 'billing_detail.doctor_id', '=', 'doctors.id')
                ->whereIn('categories.id', $test_arr)
                ->where('billing_detail.date', '>=', $dateFrom)
                ->where('billing_detail.date', '<=', $dateTo)
                ->where('billing_detail.status', 'Active')
                ->orderBy('billing_detail.date', 'asc')
                ->get();

            foreach ($report as $k => $val) {
                $date_en = $val->date;
                $date_arr = explode('-', $date_en);
                $date_np = eng_to_nep($date_arr[0], $date_arr[1], $date_arr[2]);
                $report[$k]->date_nep = $date_np;

                /*insert hst and grand total*/
                $test_price = $report[$k]->test_price;
                $hst = $test_price * 5 / 100;
                $gtotal = $test_price + $hst;
                $report[$k]->hst = $hst;
                $report[$k]->gtotal = $gtotal;

                /* get patient name */
                $pid = $val->patient_id;
                $patient_name = IPatient::where('id', $pid)->select('first_name', 'middle_name', 'last_name', 'patient_code')->get();
                @$pname = $patient_name[0]->first_name . ' ' . $patient_name[0]->middle_name . ' ' . $patient_name[0]->last_name;
                $pcode = $patient_name[0]->patient_code;

                $report[$k]->patient_name = $pname;
                $report[$k]->patient_code = $pcode;
            }

            return view('account.general_report_old', compact('report', 'date_from', 'date_to', 'category', 'cat', 'title'));
        } else if ($date_from >= "2074-07-21" && $date_to >= "2074-07-21") {
            /* report list */
            $subcat = Category::where('parent_id', $cat)->where('level', 2)->get();
            $parent_id = array();
            foreach ($subcat as $key => $val) {
                $parent_id[] = $val->id;
            }

            $test = Category::whereIn('parent_id', $parent_id)->where('level', 3)->get();
            $pathology = array();
            foreach ($test as $pat) {
                $pathology[] = $pat->id;
            }

            /* report */
            $report = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                ->leftJoin('doctors', 'billing_detail.doctor_id', '=', 'doctors.id')
                ->whereIn('categories.id', $pathology)
                ->where('billing_detail.date', '>=', $dateFrom)
                ->where('billing_detail.date', '<=', $dateTo)
                ->where('billing_detail.status', '=', 'Active')
                ->groupBy('billing_detail.bill_number')
                ->orderBy('billing_detail.date', 'asc')
                ->get();

            foreach ($report as $key => $val) {
                /* patient name */
                $pid = $val->patient_id;
                $patient_name = IPatient::where('id', $pid)->select('first_name', 'middle_name', 'last_name')->get();
                @$pname = $patient_name[0]->first_name . ' ' . $patient_name[0]->middle_name . ' ' . $patient_name[0]->last_name;

                $report[$key]->patient_name = $pname;

                /* convert eng date to nep */
                $date_en = $val->date;
                $date_arr = explode('-', $date_en);
                $date_np = eng_to_nep($date_arr[0], $date_arr[1], $date_arr[2]);
                $report[$key]->date_nep = $date_np;

                /* total fee */
                $total_fee = 0;
                $bill_number = $val->bill_number;
                $total_fee = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                    ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                    ->whereIn('categories.id', $pathology)
                    ->where('billing_detail.bill_number', $bill_number)
                    ->sum('test_detail.test_price');

                $report[$key]->total_fee = number_format($total_fee, 2, '.', '');

                /* test list */
                $test_list = '';
                $list = TestDetail::leftJoin('billing_detail', 'test_detail.bid', '=', 'billing_detail.bid')
                    ->leftJoin('categories', 'test_detail.test_id', '=', 'categories.id')
                    ->whereIn('categories.id', $pathology)
                    ->where('billing_detail.bill_number', $bill_number)
                    ->select('categories.title')
                    ->get();

                foreach ($list as $res) {
                    $test_list .= $res->title . ', ';
                }
                $report[$key]->test_list = rtrim($test_list, ', ');
            }
            return view('account.general_report', compact('report', 'date_from', 'date_to', 'category', 'cat', 'title'));
        } else {
            return view('account.general_report', compact('date_from', 'date_to', 'category', 'cat', 'title'));
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function IPDReport()
    {
        $cat = 0;
        return view('account.report_chooser_ipd', compact('cat'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function GenerateIPDReport(Request $request)
    {
        $date_from = $request->get('datefrom');
        $date_to = $request->get('dateto');
        $cat = $request->get('category');

        /* convert nepali date to english */
        $localDate = str_replace("/", "-", $date_from);
        $classes = explode("-", $localDate);

        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $dateFrom = nep_to_eng($a, $b, $c);

        $localDate = str_replace("/", "-", $date_to);
        $classes = explode("-", $localDate);

        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $dateTo = nep_to_eng($a, $b, $c);

        if ($cat == "test") {
            $title = "IPD Test";

            /*IPD Discharge Items Report*/
            /*$ipd_discharge = DB::table('discharge_details')
                ->leftJoin('discharge_invoice_items', 'discharge_details.id', '=', 'discharge_invoice_items.discharge_id')
                ->leftJoin('ipatient', 'discharge_details.ipatient_id', '=', 'ipatient.id')
                ->select('ipatient.first_name', 'ipatient.status', 'ipatient.patient_type', 'ipatient.patient_code', 'ipatient.discharged_at',
                    'ipatient.doctor_id', 'discharge_details.bill_number', 'discharge_details.created_at', 'discharge_details.id as discharge_id')
                ->where('ipatient.patient_type', 'IPD')
                ->where('ipatient.status', 'Discharged')
                ->whereDate('discharge_details.created_at', '>=', $dateFrom)
                ->whereDate('discharge_details.created_at', '<=', $dateTo)
                ->groupBy('discharge_details.bill_number')
                ->get();

            foreach ($ipd_discharge as $key => $patient) {
                $date_en = $patient->discharged_at;
                $date_arr = explode('-', $date_en);
                $date_np = eng_to_nep($date_arr[0], $date_arr[1], $date_arr[2]);
                $patient->date_nep = $date_np;

                $doctor = Doctor::findOrFail($patient->doctor_id);
                $doctor_name = $doctor->first_name . ' ' . $doctor->middle_name . ' ' . $doctor->last_name;
                $patient->doctor_name = $doctor_name;

                $dis_items = DB::table('discharge_invoice_items')
                    ->where('discharge_id', $patient->discharge_id)
                    ->get();

                $patient->discharge_items[] = $dis_items;

                $test_list = '';
                $total_fee = $tax = $gtotal = 0;
                foreach ($dis_items as $key1 => $item) {*/
            /*insert hst and grand total*/
            /*$test_price = $item->test_price;
            $total_fee += $test_price;
            $hst = $test_price * 5 / 100;
            $tax += $hst;
            $gtotal += $test_price + $hst;

            $item_name = DB::table('categories')
                ->where('id', $item->test_id)
                ->select('title')
                ->first();

            $item->test_name = $item_name->title;

            $test_list .= $item_name->title . ', ';
        }
        $patient->test_list = rtrim($test_list, ', ');
        $patient->total_fee = $total_fee;
        $patient->tax = $tax;
        $patient->gtotal = $gtotal;
    }*/

            /*IPD test report by subcategory*/
            $test_subcat = Category::where('level', '2')
                ->where('parent_id', '<>', 1)
                ->orderBy('title', 'asc')
                ->get();

            $test_res = array();
            foreach ($test_subcat as $key => $subcat) {
                $sid = $subcat->id;
                $stitle = $subcat->title;
                $test = DischargeInvoiceItem::leftJoin('discharge_details', 'discharge_invoice_items.discharge_id', '=', 'discharge_details.id')
                    ->leftJoin('categories', 'discharge_invoice_items.test_id', '=', 'categories.id')
                    ->select('discharge_details.created_at as discharge_date', 'discharge_details.*', 'discharge_invoice_items.*', 'categories.*')
                    ->where('categories.level', '3')
                    ->where('categories.parent_id', $sid)
                    ->whereDate('discharge_details.created_at', '>=', $dateFrom)
                    ->whereDate('discharge_details.created_at', '<=', $dateTo)
                    ->get();

                foreach ($test as $key => $val) {
                    $pid = $val->ipatient_id;
                    $patient_name = IPatient::where('id', $pid)->select('first_name', 'middle_name', 'last_name')->get();
                    $pname = @$patient_name[0]->first_name . ' ' . @$patient_name[0]->middle_name . ' ' . @$patient_name[0]->last_name;
                    $test[$key]->patient_name = $pname;

                    $detail = IPatient::where('id', $pid)->select('patient_code')->first();
                    $test[$key]->patient_code = $detail->patient_code;
                }
                if (!empty($test)) {
                    foreach ($test as $tkey => $tst) {
                        $tax = $tst->test_price * 5 / 100;
                        $grand_total = round($tax, 2) + $tst->test_price;
                        $test_res[$stitle][$tkey]['name'] = @$tst->patient_name;
                        $test_res[$stitle][$tkey]['fee'] = $tst->test_price;
                        $test_res[$stitle][$tkey]['tax'] = round($tax, 2);
                        $test_res[$stitle][$tkey]['grand_total'] = $grand_total;
                        $test_res[$stitle][$tkey]['test'] = $tst->title;
                        $test_res[$stitle][$tkey]['patient_code'] = $tst->patient_code;
                        $test_res[$stitle][$tkey]['bill_number'] = $tst->bill_number;
                    }
                }
            }

            /*IPD Pathology test report*/
            $test_pathology = Category::where('parent_id', 1)
                ->where('level', 2)
                ->orderBy('title', 'asc')
                ->get();

            $ipd_test_path = array();
            foreach ($test_pathology as $pkey => $subcat) {
                $sid = $subcat->id;
                $stitle = $subcat->title;
                $test = DischargeInvoiceItem::leftJoin('discharge_details', 'discharge_invoice_items.discharge_id', '=', 'discharge_details.id')
                    ->leftJoin('ipatient', 'discharge_details.ipatient_id', 'ipatient.id')
                    ->leftJoin('categories', 'discharge_invoice_items.test_id', '=', 'categories.id')
                    ->select('discharge_details.created_at as discharge_date', 'discharge_details.*', 'discharge_invoice_items.*', 'categories.*', 'ipatient.doctor_id')
                    ->where('categories.level', '3')
                    ->where('categories.parent_id', $sid)
                    ->whereDate('discharge_details.created_at', '>=', $dateFrom)
                    ->whereDate('discharge_details.created_at', '<=', $dateTo)
                    ->get();

                foreach ($test as $key => $val) {
                    $pid = $val->ipatient_id;
                    $patient_name = IPatient::where('id', $pid)->select('first_name', 'middle_name', 'last_name')->get();
                    $pname = @$patient_name[0]->first_name . ' ' . @$patient_name[0]->middle_name . ' ' . @$patient_name[0]->last_name;
                    $test[$key]->patient_name = $pname;

                    $detail = IPatient::where('id', $pid)->select('patient_code')->first();
                    $test[$key]->patient_code = $detail->patient_code;
                }
                if (!empty($test)) {
                    foreach ($test as $tkey => $tst) {
                        $tax = $tst->test_price * 5 / 100;
                        $grand_total = round($tax, 2) + $tst->test_price;
                        $ipd_test_path[$pkey][$tkey]['name'] = @$tst->patient_name;
                        $ipd_test_path[$pkey][$tkey]['fee'] = $tst->test_price;
                        $ipd_test_path[$pkey][$tkey]['tax'] = round($tax, 2);
                        $ipd_test_path[$pkey][$tkey]['grand_total'] = $grand_total;
                        $ipd_test_path[$pkey][$tkey]['test'] = $tst->title;
                        $ipd_test_path[$pkey][$tkey]['patient_code'] = $tst->patient_code;
                        $ipd_test_path[$pkey][$tkey]['bill_number'] = $tst->bill_number;
                    }
                }
            }
            //dd($ipd_test_path);
            return view('account.ipd_report', compact('ipd_discharge', 'test_res', 'date_from', 'date_to', 'cat', 'title', 'ipd_test_path'));
        } elseif ($cat == "bed charge") {
            $title = "IPD Bed Charge";
            /*IPD bed charge report*/
            $rooms = Room::all();

            foreach ($rooms as $room) {
                $j = 0;
                $roomId = $room->id;

                $discharge_details = DB::table('discharge_details')
                    ->leftJoin('ipatient', 'discharge_details.ipatient_id', 'ipatient.id')
                    ->leftJoin('doctors', 'ipatient.doctor_id', 'doctors.id')
                    ->select('discharge_details.room_id', 'discharge_details.room_charge', 'discharge_details.bill_number', 'ipatient.first_name as patient_name', 'ipatient.patient_code', 'doctors.first_name', 'doctors.middle_name', 'doctors.last_name')
                    ->whereDate('discharge_details.created_at', '>=', $dateFrom)
                    ->whereDate('discharge_details.created_at', '<=', $dateTo)
                    ->get();

                foreach ($discharge_details as $key => $detail) {
                    $room_id_arr = explode('-', $detail->room_id);
                    $room_charge_arr = explode('-', $detail->room_charge);
                    $count = count($room_id_arr);

                    if ($detail->room_id != "" && count($room_id_arr) == count($room_charge_arr)) {
                        for ($i = 0; $i < $count; $i++) {
                            $room_id = $room_id_arr[$i];
                            if ($room_id == $roomId) {
                                $room_charge = $room_charge_arr[$i];
                                $tax = 5 / 100 * $room_charge;
                                $grand_total = $room_charge + $tax;
                                $room = Room::findOrFail($room_id);
                                $room_name = $room->room_name;
                                $doctor_name = $detail->first_name . ' ' . $detail->middle_name . ' ' . $detail->last_name;
                                $bed_charge_detail[$room_name][$j++] = array(
                                    'patient_name' => $detail->patient_name,
                                    'patient_code' => $detail->patient_code,
                                    'doctor_name' => $doctor_name,
                                    'room_name' => $room_name,
                                    'room_charge' => $room_charge,
                                    'tax' => $tax,
                                    'grand_total' => $grand_total,
                                    'bill_number' => $detail->bill_number,
                                );
                            }
                        }
                    }
                }
            }
            //dd($bed_charge_detail);
            return view('account.ipd_report', compact('bed_charge_detail', 'date_from', 'date_to', 'cat', 'title'));
        } else {
            return view('account.ipd_report', compact('date_from', 'date_to', 'category', 'cat', 'title'));
        }
    }

    /* IPD Deposit Report */
    public function IPDDepostiReport() {

        return view('account.ipd_deposit_report');
    }

    public function GenerateIPDDepositReport(Request $request) {
        $code = $request->get('patient_code');

        $detail = Ipatient::where('ipatient.patient_code', $code)
                ->leftJoin('users', 'ipatient.discharge_user_id', '=', 'users.id')
                ->where('ipatient.patient_type', 'IPD')
                ->select('ipatient.first_name', 'ipatient.status', 'ipatient.deposit_amount', 'ipatient.deposit_dates', 'ipatient.discharged_at', 'users.fullname')
                ->get();

        if (count($detail) > 0) {
            foreach ($detail as $key => $val) {
                $amount = explode(',', $val->deposit_amount);
                $dates = explode(',', $val->deposit_dates);

                foreach ($dates as $ky => $dt) {
                    $date_np = explode('-', $dt);
                    $date_np = eng_to_nep($date_np[0], $date_np[1], $date_np[2]);
                    $dates[$ky] = $date_np;

                }

                $detail[$key]->deposit_amount = $amount;
                $detail[$key]->deposit_dates = $dates;
            }
        }

        return view('account.ipd_deposit_report', compact('detail', 'code'));
    }

    /* deposite report by date */
    public function dateDepositReport() {

        return view('account.date_deposit_report');
    }

    public function operateDateDepositReport(Request $request) {
        $date = $request->get('datefrom');

        $todayDate = $date;
        $localDate = str_replace("/", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $eng_date = nep_to_eng($a, $b, $c);

        $detail = Patient::where('patient_type', 'IPD')
                    ->where('deposit_dates', 'like', '%'.$eng_date.'%')
                    ->get();

        foreach ($detail as $key => $val) {
            $deposit_dates = $val->deposit_dates;
            $deposit_amount = $val->deposit_amount;
            $deposit_users = $val->deposit_user_id;

            $dep_dates_arr = explode(',', $deposit_dates);
            $dep_amt_arr = explode(',', $deposit_amount);
            $dep_user_arr = explode(',', $deposit_users);

            $detail[$key]->dep_amount = $detail[$key]->deposit_taken_by = '';
            for ($i = 0; $i < count($dep_dates_arr); $i++) { 

                if ($dep_dates_arr[$i] == $eng_date) {
                    $detail[$key]->dep_amount .= $dep_amt_arr[$i] . "<br />";
                    $dep_user = $dep_user_arr[$i];
                    $dep_user_id = User::find($dep_user);
                    $detail[$key]->deposit_taken_by .= $dep_user_id->fullname . "<br />";
                }
            }
            $detail[$key]->dep_amount = rtrim($detail[$key]->dep_amount, "<br />");
            $detail[$key]->deposit_taken_by = rtrim($detail[$key]->deposit_taken_by, "<br />");
        }

        return view('account.date_deposit_report', compact('detail', 'date'));
    }

    /* deposite report by date */
    public function dateDischargeReport() {

        return view('account.date_discharge_report');
    }

    public function operateDateDischargeReport(Request $request) {
        $date = $request->get('datefrom');

        $todayDate = $date;
        $localDate = str_replace("/", "-", $todayDate);
        $classes = explode("-", $localDate);
        $a = sprintf('%02d', $classes[0]);
        $b = sprintf('%02d', $classes[1]);
        $c = sprintf('%02d', $classes[2]);
        $eng_date = nep_to_eng($a, $b, $c);

        $detail = Patient::where('patient_type', 'IPD')
                    ->leftJoin('discharge_details', 'ipatient.id', '=', 'discharge_details.ipatient_id')
                    ->leftJoin('users', 'ipatient.discharge_user_id', '=', 'users.id')
                    ->where('ipatient.patient_type', 'IPD')
                    ->where('ipatient.status', 'Discharged')
                    ->whereDate('discharged_at', $eng_date)
                    ->get();

        


        foreach ($detail as $key => $val) {
            $dep_amount = explode(',', $val->deposit_amount);
            $total_deposit = array_sum($dep_amount);
            $detail[$key]->total_deposit = $total_deposit;
        }

        return view('account.date_discharge_report', compact('detail', 'date'));
    }
}
