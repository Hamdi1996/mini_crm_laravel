<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeesController extends Controller
{
    public function index() {
        $employee_role_id = Role::where('title', 'Employee')->first()->id;
    	$employees = User::where('role_id', $employee_role_id)->get();

        return view('employee.index')->with(['employees' => $employees]);
    }

    public function create()
    {
        $user = User::find(Auth::user()->id);

        return view('employee.create',compact('user',$user));
    }

    public function store(EmployeeRequest $request)
    {
        $role_id  = Role::where('title', 'Employee')->first()->id;
        $employee = User::create([
            'name'=>$request->name, 
            'email'=>$request->email, 
            'password'=>Hash::make($request->password), 
            'role_id'=>$role_id
        ]);

        // Save users logs 
        $log = new Log;
        $log->user_id = Auth::user()->id;
        $log->action_name = 'Create employee';
        $log->payload = "Employee ID (". $employee->id . ") -Employee name: (". $employee->name . ")";
        $log->save();

        return redirect()->route('home');



    }

}
