<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class PanelController extends Controller
{
    public function Panel()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route("FormLogin")->with('error', 'User not found');
        }
        return view('Panel.Main.main-part',compact('user'));
    }
}
