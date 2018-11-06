<?php

namespace App\Http\Controllers\BackEndController;

use App\Models\ServiceCharge;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\ServiceChargeRequest;

class ServiceChargeController extends Controller
{
    private $serviceCharge;

    public function __construct(ServiceCharge $serviceCharge)
    {
        $this->serviceCharge = $serviceCharge;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviceCharges = $this->serviceCharge->paginate(10);

        return view('backendview.admin.serviceCharge.index', compact('serviceCharges'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backendview.admin.serviceCharge.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceChargeRequest $request)
    {
        $input = $request->all();
        try {
            if ($request->all()) {
                ServiceCharge::create($input);
                session()->flash('success', 'Nationality added Successfully');
                return redirect(route('service-charge.index'));
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
        $edit = $this->serviceCharge->find($id);
        if ($edit) {
            return view('backendview.admin.serviceCharge.edit', compact('edit'));
        } else
            return redirect(route('service-charge.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = (int)$id;
        if ($request->all()) {
            $data = $this->serviceCharge->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                session()->flash('edit', 'Department updated Successfully');
                return redirect(route('service-charge.index'));
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to handle the request');
        return redirect(route('service-charge.index'));
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
            $data = $this->serviceCharge->find($id);
            if ($data) {
                $data->delete();
                session()->flash('success', 'Service Charge Deleted Successfully');
                return redirect()->back();
            }
            session()->flash('error', 'Sorry unable to handle the request');
            return redirect()->back();

        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry unable to handle the request');
            return redirect(route('service-charge.index'));
        }
    }
}
