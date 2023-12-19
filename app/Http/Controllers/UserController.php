<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function index(Request $request)
    {
        $page = $request->query('user-page', 1);
        $perPage = $request->query('perPage', 10);
        if ($request->user()->isAdmin) {
            return User::query()
                ->with('state')
                ->paginate($perPage,'*','user-page',$page);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username,'.$request->id,
            'firstname' => 'required',
            'lastname' => 'required',
            'password'=>'required'
        ]);
        DB::beginTransaction();
        $user = new User();
        $user->firstname=$request->firstname;
        $user->lastname=$request->lastname;
        $user->gender=$request->gender;
        $user->username=$request->username;
        $user->email=$request->email;
        $user->address=$request->address;
        $user->mobile=$request->mobile;
        $user->phone=$request->phone;
        $user->zipCode=$request->zipCode;
        $user->nativeid=$request->nativeid;
        $user->admin=$request->admin;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        if($user->save())
        {
            if ($request->filled('state')) {
                $state = State::find($request->state)->first();
                $user->state()->save($state);
            }
            DB::commit();
            return $user->refresh()->load('state');
        }
        DB::rollBack();
        return false;
    }
    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username,'.$request->id,
            'firstname' => 'required',
            'lastname' => 'required',
        ]);
        DB::beginTransaction();
        $user = User::find($request->id);
        $user->firstname=$request->firstname;
        $user->lastname=$request->lastname;
        $user->gender=$request->gender;
        $user->username=$request->username;
        $user->email=$request->email;
        $user->address=$request->address;
        $user->mobile=$request->mobile;
        $user->phone=$request->phone;
        $user->zipCode=$request->zipCode;
        $user->nativeid=$request->nativeid;
        $user->admin=$request->admin;
        if ($request->filled('state_id')) {
            $state = State::find($request->state_id);
            if (!is_null($state)){
                $user->state_id = $state->id;
            }
        }
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        if($user->save())
        {
            DB::commit();
            return $user->refresh()->load('state');
        }
        DB::rollBack();
        return false;
    }
}
