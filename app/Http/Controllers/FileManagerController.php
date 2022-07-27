<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    public static function member($image, $name, $oldName = null): void
    {
        if ($oldName) {
            Storage::delete('public/member/' . $oldName);
        }
        Storage::putFileAs("public/member", $image, $name);
    }
}
