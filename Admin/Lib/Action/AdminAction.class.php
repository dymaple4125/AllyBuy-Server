<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AdminAction extends CommonAction{

    public function index(){
        $this->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();
    }

    //view alladmin
    public function viewAll(){

        //get result
        $admin_list   =   M('admin')->where('admin_id<>0')->select();

        $admin_list   =   $admin_list!=NULL ? $admin_list : array();
        
        $data_array =   array('data'=>$admin_list);

        //assingadmin list
        $this->ajaxReturn($data_array);

    }

    //confirm to pass the registration
    public function confirm(){

        $admin_id   =   I('admin_id');

        $admin  =   M('admin')->where(array('admin_id'=>$admin_id))->find();

        //check whether this has been approved
        if($admin['status']==1){
            $this->ajaxReturn(array('status'=>-1));
        }

        if(M('admin')->where(array('admin_id'=>$admin_id))->save(array('status'=>1)))
        {
            $this->ajaxReturn(array('status'=>1));
        }
        else
        {
            $this->ajaxReturn(array('status'=>0));
        }

    }

    //edit aadmin page
    public function edit(){

        //getadmin id
        $admin_id =   I('admin_id');

        //getadmin result
        $result =  M('admin')->where("admin_id=$admin_id")->find();

        //display
        $this->assign('admin', $result)->assign('admin_name', $_SESSION['admin_name'])->assign('admin_name', $_SESSION['admin_name'])->display();

    }


    //insertadmin record
    public function insert(){

        //avoid access except ajax
        if(!IS_AJAX) halt("页面错误");

        //create insert field
        $data   =   array(
            'admin_name'=>I('admin_name')
        );

        //insert data into database
        if(M('admin')->data($data)->add())
        {
            $this->ajaxReturn(array('status'=>1));
        }
        //if insert data fail
        else
        {
            $this->ajaxReturn(array('status'=>0), 'json');
        }
    }


    public function update(){

        if(!IS_AJAX) halt("页面错误");

        $admin_id =   I('admin_id');

        //create insert field
        $data   =   array(
            'admin_name'=>I('admin_name')
        );

        //insert data into database
        if(M('admin')->where("admin_id=$admin_id")->save($data))
        {
            $this->ajaxReturn(array('status'=>1));
        }
        //if insert data fail
        else
        {
            $this->ajaxReturn(array('status'=>0), 'json');
        }

    }

    //deleteadmin record
    public function delete(){

        if(!IS_AJAX) halt("页面错误");

        //getadmin id
        $admin_id =   I('admin_id');

        //delete
        if(M('admin')->where("admin_id=$admin_id")->delete())
        {
            $this->ajaxReturn(array('status'=>1));
        }
        //if delete fail
        else
        {
            $this->ajaxReturn(array('status'=>0));
        }
    }

    public function logout(){

        //destrop session
        session_unset();
        session_destroy();

        //redirect
        $this->success('您已经成功登出', U('login/index', '', ''));
    }

}
