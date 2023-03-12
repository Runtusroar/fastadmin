<?php
namespace app\home\controller;
use think\Controller;

class Person extends Controller{
    public function index(){
        return $this->fetch();
    }
}