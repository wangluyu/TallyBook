<?php

namespace App\Models;

class Partner extends Model
{
    /**
     * 不可被批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @desc 根据user_id获取['id'=>['name'=>'xxx','status'],.....]
     * @param int $user_id
     * @return array
     */
    public function getByUser(int $user_id):array
    {
        $return = [];
        $partner = self::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->get()->toArray();
        if(!empty($partner)) {
            foreach ($partner as $p) {
                $return[$p['id']] = $p;
            }
        }
        return $return;
    }
}
