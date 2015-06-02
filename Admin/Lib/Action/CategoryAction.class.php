<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CategoryAction extends CommonAction{

    //index page
    public function index(){

        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }

    //view all category
    public function viewAll(){

        //get result
        $category_list =   M('category')->order('last_modify DESC')->select();

        $category_list    =   $category_list!=NULL? $category_list: array();

        $data_array =   array('data'=>  $category_list);

        //return as ajax
        $this->ajaxReturn($data_array);

    }

    //add category page
    public function add(){

        //display the add page
        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }

    //edit a category page
    public function edit(){

        //get category id
        $category_id =   I('category_id');

        //get category result
        $result =  M('category')->where("category_id=$category_id")->find();

        //display
        $this->assign('category', $result)->assign('admin_name', $_SESSION['admin_name'])->display();

    }


    //insert category record
    public function insert(){

        //avoid access except ajax
        if(!IS_AJAX) halt("页面错误");

        //create insert field
        $data   =   array(
            'category_name'=>I('category_name'),
            'category_desc'=>I('category_desc')
        );

        //insert data into database
        if(M('category')->data($data)->add())
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

        $category_id =   I('category_id');

        //create insert field
        $data   =   array(
            'category_name'=>I('category_name'),
            'category_desc'=>I('category_desc'),
            'last_modify'=>date('Y-m-d H:i:s',time())
        );

        //insert data into database
        if(M('category')->where("category_id=$category_id")->save($data))
        {
            $this->ajaxReturn(array('status'=>1));
        }
        //if insert data fail
        else
        {
            $this->ajaxReturn(array('status'=>0));
        }

    }

    //delete category record
    public function delete(){

        if(!IS_AJAX) halt("页面错误");

        //get category id
        $category_id =   I('category_id');

        //delete
        if(M('category')->where("category_id=$category_id")->delete())
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
