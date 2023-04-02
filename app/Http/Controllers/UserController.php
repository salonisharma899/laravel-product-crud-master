<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;

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
        return view('users.index', compact('users'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        $roles = ["1" => "Admin", "0" => "User"];
        return view('users.edit', compact('user','roles'));
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
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'is_permission'=>'required',
        ]);

        $user = User::find($id);
         
        $user->name =  $request->get('name');
        $user->email = $request->get('email');
        $user->is_permission = $request->get('is_permission');
           
        $user->update();
        return redirect('/users')->with('success', 'User Updated Successfully!');
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
        $user->delete();

        return redirect('/users')->with('success', 'User has been Deleted Successfully!');
        
    }
}
