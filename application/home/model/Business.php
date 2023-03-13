<?php
namespace app\home\model;
use think\Model;

class Business extends Model{
    // 设置主键
    protected $pk = 'id';

    // 开启自动写入时间戳
    protected $autoWriteTimestamp = true;
    //自定义时间戳字段名
    protected $updateTime = false;
    protected $createTime = 'createtime';

}