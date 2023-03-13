<?php
namespace app\common\validate;
use think\Validate;

// 用户验证器
class Business extends Validate{
    //验证规则
    protected $rule = [
        'mobile' => ['require', 'regex:/^1[3456789]{1}\d{9}$/', 'unique:business'],
        'gender' => 'number|in:0,1,2',
        'deal'   => 'number|in:0,1',
    ];

    //错误信息
    protected $message = [

    ];

    // 验证场景
    protected $scene = [
        // 新增验证
        'inset' => ['mobile'],

    ];
}