<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{ //change password page
    public function changePasswordPage()
    {
        return view('admin.account.changePassword');
    }
    //change password
    public function changePassword(Request $request)
    {
        $this->passwordValidationCheck($request);
        $currentUserId = Auth::user()->id;
        $user = User::select('password')->where('id', $currentUserId)->first();
        //$dbPassword = $user['password'];
        $dbHashValue = $user->password;
        if (Hash::check($request->oldPassword, $dbHashValue)) {
            User::where('id', Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            //Auth::logout();
            // return redirect()->route('auth#loginPage')->with(['changeMessage'=>'password has changed.']);
            return back()->with(['changeMessage' => 'password has changed.']);
        }
        return back()->with(['notMatch' => 'the old password not match!']);
    }
    // direct admin detail page
    public function details()
    {
        return view('admin.account.details');
    }
    //direct admin profile page
    public function edit()
    {
        // Auth::user()->id;
        return view('admin.account.edit');
    }
    //update account
    public function update($id, Request $request)
    {
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);
        //for image
        if ($request->hasFile('image')) {
            $dbImage = User::where('id', $id)->first();
            $dbImage = $dbImage->image;
            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            // dd($fileName);
            $request->file('image')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }
        User::where('id', $id)->update($data);
        return redirect()->route('admin#details')->with(['updatedSuccess' => 'Admin account updated successful.']);
    }

    //admin list
    public function list()
    {
        $admin = User::when(request('key'), function ($query) {
            $query->orWhere('name', 'like', '%' . request('key') . '%')
                ->orWhere('gender', 'like', '%' . request('key') . '%')
                ->orWhere('email', 'like', '%' . request('key') . '%')
                ->orWhere('phone', 'like', '%' . request('key') . '%')
                ->orWhere('address', 'like', '%' . request('key') . '%');
        })
            ->where('role', 'admin')
            ->paginate(3);
        $admin->appends(request()->all());
        return view('admin.account.list', compact('admin'));
    }
    // admin delete
    public function delete($id)
    {
        User::where('id', $id)->delete();
        return back()->with(['deleteSuccess' => "delete success"]);
    }
    //admin change role
    public function changeRole($id)
    {
        $account = User::where('id', $id)->first();
        return view('admin.account.changeRole', compact('account'));
    }
    //admin change
    public function change($id, Request $request)
    {
        $data = $this->requestUserData($request);
        User::where('id', $id)->update($data);
        return redirect()->route('admin#list');
    }
    //requestUserData
    private function requestUserData($request)
    {
        return [
            'role' => $request->role
        ];
    }
    //account validation check
    private function accountValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'image' => 'mimes:png,jpg,jpeg|file'
        ], [])->validate();
    }
    //get user(admin) account data
    private function getUserData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_at' => Carbon::now(),
        ];
    }
    //password validation check
    private function passwordValidationCheck($request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ], [])->validate();
    }
}
