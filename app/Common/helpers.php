<?php
/**
 * Created by PhpStorm.
 * User: wangluyu
 * Date: 2018/8/29
 * Time: 下午3:41
 */

function tree(array $list, int $pid = 0):array
{
    $tree = array();
    if (!empty($list)){
        foreach ($list as $key => $value) {
            if($value['pid'] == $pid){
                $tmp = $list[$key];
                unset($list[$key]);
//                tree($list,$value['id']) ? $tmp['children'] = tree($list,$value['id']) : null;
                $tmp['children'] = tree($list,$value['id']);
                $tree[] = $tmp;
            }
        }
    }
    return $tree;
}