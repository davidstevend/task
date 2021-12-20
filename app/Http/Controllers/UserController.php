<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class UserController extends Controller
{
    public function __construct()
    {     
      $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       // $search = $request->search;


            $users = User::orderBy('id','desc')
            ->get();
           
        return $users; 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $User = new User;
        // $User->User                =  $request->User;
        // $User->description         =  $request->description;
        // $User->date                =  now();
        // $User->expiration_date     =  $request->expiration_date;
        // $User->user_id             =  Auth::user()->id;
        // $User->finished            =  $request->finished;
        // $User->save();

        // return "guardada";
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show(User $User)
    {
        return $User;        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $User)
    {
        // $User->update($request->all());

        // $Usera = User::find($User->id);
        // $Usera->User                =  $request->User;
        // $Usera->description         =  $request->description;
        // // $Usera->date                =  now();
        // $Usera->expiration_date     =  $request->expiration_date;
        // // $Usera->user_id             =  Auth::user()->id;
        // $Usera->finished            =  $request->finished;
        // $Usera->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $User)
    {
       
        $User->delete();
    }
}
