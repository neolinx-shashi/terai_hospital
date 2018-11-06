<?php

namespace App\Http\Controllers\BackEndController;
use Illuminate\Http\Request;
use App\Http\Requests\ConsultingFeeRequest;
use App\Models\ConsultingFee;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ConsultingFeeController extends Controller
{

    public function __construct(ConsultingFee $consultingFee)   
    {
            $this->middleware('auth');
            $this->consultingFee = $consultingFee;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $consultingFee = $this->consultingFee->all();
        return view('backendview.admin.consultingFee.index',compact('consultingFee'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backendview.admin.consultingFee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConsultingFeeRequest $request)
    {
         $input = $request->all();
        try {
            if ($request->all()) {
                ConsultingFee::create($input);
                session()->flash('success', 'Fee added Successfully');
                return redirect('configuration/consulting-fee');
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
           $id=(int)$id;
            $edit = $this->consultingFee->find($id);
            if ($edit)
             {
                return view('backendview.admin.consultingFee.edit', compact('edit'));
            } else
                return redirect('/configuration/consulting-fee');
        

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConsultingFeeRequest $request, $id)
    {
         $id = (int)$id;
        if ($request->all()) {
            $data = $this->consultingFee->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                session()->flash('edit', 'Consulting Fee updated Successfully');
                return redirect('configuration/consulting-fee');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $id = (int)$id;
            $data = $this->consultingFee->find($id);
            if ($data) {
                $data->delete();
                session()->flash('success', 'Consulting Fee Deleted Successfully');
                return redirect()->back();
            }
            session()->flash('error', 'Sorry unable to handle the request');
            return redirect()->back();

        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry unable to handle the request');
            return redirect('configuration/consulting-fee');
        }
        }
}
