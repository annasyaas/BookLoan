<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
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
        $users = User::with('members')->get();

        foreach($users as $user){
            if($user['is_admin'] == 1){
                $user['is_admin'] = 'Admin';
            }else{
                $user['is_admin'] = 'Member Biasa';
            }
        }

        return view('dashboard.users.index', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $members = Member::all();

        return view('dashboard.users.create', [
            'members' => $members
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $request['password'] = bcrypt($request['password']);
        
        if($request['is_admin']){
            $request['is_admin'] = 1;
        }else{
            $request['is_admin'] = 0;
        }

        // ubah request jadi array
        $request = $request->toArray();
        // dd($request);
        User::create($request);

        return redirect()->route('user.index')->with('success', 'Data User berhasil disimpan.');
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
        $user = User::find($id);
        $members = Member::all();
        
        return view('dashboard.users.edit', [
            'user' => $user,
            'members' => $members
        ]);
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
        $user = User::find($id);

        //jika username baru dan lama sama, maka validasi request
        if($request['username'] != $user->username){
            $request->validate([
                'username' => 'required|unique:users'
            ]);
        }
        //enkripsi password
        $request['password'] = bcrypt($request['password']);

        //cek jika ada atribut is_admin maka atribut admin bernilai 1
        if($request['is_admin']){
            $request['is_admin'] = 1;
        }else{
            $request['is_admin'] = 0;
        }

        //mengubah request object menjadi array
        $request = $request->except('_method', '_token');

        User::where('id', $id)->update($request);

        return redirect()->route('user.index')->with('success', 'Data User berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(User::destroy($id)){
            return redirect()->route('user.index')->with('success', 'Data User berhasil dihapus.');
        }else{
            return redirect()->route('user.index')->with('failed', 'Data User gagal dihapus.');
        }
    }
}
