<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('user.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        return [
            "data" => User::all()
        ];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = Validator::make($request->all(), [
                'name' => 'required',
                // 'role' => 'required|exists:roles',
                'email' => 'required|unique:users,email,' . $request->id,
            ], [
                'name.required' => 'Nama tidak boleh kosong',
                'role.required' => 'Role tidak boleh kosong',
                // 'role.exist' => 'Role tidak ditemukan',
                'email.required' => 'Email tidak boleh kosong',
                'email.unique' => 'Email sudah digunakan',
            ]);

            if ($data->fails()) {
                return response()->json([
                    'status' => false,
                    'error' => $data->getMessageBag()->toArray()
                ]);
            }
            $role = RoleUser::findOrFail($request->role);
            $user = User::updateOrCreate([
                'id' => $request->id
            ], [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password == null ? User::findOrFail($request->id)->password : Hash::make($request->password),
                'role_id' => $role->id
            ]);

            if ($request->id == null) {
                $user->attachRole($role);
            }
            return [
                'status' => true,
                'message' => 'Data berhasil disimpan',
            ];
        } catch (\Throwable $th) {
            return [
                'status' => true,
                'message' => 'Data gagal disimpan',
                "error" => $th
            ];
        }
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
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return [
            'status' => true,
            'message' => 'Data berhasil disimpan',
        ];
    }
}
