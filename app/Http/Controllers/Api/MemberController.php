<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function show($id)
    {
        $data = Member::where('code', $id)->orWhere('id', $id)->first();
        return [
            "status" => true,
            "data" => $data
        ];
    }
}
