<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\CustomeAction;
use App\Models\EmployeeAssgin;
use App\Models\Log;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomersController extends Controller
{
    public function index() {
        $customer_action = CustomeAction::get();
        $role = Auth::user()->role->title;

        if($role == 'Admin') {
	        $customer_role_id = Role::where('title', 'Customer')->first()->id;         //get role_id for customer
    	    $customer_employee = User::where('role_id', $customer_role_id)->get();      //get all data of all customer
        } elseif ($role == 'Employee') {
            $employee_role_id = Auth::user()->id;                                         //employee id
            $customers_id = EmployeeAssgin::where('employee_id', $employee_role_id)->get('customer_id'); //get all customers of employee
            $customer_employee = User::whereIn('id', $customers_id)->get();
        }


        return view('customer.index')->with([
        	'customers' => $customer_employee,
        	'customer_action' => $customer_action,
        ]);
    }

    public function create() {

        $role = Auth::user()->role->title;

        if($role == 'Admin') {
	        $employee_role_id = Role::where('title', 'Employee')->first()->id; //role_id for employee
    	    $employees = User::where('role_id', $employee_role_id)->get()->toArray(); //get all data of all employee
        } elseif ($role == 'Employee') {
            $employee_role_id = Auth::user()->id;
            $employees = User::where('id', $employee_role_id)->get()->toArray(); //get all data of all employee
        }

        return view('customer.create')->with(['user' => Auth::user(),'employees' => $employees]);
    }

    public function store(CustomerRequest $request) {

        $customer_role_id = Role::where('title', 'Customer')->first()->id;
        $customer = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $customer_role_id,
        ]);

        $user = User::find(Auth::user()->id);
        $role = $user->role->title;

        // Assignation section
        $EmployeeAssign = new EmployeeAssgin();
        $assign_to_employee = null;

        if($role == 'Admin') {
	        $EmployeeAssign->employee_id = $request->assignation_employee_id;
	        $assign_to_employee = User::find($request->assignation_employee_id);
        } elseif ($role == 'Employee') {
	        $EmployeeAssign->employee_id = $user->id;
	        $assign_to_employee = User::find($user->id);
        }
        $EmployeeAssign->customer_id = $customer->id;
        $EmployeeAssign->save();

        // Log section
        $user_log = new Log();
        $user_log->user_id = Auth::user()->id;
        $user_log->action_name = 'Create Customer';
        $user_log->payload = "
        	Customer ID (" . $customer->id . ") -
        	Customer name: (" . $customer->name . ")
        	Assigned to Employee ID (". $assign_to_employee->id . ") -
        	Employee name: (". $assign_to_employee->name . ")
        ";
        $user_log->save();
        return redirect()->route('home');
    }


}
