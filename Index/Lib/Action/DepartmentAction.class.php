<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DepartmentAction extends Action{

    public function viewall(){

        //department model instance
        $db     =   M('department');

        //get university id from url
        $university_id  =   I('param.2');

        //get result data
        $result =   $db ->field("department_id, department_name")
                        ->where("university_id=$university_id")
                        ->order("department_id")
                        ->select();

        //以JSON数据格式返回
        $this->ajaxReturn($result,'JSON');

    }

}
