<?php

namespace App\Http\Controllers\BackEndController;

use App\Http\Requests\DoctorChargeRequest;
use Illuminate\Http\Request;
use App\Models\DoctorCharge;
use App\Http\Controllers\Controller;

class DoctorChargeController extends Controller
{

    private $doctorCharge;

    public function __construct(DoctorCharge $doctorCharge)
    {
        $this->doctorCharge = $doctorCharge;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctorCharges = $this->doctorCharge
            ->orderBy('created_At','Desc')
            ->paginate(10);

        return view('backendview.admin.doctorCharge.index', compact('doctorCharges'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoctorChargeRequest $request)
    {
        $input = $request->all();
        try {
            if ($request->all()) {
                $this->doctorCharge->create($input);
                session()->flash('success', 'Doctor Charge added Successfully');
                return redirect('doctor-charge');
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
        $id = (int)$id;
        $edit = $this->doctorCharge->find($id);
        $doctorCharges = $this->doctorCharge
            ->orderBy('created_at','Desc')
            ->paginate(10);
        if ($edit) {
            return view('backendview.admin.doctorCharge.index', compact('edit',
                'doctorCharges'));
        } else
            return redirect('/doctor-charge');
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
            $data = $this->doctorCharge->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                session()->flash('success', 'Doctor Charge updated Successfully');
                return redirect('doctor-charge');
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to handle the request');
        return redirect('doctor-charge');
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
            $data = $this->doctorCharge->find($id);
            if ($data) {
                $data->delete();
                session()->flash('success', 'Doctor Charge Deleted Successfully');
                return redirect()->back();
            }
            session()->flash('error', 'Sorry unable to handle the request');
            return redirect()->back();

        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry unable to handle the request');
            return redirect('doctor-charge');
        }
    }

    public function getDoctorCharge($id)
    {
        $doctorCharge = $this->doctorCharge->findOrFail($id);
        $charge = $doctorCharge->charge;
        return $charge;
    }
}
