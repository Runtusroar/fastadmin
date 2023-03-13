<?php
namespace app\home\controller;
use think\Controller;
use think\Db;
use app\home\model\Business;
use think\Cookie;

class Index extends Controller
{
    //首页
    public function index()
    {
        return $this->fetch();
    }

    // 登录页面
    public function login(){
        // 登录逻辑
        if($this->request->isPost()){
            $params = $this->request->param();
            // 手机号不能为空
            if(empty($params['mobile'])){
                $this->error('手机号不能为空');
            }
            // 密码不能为空
            if(empty($params['password'])){
                $this->error('密码不能为空');
            }

            //判断该手机号是否存在
            $business = Business::where('mobile',$params['mobile'])->find();
            if(!$business){
                $this->error('用户不存在');
            }
            // 判断密码是否正确
            if($business['password'] != md5($params['password'])){
                $this->error('密码错误');
            }

            // 设置cookie
            $data = [
                'id'        => $business['id'],
                'mobile'    => $business['mobile']
            ];
            // 设置cookie前缀
            Cookie::prefix('fa_');
            Cookie::set('loginAuth',$data,3600*12);

            // 登录成功跳转
            $this->success('登录成功',url('home/index/index'));

        }

        $this->view->engine->layout(false);
        return $this->fetch();
    }

    //注册页面
    public function register(){
        // 注册逻辑
        if($this->request->isPost()){
            // 接受全部参数
            $mobile = $this->request->param('mobile','','trim');
            $password = $this->request->param('password','','trim');
            $repass = $this->request->param('repass','','trim');
            //判断两次密码是否一致
            if($password != $repass){
                $this->error('密码不一致');
            }
            // 对密码进行md5加密
            $password = md5($password);
            //获取客户资源id(用于判断该客服所处平台)
            $sourceid = Db::name('business_source')->where('name','云课堂')->value('id');
            //封装数据
            $data = [
                'mobile'    => $mobile,
                'password'  => $password,
                'sourceid'  => $sourceid,
                'deal'      => 0
            ];

            // 数据验证
            $result = $this->validate($data,'app\common\validate\Business.inset');
            if(true !== $result){
                $this->error($result);
            }

            // 将数据存入数据库
            $business = new Business();
            if($business->save($data)){
                $this->success('注册成功',url('home/index/login'));
            }else{
                $this->error('注册失败');
            }
        }


        // 不使用模板布局
        $this->view->engine->layout(false);
        return $this->fetch();
    }
}
