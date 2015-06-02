<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TagAction extends CommonAction{

    //index page
    public function index(){

        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }

    //view all tag
    public function viewAll(){

        //get result
        $tag_list =   M('tag')->order('last_modify DESC')->select();

        $tag_list    =   $tag_list!=NULL? $tag_list: array();

        $data_array =   array('data'=>  $tag_list);

        //return as ajax
        $this->ajaxReturn($data_array);

    }

    //add tag page
    public function add(){

        //display the add page
        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }

    //edit a tag page
    public function edit(){

        //get tag id
        $tag_id =   I('tag_id');

        //get tag result
        $result =  M('tag')->where("tag_id=$tag_id")->find();

        //display
        $this->assign('tag', $result)->assign('admin_name', $_SESSION['admin_name'])->display();

    }


    //insert tag record
    public function insert(){

        //avoid access except ajax
        if(!IS_AJAX) halt("页面错误");

        //create insert field
        $data   =   array(
            'tag_name'=>I('tag_name')
        );

        //insert data into database
        if(M('tag')->data($data)->add())
        {
            $this->ajaxReturn(array('status'=>1));
        }
        //if insert data fail
        else
        {
            $this->ajaxReturn(array('status'=>0));
        }
    }


    public function update(){

        if(!IS_AJAX) halt("页面错误");

        $tag_id =   I('tag_id');

        //create insert field
        $data   =   array(
            'tag_name'=>I('tag_name'),
            'last_modify'=>date('Y-m-d H:i:s',time())
        );

        //insert data into database
        if(M('tag')->where("tag_id=$tag_id")->save($data))
        {
            $this->ajaxReturn(array('status'=>1));
        }
        //if insert data fail
        else
        {
            $this->ajaxReturn(array('status'=>0));
        }

    }

    //delete tag record
    public function delete(){

        if(!IS_AJAX) halt("页面错误");

        //get tag id
        $tag_id =   I('tag_id');

        //delete
        if(M('tag')->where("tag_id=$tag_id")->delete())
        {
            $this->ajaxReturn(array('status'=>1));
        }
        //if delete fail
        else
        {
            $this->ajaxReturn(array('status'=>0));
        }
    }
}
