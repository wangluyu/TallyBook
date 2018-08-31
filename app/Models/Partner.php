<?php

namespace App\Models;

class Partner extends BaseModel
{
    /**
     * 不可被批量赋值的属性。
     *
     * @var array
     */
    protected $guarded = [];

    public function getIdByUser(int $user_id):array
    {
        $ids = [];
        $partners = self::where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->get()->toArray();
        if(!empty($partners)) {
            $ids = array_column($partners, 'id');
        }
        return $ids;
    }
}
