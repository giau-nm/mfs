<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function __construct(Request $request)
    {
        
    }

    public function setMessage($request, $type, $messages)
    {
        $request->session()->flash('alertMessage', view('admin.errors.message')->with([
            'type' => $type,
            'messages' => $messages,
        ])->render());
    }

    public function getMessage($request)
    {
        $message = null;
        if ($request->session()->has('alertMessage')) {
            $message = $request->session()->get('alertMessage');
        }

        return $message;
    }

    public function checkValidator($data, $validators)
    {
        $rules = isset($validators['rules']) ? $validators['rules'] : [];
        $messages = isset($validators['messages']) ? $validators['messages'] : [];
        $attributes = isset($validators['attributes']) ? $validators['attributes'] : [];

        return validator($data, $rules, $messages, $attributes);
    }
}
