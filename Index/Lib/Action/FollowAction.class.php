<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class FollowAction extends Action{

    public function viewall(){

        $db     =   M('follow');
        $result =   $db ->order('user_id')
                        ->select();

        //以JSON数据格式返回
        $this->ajaxReturn($result,'JSON');
    }

    //function for a user follow a major
    public function add(){

        //get user id
        $user_id    =   I('post.user_id');
        //get major id
        $major_id   =   I('post.major_id');

        $data = array(
            'user_id'=>$user_id,
            'major_id'=>$major_id
        );

        //insert success
        if(M('follow')->add($data)){
            $this->ajaxReturn(msg(""));
        }
        //insert fail
        else
        {
            $this->ajaxReturn(msg("添加专业失败"));
        }

    }

    public function delete(){

        $user_id    =   I('post.user_id');
        $major_id   =   I('post.major_id');

        if(M('follow')->where("user_id=$user_id and major_id=$major_id")->delete()){
            $this->ajaxReturn(msg(""));
        }
        else{
            $this->ajaxReturn(msg("取消关注专业失败"));
        }
    }


    //view followed majors for a specific user
    public function viewmajor(){

        //follow model instance
        $db =   M('follow');

        //get user id
        $user_id    =   I('param.2');

        //get followed major information based on user id
        $result =   $db ->table(array('zebra_major'=>'major','zebra_follow'=>'follow','zebra_department'=>'department','zebra_university'=>'university'))
                        ->field('major.major_id, major.major_name, major.deadline, department.department_name, university.university_name')
                        ->where("follow.major_id=major.major_id "
                                . "AND major.department_id=department.department_id "
                                . "AND department.university_id=university.university_id "
                                . "AND follow.user_id=$user_id")
                        ->select();

        //return format JSON
        $this->ajaxReturn($result);
    }

    //view following users for a specific major
    public function viewuser(){

        //follow model instance
        $db =   M('follow');

        //get major id
        $major_id   =   I('major_id');

        //get followed user information based on specific major id
        $result =   $db ->table(array('zebra_user'=>'user','zebra_follow'=>'follow'))
                        ->field('user.nick_name')
                        ->where("follow.user_id=user.user_id "
                                . "AND follow.major_id=$major_id")
                        ->select();

        //return format JSON
        $this->ajaxReturn($result);

    }



}
