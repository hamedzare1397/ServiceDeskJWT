<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Coefficient;

class RegisterController extends Controller
{
    protected $typeClass = 'register';
    public function index(Request $request)
    {
        $class = 'App\\Models\\'.Str::ucfirst($this->typeClass);
        $page = $request->query($this->typeClass.'-page', 1);
        $perPage = $request->query('perPage', 10);
        if ($request->user()->isAdmin) {
            return $class::query()
                ->with('news')
                ->paginate($perPage,'*',$this->typeClass.'-page',$page);
        }
    }

    public function edit(Request $request)
    {
        $coefficeint=$request->input('coefficeint');
        $yaerMonth=$request->input('yearMonth');
        $class = 'App\\Models\\'.Str::ucfirst($this->typeClass);
        $query = Register::query()
            ->rightJoin('states','states.id','=','registers.state_id')
            ->where('year_month','=',$yaerMonth);
        $query->with([
            'state',
            'coefficient'=>function($query) use ($coefficeint){
                $query->where('id','=',$coefficeint);
            },
            'news'
        ]);


//        $query->get();
        return $query->get();
    }

    public function store(Request $request)
    {
        $class = 'App\\Models\\'.Str::ucfirst($this->typeClass);
        $class::unguard();
        $stored=$class::create($request->all());
        $class::reguard();
        return $stored;
    }

    public function update(Request $request)
    {
        $class = 'App\\Models\\'.Str::ucfirst($this->typeClass);
        $class::unguard();
        $result=$class::find($request->id);
        $data = $request->except(['news','id', 'edit', 'show','deletedShow', 'deleted_at', 'created_at', 'updated_at', 'deleteShow']);
        if($result->update($data)){
            $class::reguard();
            return $result->refresh();
        }
        $class::reguard();
        return ['updated'=>false];
    }

    public function delete(Request $request)
    {
        $class = 'App\\Models\\'.Str::ucfirst($this->typeClass);
        $result=$class::find($request->id);
        if($result->delete()){
            return ['deleted' => true,];
        }
        return ['deleted'=>false];
    }
}
