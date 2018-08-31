<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model
{
    /**
     * @desc 添加多条
     * @param array $data
     * @return mixed
     */
    public function createBatch(Array $data):array
    {
        $date = date('Y-m-d H:i:s');
        $table = $this->getTable();
        $ids = [];
        foreach ($data as $d){
            $d['created_at'] = $date;
            $d['updated_at'] = $date;
            $ids[] = DB::table($table)->insertGetId($d);
        }
        return $ids;
    }
}
