<?php

namespace App\Http\Controllers\BackEndController;

use Illuminate\Http\Request;
use App\Http\Requests\WardRequest;
use App\Http\Requests\UpdateWardRequest;
use App\Http\Controllers\Controller;
use App\Models\Ward;
use App\Models\Bed;
use App\Models\Room;
use DB;
use Illuminate\Database\QueryException;

class WardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $ward;
    private $bed;
    private $room;

    public function __construct(Ward $ward, Room $room, Bed $bed)
    {
        $this->middleware('auth');
        $this->ward = $ward;
        $this->room = $room;
        $this->bed = $bed;
    }

    public function index()
    {
        $wards = $this->ward
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        $beds = $this->bed->all();
        $rooms = $this->room->all();
        return view('backendview.ward.index', compact('wards',
            'beds',
            'rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $wards = $this->ward->paginate(10);

        return view('backendview.ward.create', compact('wards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(WardRequest $request)
    {
        $input = $request->all();
        try {
            if ($request->all()) {
                Ward::create($input);

                session()->flash('success', 'Ward Created Successfully');
                return redirect('ward/ward-details');
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
        $wardName = $this->ward->find($id);
        if ($wardName) {
            $wards = $this->ward
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
            $beds = $this->bed->all();
            $rooms = $this->room->all();
            return view('backendview.ward.index', compact(
                'wardName',
                'wards',
                'beds',
                'rooms'));
        } else
            return redirect('/ward/ward-details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWardRequest $request, $id)
    {
        $id = (int)$id;
        if ($request->all()) {
            $data = $this->ward->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                session()->flash('success', 'Ward updated Successfully');
                return redirect('ward/ward-details');
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to handle the request');
        return redirect('ward/ward-details');
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
            $data = $this->ward->find($id);
            if ($data) {
                $data->delete();
                session()->flash('success', 'Ward Deleted Successfully');
                return redirect()->back();
            }
            session()->flash('error', 'Sorry unable to delete');
            return redirect()->back();

        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry unable to delete the data');
            return redirect('ward/ward-details');
        }
    }
}
