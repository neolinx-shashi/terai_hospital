<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Http\Requests\DepartmentRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;

class DepartmentController extends Controller
{
    private $department;

    /**
     * DepartmentController constructor.
     * @param Department $department
     */
    public function __construct(Department $department)
    {
        $this->department = $department;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $departments = $this->department
        ->orderBy('created_at','dsc')
        ->paginate(10);
        return view('backendview.admin.department.index', compact('departments'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('backendview.admin.department.create');
    }


    /**
     * @param DepartmentRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(DepartmentRequest $request)
    {
        $input = $request->all();
        try {
            if ($request->all()) {
                Department::create($input);
                session()->flash('success', 'Department added Successfully');
                return redirect('department');
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
     * @param $id
     */
    public function show($id)
    {
        //
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit($id)
    {
        $id = (int)$id;
        $edit = $this->department->find($id);
        $departments = $this->department
        ->orderBy('created_at','dsc')
        ->paginate(10);
        if ($edit) {
            return view('backendview.admin.department.index', compact('edit',
                'departments'));
        } else
            return redirect('/department');

    }


    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $id = (int)$id;
        if ($request->all()) {
            $data = $this->department->find($id);
            if ($data) {
                $data->fill($request->all())->save();
                session()->flash('success', 'Department updated Successfully');
                return redirect('department');
            }
        } else {
            return redirect()
                ->back()
                ->withInput();
        }
        session()->flash('error', 'Sorry unable to handle the request');
        return redirect('department');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $id = (int)$id;
            $data = $this->department->find($id);
            if ($data) {
                $data->delete();
                session()->flash('success', 'Department Deleted Successfully');
                return redirect()->back();
            }
            session()->flash('error', 'Sorry unable to handle the request');
            return redirect()->back();

        } catch (QueryException $e) {
            session()->flash('foreignerror', 'Sorry unable to handle the request');
            return redirect('department');
        }
    }


}
