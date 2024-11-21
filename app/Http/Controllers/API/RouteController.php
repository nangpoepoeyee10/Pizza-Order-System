<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    //get data
   public function productList(){
    $prod = Product::get();
    return response()->json($prod ,200);
   }
   public function userList(){
    $user = User::get();
    return response()->json($user ,200);
   }
   public function contactList(){
    $con = Contact::get();
    return response()->json($con ,200);
   }
   public function order(){
    $ord = Order::get();
    return response()->json($ord ,200);
   }
   public function orderList(){
    $ordlist = OrderList::get();
    return response()->json($ordlist ,200);
   }
   public function cartList(){
    $cart = Cart::get();
    return response()->json($cart ,200);
   }
   //create category
   public function createCategory(Request $request){
    $data = [
        'name' => $request->name,
        'created_at'=>Carbon::now(),
        'updated_at' =>Carbon::now()
    ];
    $response =Category::create($data);
    return response()->json($response ,200);

   }
   public function createContact(Request $request){
    $data = [
        'name' => $request->name,
        'email'=>$request->email,
        'message' =>$request->message,
        'created_at'=>Carbon::now(),
        'updated_at' =>Carbon::now()
    ];
    $response =Contact::create($data);
    return response()->json($response ,200);

   }
   //delete category
   public function deleteCategory($id){
    $data =Category::where('id',$id)->first();
    if(isset($data)){
        Category::where('id',$id)->delete();
        return response()->json(['status'=>true ,'message'=>"delete success",'deleteData'=>$data],200);
    }
    return response()->json(['status'=>false ,'message'=>"There is no category.."],200);
   }
   //category details
   public function categoryDetails($id){
    $data =Category::where('id',$id)->first();
    if(isset($data)){
        return response()->json(['status'=>true ,'category'=>$data],200);
    }
    return response()->json(['status'=>false ,'category'=>"There is no category.."],500);

   }
   public function categoryUpdate(Request $request){
    $categoryID = $request->category_id;
    $dbSource = Category::where('id',$categoryID)->first();
    if(isset($dbSource)){
        $data =$this->getCategoryData($request);
        Category::where('id',$categoryID)->update($data);
        $response = Category::where('id',$categoryID)->first();
        return response()->json(['status'=>true ,'message'=>"category update success",'category'=>$response],200);
    }
    return response()->json(['status'=>false ,'message'=>"There is no category for update.."],500);

   }
   private function getCategoryData($request){
return [
    'name' =>$request->category_name,
    // 'created_at' =>Carbon::now(),
    'updated_at' =>Carbon::now()
];
   }
}
