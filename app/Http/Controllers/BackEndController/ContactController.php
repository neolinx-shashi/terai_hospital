<?php

namespace App\Http\Controllers\BackEndController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Doctor;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{

    private $contact;
    private $doctor;

    /**
     * ContactController constructor.
     * @param Contact $contacts
     */
    public function __construct(Contact $contacts, Doctor $doctor)
    {
        $this->contact = $contacts;
        $this->doctor = $doctor;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = $this->contact
            ->orderBy('created_At','Desc')
            ->paginate(10);

        return view('backendview.admin.contact.index', compact('contacts'));

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
    public function store(ContactRequest $request)
    {
        $input = $request->all();
        try {
            if ($request->all()) {
                $this->contact->create($input);
                session()->flash('success', 'Contact added Successfully');
                return redirect('contact');
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
        $edit = $this->contact->find($id);
        $contacts = $this->contact
            ->orderBy('created_at','Desc')
            ->paginate(10);
        if ($edit) {
            return view('backendview.admin.contact.index', compact('edit',
                'contacts'));
        } else
            return redirect('/contact');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactRequest $request, $id)
    {
        $id = (int)$id;
        if ($request->all()) {
            $data = $this->contact->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                session()->flash('success', 'Contact updated Successfully');
                return redirect('contact');
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to handle the request');
        return redirect('contact');
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
            $data = $this->contact->find($id);
            if ($data) {
                $data->delete();
                session()->flash('success', 'Contact Deleted Successfully');
                return redirect()->back();
            }
            session()->flash('error', 'Sorry unable to handle the request');
            return redirect()->back();

        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry unable to handle the request');
            return redirect('contact');
        }
    }

    public function ViewContact()
    {
        $contacts = $this->contact->all();
        $doctors = $this->doctor->all();

        return view('appointment.contact', compact('contacts', 'doctors'));
    }
}
