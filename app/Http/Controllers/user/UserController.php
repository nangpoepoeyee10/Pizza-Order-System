<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //user home
    public function home()
    {
        $pizza = Product::orderBy('created_at', 'desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $history = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('pizza', 'category', 'cart', 'history'));
    }
    public function changePasswordPage()
    {
        return view('user.password.change');
    }
    public function contactCreatePage()
    {

        return view('user.contact.create');
    }
    public function contactCreate(Request $request)
    {
        $this->contactValidationCheck($request);
        $data = $this->requestContactData($request);
        Contact::create($data);
        return redirect()->route('user#home');
    }
    private function contactValidationCheck($request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',

        ], [])->validate();
    }
    private function requestContactData($request)
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ];
    }
    public function contactList()
    {
        $con = Contact::get() ;
            // dd($con);
        // $con->appends(request()->all());
        return view("admin.contact.list", compact("con"));
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
    //account Change Page
    public function accountChangePage()
    {
        return view('user.profile.account');
    }
    //account Change
    public function accountChange($id, Request $request)
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
            $request->file('image')->storeAs('public', $fileName); //store in local
            $data['image'] = $fileName; // store in database
        }
        User::where('id', $id)->update($data);
        return back()->with(['updatedSuccess' => 'Admin account updated successful.']);
    }
    //filter pizza
    public function filter($categoryId)
    {
        $pizza = Product::where('category_id', $categoryId)->orderBy('created_at', 'desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id', Auth::user()->id)->get();
        $history = Order::where('user_id', Auth::user()->id)->get();
        return view('user.main.home', compact('pizza', 'category', 'cart', 'history'));
    }
    // direct pizzaDetails
    public function pizzaDetails($pizzaId)
    {
        $pizza = Product::where('id', $pizzaId)->first();
        $pizzaList = Product::get();
        return view('user.main.details', compact('pizza', 'pizzaList'));
    }
    //history page
    public function history()
    {
        $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate('6');
        return view('user.main.history', compact('order'));
    }
    //passwordValidationCheck
    private function passwordValidationCheck($request)
    {
        Validator::make($request->all(), [
            'oldPassword' => 'required|min:6',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|min:6|same:newPassword',
        ], [])->validate();
    }
    //cartList
    public function cartList()
    {
        $cartList = Cart::select('carts.*', 'products.name as pizza_name', 'products.price as pizza_price', 'products.image as pizza_image')
            ->leftJoin('products', 'products.id', 'carts.product_id')
            ->where('user_id', Auth::user()->id)
            ->get();
        $totalPrice = 0;
        foreach ($cartList as $c) {
            $totalPrice += $c->pizza_price * $c->qty;
        }
        return view('user.main.cart', compact('cartList', 'totalPrice'));
    }
    //user list
    public function userList()
    {
        $user = User::where('role', 'user')->paginate(3);
        return view("admin.user.list", compact("user"));
    }
    //update user
    public function editUser($id)
    {
        $user = User::where('id', $id)->first();
        return view('admin.user.edit', compact('user'));
    }
    public function updateUser($id, Request $request)
    {
        $data = $this->requestUserData($request);
        User::where('id', $id)->update($data);
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
        return redirect()->route('admin#userList')->with(['updatedSuccess' => 'Admin account updated successful.']);
    }
    private function requestUserData($request)
    {
        return [
            'role' => $request->role
        ];
    }
    //delete user
    public function deleteUser($id)
    {
        User::where('id', $id)->delete();
        return back()->with(['deleteSuccess' => 'delete success']);
    }
    //userChangeRole
    public function userChangeRole(Request $request)
    {
        $updateSource = [
            'role' => $request->role
        ];
        User::where('id', $request->userId)->update($updateSource);
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
            'image' => 'mimes:png,jpg,jpeg,jfif,webp|file'
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
}
