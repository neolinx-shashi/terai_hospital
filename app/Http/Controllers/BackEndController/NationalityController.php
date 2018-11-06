<?php

namespace App\Http\Controllers\BackEndController;
use App\Models\Nationality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\NationalityRequest;
use Illuminate\Database\QueryException;

class NationalityController extends Controller
{

    private $nationality;

    public function __construct(Nationality $nationality)
    {
        $this->middleware('auth');
        $this->nationality=$nationality;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $nationality=$this->nationality
        ->orderBy('created_at','dsc')
        ->get();
        return view('backendview.admin.nationality.index',compact('nationality'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
                return view('backendview.admin.nationality.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NationalityRequest $request)
    {
         $input = $request->all();
        try {
            if ($request->all()) {
                Nationality::create($input);
                session()->flash('success', 'Nationality added Successfully');
                return redirect('nationality-setup');
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
            $edit = $this->nationality->find($id);
            if ($edit)
             {
            $nationality=$this->nationality
            ->orderBy('created_at','dsc')
            ->get();
             return view('backendview.admin.nationality.index', compact('edit',
                                                                    'nationality'));
            } else
                return redirect('/nationality-setup');
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
            $data = $this->nationality->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                session()->flash('success', 'Nationality updated Successfully');
                return redirect('/nationality-setup');
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to handle the request');
        return redirect('nationality-setup');
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
            $data = $this->nationality->find($id);
            if ($data) {
                $data->delete();
                session()->flash('success', 'Nationality Deleted Successfully');
                return redirect()->back();
            }
            session()->flash('error', 'Sorry unable to handle the request');
            return redirect()->back();

        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry unable to handle the request');
            return redirect('nationality-setup');
        }
    }
}
