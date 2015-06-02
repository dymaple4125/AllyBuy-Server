<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ServiceAction extends Action{

    //view all services
    public function viewAll(){

        $db     =   M('service');
        $result =   $db->order('category')->select();

        //以JSON数据格式返回
        $this->ajaxReturn($result,'JSON');
    }

    //user draw lottery
    public function draw(){

        //service model instance
        $service_db =   M('service');
        $prize_db   =   M('prize');
        $user_db    =   M('user');

        //get user id
        $user_id    =   I('param.2');

        $result  =   $user_db   ->where("user_id=$user_id")
                                ->getField('quota');

        if($result==0) $this->ajaxReturn (msg('您今天的机会已经用光啦，请明天再试'));


        //get all services and quota
        $result =   $service_db ->field('service_id, quota')
                        ->select();

        //create array for lottery
        $lottery_array	=	array();
        //counter to count lottery numbers
        $counter	=	0;

        //assign all result into rolling list
        foreach($result as $service){
            for($i=0;$i<$service['quota'];$i++){
                    $counter++;
                    array_push($lottery_array, $service['service_id']);
            }
        }

        //fill left positions
        for($i=$counter; $i<C('LOTTERY_ARRAY_SIZE'); $i++){
            $counter++;
            array_push($lottery_array,0);
        }


        //shuffle the array
        shuffle($lottery_array);

        //random 0-999 (array index)
        $index      =   mt_rand(0,C('LOTTERY_ARRAY_SIZE')-1);

        //get gift service id
        $service_id =   $lottery_array[$index];

        $prize_count    =   $prize_db   ->where("user_id=$user_id AND service_id=$service_id")
                                        ->count();

        //if already get the service, then return not get prize
        if($prize_count!=0) $service_id=0;

        //update service quota and insert value into prize table if user get any prize
        if($service_id!=0)
        {
            //update service quota if user get prize
            if(!$service_db->where("service_id=$service_id")->setDec('quota'))
                $this->ajaxReturn (msg('更新服务额度错误'));


            $data =   array('user_id'=>$user_id,'service_id'=>$service_id);
            //update prize table if user get prize
            if(!$prize_db->add($data))
                $this->ajaxReturn (msg('插入奖项队列错误'));
        }

        //update user quota whatever user get prize or not
        if(!$user_db->where("user_id=$user_id")->setDec('quota'))
            $this->ajaxReturn (msg('更新用户机会次数出错'));

        //get final service
        $result =   $service_db ->where("service_id=$service_id")
                                ->select();

        //return result as JSON
        $this->ajaxReturn($result);

    }

}
