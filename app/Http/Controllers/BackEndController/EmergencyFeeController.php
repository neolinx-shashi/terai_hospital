<?php

namespace App\Http\Controllers\BackEndController;

use Illuminate\Http\Request;
use App\Http\Requests\EmergencyFeeRequest;
use App\Http\Controllers\Controller;
use App\Models\EmergencyFee;
use App\Repository\EmergencyFeeRepo;
use Illuminate\Database\QueryException;

class EmergencyFeeController extends Controller
{
    private $emergencyFee;
    private $emergencyFeeRepo;

    public function __construct(EmergencyFee $emergencyFee,
                                EmergencyFeeRepo $emergencyFeeRepo)
    {
        $this->middleware('auth');
        $this->emergencyFee = $emergencyFee;
        $this->emergencyFeeRepo = $emergencyFeeRepo;
    }

    public function index()
    {
        $emergencyFee = $this->emergencyFee->all();
        return view('backendview.emergencyFee.index', compact('emergencyFee'));
    }


    public function create()
    {
        //
    }


    public function store(EmergencyFeeRequest $request)
    {
        try {
            if ($request->all()) {
                $input = $request->all();
                $emergencyFee = $request->get('emergency_fee');


                $input['emergency_fee'] = $emergencyFee;

                EmergencyFee::create($input);
                session()->flash('success', 'Emergency Fee added successfully');
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
            $edit = $this->emergencyFee->find($id);
            if ($edit) {
                $emergencyFee = $this->emergencyFee->all();
                return view('backendview.emergencyFee.index', compact('emergencyFee',
                    'edit'));
            } else
                return redirect('/emergency-fee');
        }
    }


    public function update(EmergencyFeeRequest $request, $id)
    {
        $id = (int)$id;
        if ($request->all()) {
            $data = $this->emergencyFee->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                session()->flash('success', 'Emergency Fee updated successfully');
                return redirect('emergency-fee');
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to proceed the  request');
        return redirect('emergency-fee');
    }


    public function destroy($id)
    {
        try {
            $id = (int)$id;
            $data = $this->emergencyFee->find($id);
            $currentEmergencyFee = $this->emergencyFeeRepo->currentEmergencyFee();
            if ($currentEmergencyFee->id != $id) {
                if ($data) {
                    $data->delete();
                    session()->flash('success', 'Emergency Fee  Deleted Successfully');
                    return redirect()->back();
                }
                session()->flash('error', 'This Emergency Fee is in use you cannot delete it ');
                return redirect()->back();
            }
            session()->flash('error', 'Unable to handle the request');
            return redirect()->back();
        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry you cannot delete this Emergency Fee.');
            return redirect('fiscal-year');
        }
    }

    public function status($id)
    {
        $emergencyFee = $this->emergencyFee->find($id);
        $this->emergencyFeeRepo->status($id);
        if ($emergencyFee->save()) {
            session()->flash('status', 'Emergency Fee Updated Successfully');
            return redirect('/emergency-fee');
        } else {
            session()->flash('error', 'Unable to handle the request');
        }
        return redirect('/emergency-fee');
    }

}
