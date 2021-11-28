<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $log  = Log::where('action_name', 'Create Customer')->get();
        $role_name = Role::get();
        $role_name = Auth::user()->role->title;

        return view('home')->with([
            'user' => $user,
            'log' => $log,
            'role_name' => $role_name
        ]);
        return view('home');
    }
}
