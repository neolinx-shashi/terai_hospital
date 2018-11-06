<?php

namespace App\Http\Controllers\BackEndController;

use App\Http\Requests\IPDAdmissionChargeRequest;
use App\Models\IPDAdmissionCharge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class IPDAdmissionChargeController extends Controller
{
    private $admissionCharge;

    public function __construct(IPDAdmissionCharge $admissionCharge)
    {
        $this->middleware('auth');
        $this->admissionCharge = $admissionCharge;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $admissionCharges = $this->admissionCharge->all();
        return view('backendview.admin.IPDAdmissionCharge.index', compact('admissionCharges'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(IPDAdmissionChargeRequest $request)
    {
        $input = $request->all();
        $input['current_admission_charge'] = 'N';
        try {
            if ($request->all()) {
                IPDAdmissionCharge::create($input);
                session()->flash('success', 'Admission Charge added Successfully');
                return redirect('/admission-charge');
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

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = (int)$id;
        $edit = $this->admissionCharge->find($id);
        if ($edit) {
            $admissionCharges = $this->admissionCharge->all();
            return view('backendview.admin.IPDAdmissionCharge.index', compact('admissionCharges', 'edit'));
        } else
            return redirect('/admission-charge');


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(IPDAdmissionChargeRequest $request, $id)
    {
        $id = (int)$id;
        if ($request->all()) {
            $data = $this->admissionCharge->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                session()->flash('success', 'Admission Charge updated Successfully');
                return redirect('/admission-charge');
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to handle the request');
        return redirect('configuration/consulting-fee');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $id = (int)$id;
            $data = $this->admissionCharge->find($id);
            if ($data) {
                $data->delete();
                session()->flash('success', 'Admission Charge Deleted Successfully');
                return redirect()->back();
            }
            session()->flash('error', 'Sorry unable to handle the request');
            return redirect()->back();

        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry unable to handle the request');
            return redirect('/admission-charge');
        }
    }

    public function status($id)
    {
        $admissionCharge = $this->admissionCharge->find($id);
        if ($admissionCharge->current_admission_charge == 'N') {
            $admissionCharge->current_admission_charge = 'Y';
            //dd($admissionCharge);
            if ($admissionCharge->update()) {
                $this->admissionCharge
                    ->where('id', '!=', $admissionCharge->id)
                    ->update(['current_admission_charge' => 'N']);
                session()->flash('success', 'Admission Charge Updated Successfully');
            } else {
                session()->flash('error', 'Unable to handle the request');
            }
        }
        return redirect('/admission-charge');
    }
}
