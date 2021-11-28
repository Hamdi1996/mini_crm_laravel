<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActionRequest;
use App\Models\CustomeAction;
use Illuminate\Http\Request;

class CustomerActionsController extends Controller
{
    public function actionName(ActionRequest $request) {

        $action = new CustomeAction();
        $action->actions = $request->action_name;
        $action->record = $request->record;
        $action->customer_id = $request->customer_id;
        $action->save();

        return response()->json(['success'=>'Your action Created successfully.']);
    }
}
