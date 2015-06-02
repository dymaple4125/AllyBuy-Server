<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BrandAction extends CommonAction{

    //index page
    public function index(){

        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }

    //view all brand
    public function viewAll(){

        //get result
        $brand_list =   M('brand')->order('modified DESC')->select();

        $brand_list    =   $brand_list!=NULL? $brand_list: array();

        $data_array =   array('data'=>  $brand_list);

        //return as ajax
        $this->ajaxReturn($data_array);

    }

    //add brand page
    public function add(){

        //display the add page
        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }

    //edit a brand page
    public function edit(){

        //get brand id
        $brand_id =   I('brand_id');

        //get brand result
        $result =  M('brand')->where("brand_id=$brand_id")->find();

        //display
        $this->assign('brand', $result)->assign('admin_name', $_SESSION['admin_name'])->display();

    }


    //insert brand record
    public function insert(){

        //avoid access except ajax
        if(!IS_AJAX) halt("页面错误");

        //create insert field
        $data   =   array(
            'brand_name'=>I('brand_name'),
            'brand_desc'=>I('brand_desc')
        );

        //insert data into database
        if(M('brand')->data($data)->add())
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

        $brand_id =   I('brand_id');

        //create insert field
        $data   =   array(
            'brand_name'=>I('brand_name'),
            'brand_desc'=>I('brand_desc'),
            'modified'=>date('Y-m-d H:i:s',time())
        );

        //insert data into database
        if(M('brand')->where("brand_id=$brand_id")->save($data))
        {
            $this->ajaxReturn(array('status'=>1));
        }
        //if insert data fail
        else
        {
            $this->ajaxReturn(array('status'=>0));
        }

    }

    //delete brand record
    public function delete(){

        if(!IS_AJAX) halt("页面错误");

        //get brand id
        $brand_id =   I('brand_id');

        //delete
        if(M('brand')->where("brand_id=$brand_id")->delete())
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
