<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Auth;
use Session;
use Redirect;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $User = User::with(['createdBy','updatedBy'])->where('id','!=',Auth::user()->id)->get();
        return view('admin.user.index', compact('User'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'designation' => $request->input('designation'),
            'role' => $request->input('role'),
            'type' => $request->input('type'),
            'status' => $request->input('status'),
            'created_by' => Auth::user()->id
        ]);
        Session::flash('success', "Successfully Inserted");
        return Redirect::back();
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $User = User::find($id);
        return view('admin.user.edit', compact('User'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        if ($request->input('password')) {
            $password = Hash::make($request->input('password'));
        } else {
            $password = $request->input('old-password');
        }

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $password,
            'designation' => $request->input('designation'),
            'role' => $request->input('role'),
            'type' => $request->input('type'),
            'status' => $request->input('status'),
            'updated_by' => Auth::user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($request->input('2fa') == 1) {
            $data = [
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL
            ];
        }

        $sql = User::where('id', $id)->update($data);

        Session::flash('success', "Successfully Updated");
        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, UserRequest $request)
    {
        Session::flash('success', "Sorry");
        return Redirect::back();
    }
}
