<?php

namespace App\Http\Controllers;

use App\Imports\MembersImport;
use App\Models\Group;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();
        return view('member.index', compact('groups'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Json\JsonResponse
     */
    public function data(Request $request)
    {
        return [
            'data' => Member::all()
        ];
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
                'group_id' => 'required',
                'address' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'file' => 'required',
            ], [
                'name.required' => 'Nama tidak boleh kosong',
                'name.unique' => 'Nama sudah ada',
                'file.required' => 'Gambar tidak boleh kosong',
                'group_id.required' => 'Group tidak boleh kosong',
                'phone.required' => 'Phone tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
            ]);

            if ($data->fails()) {
                return response()->json([
                    'status' => false,
                    'error' => $data->getMessageBag()->toArray()
                ]);
            }

            if ($request->id != null && $request->file != null) {
                $member = Member::find($request->id);
                $imageName = Str::uuid();
                FileManagerController::member($request->file("file"), $imageName, $member->picture);
            } elseif ($request->id == null) {
                $imageName = Str::uuid();
                FileManagerController::member($request->file("file"), $imageName);
            } else {
                $imageName = Member::find($request->id)->picture;
            }
            Member::updateOrCreate([
                'id' => $request->id
            ], [
                'code' => rand(10, 99) . "-" . rand(100, 999) . "-" . rand(1000, 9999),
                'name' => $request->name,
                'group_id' => $request->group_id,
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'picture' => $imageName,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil ditambahkan',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
                'message' => 'Data gagal ditambahkan',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        Excel::import(new MembersImport, $request->file);

        return back()->with(['success' => "Import Member berhasil"]);
    }

    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return [
            "status" => true,
            "message" => "Data Berhasil dihapus"
        ];
    }
}
