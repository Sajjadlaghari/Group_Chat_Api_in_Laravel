<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
   
    public function registration(Request $request)
    {

       
        $validator=Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        if($validator->fails())
        {
            $errors=$validator->errors();
            return response()->json(['error'=>$errors,'status'=>false]);
        }

        
        $user = User:: create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);

        if ($user->id) {
            return response()->json([
                'status' => true,
                'Data' =>$user
            ]);
        } else {
            return response()->json([
                'status' => false
            ]);
        }
        // dd(11);
        // Stock::create($request->all());
        // return redirect()->route('stocks.index')->with('success','Created Successfully.');
    }

    public function login_user(Request $request)
    {
        
        try {

            
          
          

        $login = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::get()->where('email', '=', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                
                Auth::attempt(['email' => $user->email, 'password' => $user->password]);
                return response()->json(['status' => true,'Data'=>$user]);
            } else {
                return response()->json(['error' => 'Password Did Not Match','status'=>false]);

            }
        } else {
            return response()->json(['error' => 'Record not found with this email','status'=>false]);
        }
    }
    catch (\Exception $e) {
          
        return $e->getMessage();
    }
    }


    public function get_users()
    {
        $users = User::get();
        return $users;
    }

    public function delete_users($id)
    {

        if ($users = User::find($id)->delete($id)) {
            return response()->json([
                'status' => true
            ]);
        } else {
            return response()->json([
                'status' => false
            ]);
        }
    }

    public function update_users(Request $request, $id)
    {
        // dd($request->post());
        $users = User::find($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
            'age' => 'required',
        ]);
        $users->name = $request['name'];
        $users->email = $request['email'];
        $users->address = $request['address'];
        $users->age = $request['age'];

        if ($users->save()) {
            return response()->json([
                'status' => true
            ]);
        } else {
            return response()->json([
                'status' => false
            ]);
        }
    }

    // public function edit(Stock $stock)
    // {
    //     return view('stocks.edit',compact('stock'));
    // }

    // public function update(Request $request, Stock $stock)
    // {
    //     $request->validate([
    //         'product_name' => 'required',
    //         'product_desc' => 'required',
    //         'product_qty' => 'required',
    //     ]);

    //     $stock->update($request->all());
    //     return redirect()->route('stocks.index')->with('success','Updated Successfully.');
    // }


    // public function destroy(Stock $stock)
    // {
    //     $stock->delete();
    //     return redirect()->route('stocks.index')->with('success','Student deleted successfully.');
    // }

}
