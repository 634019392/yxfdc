<?php
function treeLevel($data, $pid = 0, $html = '--', $level = 0)
{
    static $arr = [];

    foreach ($data as $val) {
        if ($pid == $val['pid']) {
            $val['html'] = str_repeat($html, $level * 2);
            $val['level'] = $level + 1;
            $arr[] = $val;
            treeLevel($data, $val['id'], $html, $val['level']);
        }
    }

    return $arr;

}