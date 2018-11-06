<?php

namespace App\Http\Controllers\BackEndController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BedRequest;
use App\Http\Requests\UpdateBedRequest;
use App\Models\Room;
use App\Models\Ward;
use App\Models\Bed;


class BedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $room;
    private $ward;
    private $bed;

    public function __construct(Room $room,
                                Ward $ward,
                                Bed $bed)
    {
        $this->room = $room;
        $this->ward = $ward;
        $this->bed = $bed;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $beds = $this->bed
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        $rooms = $this->room->all();
        $wards = $this->ward->all();

        return view('backendview.ward.bed.index', compact('beds',
            'rooms',
            'wards'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $beds = $this->bed->paginate(10);
        $rooms = $this->room->all();
        $wards = $this->ward->all();
        return view('backendview.ward.bed.create', compact('beds',
            'rooms',
            'wards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BedRequest $request)
    {
        $input = $request->all();
        try {
            if ($request->all()) {
                Bed::create($input);

                session()->flash('success', 'Bed Created Successfully');
                return redirect('ward/bed');
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
        return $id;
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
        $edit = $this->bed->find($id);

        if(isset($edit->isOfRoom->room_type))
        {
            $room_type = $edit->isOfRoom->room_type;
        }

        $rooms = $this->room->all();
        $wards = $this->ward->all();
        if ($edit) {
            $beds = $this->bed
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
            return view('backendview.ward.bed.index', compact('beds',
                'edit',
                'rooms',
                'room_type',
                'wards'));
        } else
            return redirect('/ward/bed');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBedRequest $request, $id)
    {
        $id = (int)$id;
        if ($request->all()) {
            $data = $this->bed->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                session()->flash('success', 'Bed updated Successfully');
                return redirect('ward/bed');
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to handle the request');
        return redirect('ward/bed');
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
            $data = $this->bed->find($id);
            if ($data) {
                $data->delete();
                session()->flash('success', 'Bed Deleted Successfully');
                return redirect()->back();
            }
            session()->flash('error', 'Sorry unable to handle the request');
            return redirect()->back();

        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry unable to handle the request');
            return redirect('ward/bed');
        }
    }

    /**
     * @param $id
     * @param $officeId
     * @return string
     */
    public function roomList($id, $officeId)
    {
        $offices = $this->room
            ->select('id', 'room_name')
            ->where('ward_id', '=', $id)
            ->orderBy('id')
            ->get();

        $list = ' <select class="form-control" name="room_id" id="room"  onchange="changeData()">';

        $list .= ' <option value="">Select Room</option>';
        foreach ($offices as $office) {
            $selected = ($officeId == $office->id) ? "selected = selected" : "";

            $list .= '<option value="' . $office->id . '" ' . $selected . '>' . ucfirst($office->room_name) . '</option>';

        }
        $list .= '</select>';

        return $list;
    }

    public function privateRoomList($roomType, $officeId)
    {
        if($roomType == "one")
        {
            $roomType = "one bed";
        } elseif ($roomType == "two")
        {
            $roomType = "two bed";
        }

        $offices = $this->room
            ->where('room_type', '=', $roomType)
            ->orderBy('id', 'DESC')
            ->get();

        $list = ' <select class="form-control" name="room_id" id="room"  onchange="changeData()">';

        $list .= ' <option value="">Select Room</option>';
        foreach ($offices as $office) {
            $selected = ($officeId == $office->id) ? "selected = selected" : "";

            $list .= '<option value="' . $office->id . '" ' . $selected . '>' . ucfirst($office->room_name) . '</option>';

        }
        $list .= '</select>';

        return $list;
    }

    /**
     * @param $id
     * @param $officId
     * @return string
     */
    public function bedList($id, $officId)
    {
        $officess = $this->bed
            ->select('id', 'bed_name')
            ->where('room_id', '=', $id)
            ->where('availability', '=', 'Available')
            ->orderBy('id')
            ->get();

        $lists = ' <select class="form-control" name="bed_id" id="bed"  onchange="changeData()">';

        $lists .= ' <option value="">Select Bed</option>';
        foreach ($officess as $officee) {
            $selected = ($officId == $officee->id) ? "selected = selected" : "";

            $lists .= '<option value="' . $officee->id . '" ' . $selected . '>' . ucfirst($officee->bed_name) . '</option>';

        }
        $lists .= '</select>';

        return $lists;
    }
}
