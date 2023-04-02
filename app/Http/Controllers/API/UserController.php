<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::get();

        return response()->json([
            'status' => "success",
            'data' => $users
        ], 200);
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Sorry, user with id ' . $id . ' can not be found'
            ], 400);
        }

        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email',
            'is_permission'=>'required',
        ]);

        if($validator->fails()){
           
            return response()->json([
                "message" => "The given data was invalid.",
                "errors" => $validator->errors()
            ], 422);
  
        }



        $user = User::find($id);
        
        if (!$user || empty($user)) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user with id ' . $id . ' cannot be found'
            ], 400);
        }
         
        $user->name =  $request->get('name');
        $user->email = $request->get('email');
        $user->is_permission = $request->get('is_permission');
           
        $user->update();
        
        return response()->json([
            'status' => "success",
            'message' => 'User Updated Successfully!'
         ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user with id ' . $id . ' cannot be found'
            ], 400);
        }

        $user->delete();

        return response()->json([
            'status' => "success",
            'message' => 'User has been Deleted Successfully!'
         ], 200);
    }
}
