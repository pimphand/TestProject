<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class LaraTrustController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(20);
        return view('vendor.laratrust.panel.permissions.index', compact('permissions'));
    }
}
