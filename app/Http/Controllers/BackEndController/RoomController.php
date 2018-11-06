<?php

namespace App\Http\Controllers\BackEndController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use App\Models\Ward;
use App\Models\Bed;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $room;
    private $ward;
    private $bed;

    /**
     * RoomController constructor.
     * @param Room $room
     * @param Ward $ward
     * @param Bed $bed
     */
    public function __construct(Room $room, Ward $ward, Bed $bed)
    {
        $this->ward = $ward;
        $this->room = $room;
        $this->bed = $bed;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $rooms = $this->room
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        $wards = $this->ward->all();
        $beds = $this->bed->all();
        return view('backendview.ward.room.index', compact('rooms', 'wards', 'beds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rooms = $this->room->paginate(10);
        $wards = $this->ward->all();
        return view('backendview.ward.room.create', compact('rooms', 'wards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {
        $input = $request->all();
        //dd($input);
        try {
            if ($request->all()) {
                Room::create($input);

                session()->flash('success', 'Room Created Successfully');
                return redirect('ward/room');
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
        $edit = $this->room->find($id);
        if ($edit) {
            $wards = $this->ward->all();
            $beds = $this->bed->all();
           $rooms = $this->room
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
            return view('backendview.ward.room.index', compact('rooms',
                'wards',
                'edit',
                'beds'));
        } else
            return redirect('/ward/room/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoomRequest $request, $id)
    {
        //dd($request->all());
        $id = (int)$id;
        if ($request->all()) {
            $data = $this->room->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                //$data->update($request->all());
                session()->flash('success', 'Room updated Successfully');
                return redirect('ward/room');
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to handle the request');
        return redirect('ward/room');
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
            $data = $this->room->find($id);
            if ($data) {
                $data->delete();
                session()->flash('success', 'Room Deleted Successfully');
                return redirect()->back();
            }
            session()->flash('error', 'Sorry unable to handle the request');
            return redirect()->back();

        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry unable to handle the request');
            return redirect('ward/room');
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getWard($id)
    {
        $ward = $this->ward->findOrFail($id);
        $wardName = $ward->ward_name;
        return $wardName;
    }
}
