<?php

namespace App\Http\Controllers\BackEndController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Patient;
use App\Models\IPatient;
use Maatwebsite\Excel\Facades\Excel;
class MasterDataImportExportController extends Controller
{

    private $patient;
    public function __construct(Patient $patient,
        IPatient $ipatient)
    {
        $this->patient = $patient;
        $this->ipatient=$ipatient;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fiscalYear=DB::table('fiscal_year')
        ->orderBy('id','desc')
        ->get();


        return view('backendview.masterDataImportExport.index', compact('fiscalYear'));
    }

   
    public function create()
    {
    

    
    }

   
  
   
    public function fiscalYearReport($id)
    {
        //  $excelReport = $this->ipatient
        //  ->where('fiscal_year_id',$id)
        // ->get();

         $excelReport=   IPatient::leftJoin('billing_detail', 'billing_detail.patient_id', '=', 'ipatient.id')
             ->leftJoin('discharge_details', 'discharge_details.ipatient_id', '=', 'ipatient.id')
            ->select(['billing_detail.*','ipatient.*','discharge_details.*'])
            ->where('ipatient.fiscal_year_id',$id)
            ->get();
    
        Excel::create('Patients Reports by Fiscal Year', function ($excel) use ($excelReport) {
            $excel->sheet('New sheet', function ($sheet) use ($excelReport) {
                $sheet->loadView('backendview.masterDataImportExport.patient_fiscal_year_report', compact('excelReport'));

            });

        })->export('xls');

        
    
    }
}
