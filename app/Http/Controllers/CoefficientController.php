<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Pivots\CoefficientNews;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Coefficient;

class CoefficientController extends Controller
{
    protected $typeClass = 'coefficient';
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

    public function indexAll(Request $request)
    {
        /** @var Coefficient $coefficients */
        $coefficients = Coefficient::with(['news:id,name'])
            ->get(['name as title','id']);
        return $coefficients;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $coefficient = new Coefficient();
        $coefficient->name = $request->name;
        $coefficient->save();
        foreach ($request->typeNews as $item) {
            $news = News::find($item['id']);
            $coefficient->news()->save($news,[
                'coefficient'=>$item['coefficient'],
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }
        DB::commit();
        return $coefficient->news;
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
//        $request->dd();
        $class = 'App\\Models\\'.Str::ucfirst($this->typeClass);
        $class::unguard();
        /** @var Coefficient $coefficient */
        $coefficient=$class::find($request->id);
        $data = $request->except(['news','id', 'edit', 'show','deletedShow', 'deleted_at', 'created_at', 'updated_at']);

        ///// save Coefficient
        $coefficient->name=$request->name;
        $coefficient->update();

        // deleted ITem remove from coefficient_news
        /** @var Collection $deleted */
        $updateID=array_map(function ($row) {
            return $row['id'];
        }, $request->typeNews);
        $deleted=$coefficient->news()->get()->whereNotIn('id',$updateID);
        foreach ($deleted as $item) {
            $coefficient->news()->detach($item->id);
        }

        // update coefficient_news
        foreach ($request->typeNews as $item)
        {
            if (array_key_exists('news_id',$item)) {
                $arr = [
                    'news_id' => $item['news_id'],
                    'coefficient_id' => $item['coefficient_id'],
                    'coefficient' => $item['coefficient_id'],
                ];
                $result = CoefficientNews::query()->where('news_id', $item['news_id'])
                    ->where('coefficient_id', $item['coefficient_id'])
                    ->firstOrNew($arr);
                $result->update($arr);
            }
            else {
                $news = News::find($item['id']);
                $coefficient->news()->save($news,[
                    'coefficient' => $item['coefficient'],
                ]);
            }
        }
        DB::commit();
        return $coefficient->refresh()->load('news');
    }

    public function edit(Request $request,Coefficient $coefficient)
    {
        return $coefficient->news()->withPivot('coefficient')->get();
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        $class = 'App\\Models\\'.Str::ucfirst($this->typeClass);
        /** @var Coefficient $result */
        $result=$class::find($request->id);
        $result->news()->detach();
        if($result->deleteOrFail()){
            DB::commit();
            return ['deleted' => true,];
        }
        DB::rollBack();
        return ['deleted'=>false];
    }
}
