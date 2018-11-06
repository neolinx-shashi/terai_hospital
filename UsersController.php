<?php

namespace App\Http\Controllers\BackendController;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Repository\UsersRepo\UsersTypeRepository;
use App\Repository\UsersRepo\UsersRepository;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class UsersController extends Controller
{
    private $usersType;
    private $usersRepository;
    private $user;


    public function __construct(UsersTypeRepository $usersType,
                                UsersRepository $usersRepository,
                                User $user
    )
    {

        $this->usersType = $usersType;
        $this->usersRepository = $usersRepository;
        $this->user = $user;
    }

    public function index()
    {
        $user = $this->usersRepository->getUserDetailsOfId();
        $useradmin = $this->usersRepository->listsLogUser();
        return view('backendview.usersview.index', compact('user',
            'useradmin'));
    }

    public function create()
    {


        $userType = $this->usersType->isSuperAdmin();
        return view('backendview.usersview.create', compact('userType'));
    }


    public function store(UserRequest $request)
    {

        $input = $request->all();
        if ($input) {
            $destinationPath = 'uploads/users';
            if ($image = Input::file('userimage_name')) {
                $input['userimage_name'] = str_random(6) . '_' . time() . "-" . $request->file('userimage_name')
                        ->getClientOriginalName();
                $request->file('userimage_name')->move($destinationPath, $input['userimage_name']);
            }

            $ip = $request->getClientIp();

            $input['ip_address'] = $ip;
            $browserAgent = $_SERVER['HTTP_USER_AGENT'];
            $input['browser_agent'] = $browserAgent;

            User::create($input);
            session()->flash('success', 'Record added successfully.');
            $user = $this->usersRepository->getUserDetailsOfId();
            return view('backendview.usersview.index', compact('user'));

        } else {
            session()->flash('error', 'Sorry! Could not proceed the Request.');
            return redirect()
                ->back();

        }
    }


    public function show($id)
    {
        $viewuserData = $this->user->find($id);
        return view('backendview/usersview/userdetails',
            compact('viewuserData'));
    }


    public function edit($id)
    {
        $edituser = $this->user->find($id);
        return view('backendview/usersview/edituser', compact('edituser'));
    }

    public function UserStatus($id)
    {
        $user = $this->user->find($id);
        $user->status = ($user->status == 'Active') ? 'Inactive' : 'Active';
        if ($user->save()) {
            session()->flash('success', 'Well Done! User status has been updated successfully.');
        } else {
            session()->flash('error', 'Sorry! Could not complete the request.');
        }
        return redirect('/usersetup');
    }

    public function update(Request $request, $id)
    {
        $oldslider = User::find($id);
        $input = $this->user->find($id);
        if ($input) {
            if (Input::file('userimage_name')) {
                $removeimage = $oldslider->userimage_name;
                if (empty($removeimage)) {
                    $input['userimage_name'] = str_random(6) . '_' . time() . '.' . $request->file('userimage_name')
                            ->getClientOriginalName();
                    $destinationpath = public_path('uploads/users/');
                    $request->file('userimage_name')->move($destinationpath, $input['userimage_name']);
                    $input->update(Input::except('userimage_name'));
                    session()->flash('success', 'Slider Updated Successfully.');

                    return redirect('/usersetup');
                } else {
                    unlink('uploads/users/' . $removeimage);
                    $destinationpath = public_path('uploads/users/');
                    $request->file('userimage_name')->move($destinationpath, $input['userimage_name']);
                    $input->update(Input::except('userimage_name'));
                    session()->flash('success', 'Users Updated Successfully.');
                    return redirect('/usersetup');
                }
            } else {
                $input->fill($request->all())->save();
                session()->flash('success', ' Users Updated Successfully.');
                return redirect('/usersetup');
            }
        }


    }


    public function destroy($id)
    {
        $sliderdata = $this->user->find($id);
        if ($sliderdata) {
            $image_name = $sliderdata->userimage_name;
            if ($image_name != '') {
                $path = 'uploads/users/' . $image_name;
                @unlink($path);
            }

            $sliderdata->delete();
            Session::flash('success', 'Record deleted successfully.');
            return redirect('/usersetup');
        }


        session()->flash('error', 'Could not complete the request.');
        return redirect()->back();

    }

    public function changePassword(Request $request, $id)
    {
        $currentPassword = Input::get('current_password');
        $newPassword = Input::get('new_password');
        $confirmpassword = Input::get('confirm_password');
        $check_password = $this->user->find($id);

        if (!empty($currentPassword)) {
            if (Hash::check($currentPassword, $check_password->password)) {
                if ($newPassword == $confirmpassword) {
                    if (!empty($newPassword)) {
                        $request['password'] = Hash::make($newPassword);
                        $check_password->fill($request->all())->save();
                        Session::flash('success', 'Password Successfully Updated');
                        return redirect()->back();
                    } elseif (empty($newPassword)) {
                        Session::flash('error', 'New Password Required');
                        return redirect()->back()
                            ->withInput();
                    }
                } else {
                    Session::flash('error', ' New Password and Confirm Password not Match');
                    return redirect()->back()
                        ->withInput();
                }
            } else {
                session()->flash('error', ' Looks like the Entered Password is wrong');
                return redirect()->back()
                    ->withInput();

            }

        } elseif (empty($currentPassword)) {
            session()->flash('error', ' Current Password Required.');
            return redirect()->back()
                ->withInput();
        } else {
            abort(404);


        }
    }
}