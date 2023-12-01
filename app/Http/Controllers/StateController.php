<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StateController extends Controller
{

    protected $typeClass = 'state';
    public function index(Request $request)
    {
        $class = 'App\\Models\\'.Str::ucfirst($this->typeClass);
        $page = $request->query($this->typeClass.'-page', 1);
        $perPage = $request->query('perPage', 10);
        return $class::query()->paginate($perPage,'*',$this->typeClass.'-page',$page);
    }
    public function indexAll(Request $request)
    {
        $class = 'App\\Models\\'.Str::ucfirst($this->typeClass);
        return $class::all();
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
        $data = $request->except(['id', 'edit', 'show', 'deleted_at', 'created_at', 'updated_at', 'deleteShow']);
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
