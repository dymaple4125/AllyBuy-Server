<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginAction extends Action{

    public function _initialize(){

        if(isset($_SESSION['admin_id']) && isset($_SESSION['admin_name'])){
            $this->redirect('index/index');
        }

    }

    public function index(){
        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }

    public function verify(){
        import("ORG.Util.Image");
        Image::buildImageVerify(4, 5, 'png');
    }

    public function login(){

        if(!IS_POST) halt ("页面不存在");

        //get
        if(I('code', '', 'md5')!=session('verify')){
            $this->error('验证码错误');
        }

        $username   =   I('username');
        $password   =   I('password', '', 'md5');

        $admin   =   M('admin')->where(array('admin_name'=>$username))->find();

        if(!$admin || $admin['password']!= $password){
            $this->error('用户名密码错误');
        }

        if($admin['status']==0){
            $this->error('您的帐号还未激活');
        }

        $data   =   array(
            'admin_id'=>$admin['admin_id'],
            'login_time'=>date('Y-m-d H:i:s',time()),
            'login_ip'=>get_client_ip(),
        );

        //update data
        M('admin')->save($data);

        //write session
        session('admin_id', $admin['admin_id']);
        session('admin_name', $admin['admin_name']);
        session('login_time', date("Y-m-d H:i:s", $admin['login_time']));
        session('login_ip', $admin['login_ip']);

        //跳转
        $this->success('登陆成功', U('Index/index', '', ''));

    }

    public function register(){

        if(!IS_POST) halt('页面不存在');

        $data   =   array(
            'admin_name'=>I('username'),
            'password'=>I('password', '', 'md5'),
            'email'=>I('email'),
            'contact'=>I('contact')
        );

        $admin_name =   $data['admin_name'];
        $email  =   $data['email'];

        if(M('admin')->where("admin_name='$name' || email='$email'")->find()){
            $this->error('注册的用户名或邮箱已经存在');
        }

        if($data['password']!=I('confirm_password', '', 'md5')){
            $this->error('确认密码和输入密码不符');
        }

        if(!M('admin')->add($data)){
            $this->error('注册不成功');
        }

        $this->success("注册新管理员成功，您需要批准通过后才可登陆", 'index');

    }


    //addadmin page
    public function add(){

        //display the add page
        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }

}
