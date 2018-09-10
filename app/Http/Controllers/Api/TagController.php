<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\TagRequest;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function get()
    {
        $return = $this->return;
        try{
            $where_in = [0, $this->user_id];
            $tags = Tag::select('id', 'name', 'pid')->whereIn('user_id', $where_in)->get()->toArray();
            $return['data'] = tree($tags);
        }catch (\Exception $e) {
            $return['status'] = 400;
            $return['msg'] = $e->getMessage();
        }
        return $this->response->array($return);
    }

    public function store(TagRequest $request)
    {
        $return = $this->return;
        //事务开始
        DB::beginTransaction();
        try{
            $attributes = $request->only(['name', 'pid']);
            if(empty($this->user_id)){
                throw new \Exception();
            }
            $attributes['name'] = trim($attributes['name']);
            $attributes['user_id'] = $this->user_id;
            Tag::firstOrCreate($attributes);
            //提交事务
            DB::commit();
        }catch (\Exception $e) {
            //回滚
            DB::rollBack();
            $return['status'] = 400;
        }
        return $this->response->array($return);
    }

    public function update(TagRequest $request)
    {
        $return = $this->return;
        //事务开始
        DB::beginTransaction();
        try{
            $where = [
                'id'  =>  $request->id,
                'user_id'   =>  $this->user_id
            ];
            if(Tag::where($where)->doesntExist()){
                $return['msg'] = '无权限';
                throw new \Exception();
            }
            $where = [
                'name'  =>  $request->name,
                'user_id'   =>  $this->user_id
            ];
            if(Tag::where($where)->exists()){
                $return['msg'] = '该标签已存在';
                throw new \Exception();
            }
            $name = trim($request->name);
            $id = $request->id;
            Tag::where('id',$id)->update(['name'=>$name]);
            //提交事务
            DB::commit();
        }catch (\Exception $e) {
            //回滚
            DB::rollBack();
            $return['status'] = 400;
        }
        return $this->response->array($return);
    }

    public function delete(TagRequest $request)
    {
        $return = $this->return;
        //事务开始
        DB::beginTransaction();
        try{
            $id = $request->id;
            $where = [
                'id'  =>  $id,
                'user_id'   =>  $this->user_id
            ];
            if(Tag::where($where)->doesntExist()){
                $return['msg'] = '无权限';
                throw new \Exception();
            }
            Tag::destroy($id);
            //提交事务
            DB::commit();
        }catch (\Exception $e) {
            //回滚
            DB::rollBack();
            $return['status'] = 400;
        }
        return $this->response->array($return);
    }
}
