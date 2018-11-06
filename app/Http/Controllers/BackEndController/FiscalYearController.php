<?php

namespace App\Http\Controllers\BackEndController;

use Illuminate\Http\Request;
use App\Http\Requests\FiscalYearRequest;
use App\Http\Controllers\Controller;
use App\Models\FiscalYear;
use App\Repository\FiscalYearRepo;
use Illuminate\Database\QueryException;

class FiscalYearController extends Controller
{
    private $fiscalYear;
    private $fiscalYearRepo;

    public function __construct(FiscalYear $fiscalYear,
                                FiscalYearRepo $fiscalYearRepo)
    {
        $this->middleware('auth');
        $this->fiscalYear = $fiscalYear;
        $this->fiscalYearRepo = $fiscalYearRepo;
    }

    public function index()
    {
        $fiscalYear = $this->fiscalYear->all();
        return view('backendview.fiscalYear.index', compact('fiscalYear'));
    }


    public function create()
    {
        //
    }


    public function store(FiscalYearRequest $request)
    {
        try {
            if ($request->all()) {
                $input = $request->all();
                $startDate = $request->get('fiscal_year_start_date');

                $input['fiscal_year_start_date'] = $startDate;

                FiscalYear::create($input);
                session()->flash('success', 'Fiscal year added successfully');
                return redirect()->back();
            } else {
                return redirect()
                    ->back()
                    ->withInput();
            }
        } catch
        (Exception $e) {
            session()->flash('error', 'Sorry unable to proceed the request');
        }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        {
            $id = (int)$id;
            $edit = $this->fiscalYear->find($id);
            if ($edit) {
                $fiscalYear = $this->fiscalYear->all();
                return view('backendview.fiscalYear.index', compact('fiscalYear',
                    'edit'));
            } else
                return redirect('/fiscal-year');
        }
    }


    public function update(FiscalYearRequest $request, $id)
    {
        $id = (int)$id;
        if ($request->all()) {
            $data = $this->fiscalYear->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                session()->flash('success', 'Fiscal year updated successfully');
                return redirect('fiscal-year');
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to proceed the  request');
        return redirect('fiscal-year');
    }


    public function destroy($id)
    {
        try {
            $id = (int)$id;
            $data = $this->fiscalYear->find($id);
            $currentFiscalYear = $this->fiscalYearRepo->currentFiscalYear();
            if ($currentFiscalYear->id != $id) {
                if ($data) {
                    $data->delete();
                    session()->flash('success', 'Fiscal Year Deleted Successfully');
                    return redirect()->back();
                }
                session()->flash('error', 'This Fiscal year is in use you cannot delete it ');
                return redirect()->back();
            }
            session()->flash('error', 'Unable to handle the request');
            return redirect()->back();
        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry you cannot delete this fiscal year.');
            return redirect('fiscal-year');
        }
    }

    public function status($id)
    {
        $fiscalyear = $this->fiscalYear->find($id);
        $this->fiscalYearRepo->status($id);
        if ($fiscalyear->save()) {
            session()->flash('status', 'Fiscal Year Updated Successfully');
            return redirect('/fiscal-year');
        } else {
            session()->flash('error', 'Unable to handle the request');
        }
        return redirect('/fiscal-year');
    }

}
