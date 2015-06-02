<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PrizeAction extends Action{

    //get
    public function viewhistory(){

        //prize model instance
        $db     =   M('prize');

        //prize result
        $result =   $db ->table(array('zebra_prize'=>'prize', 'zebra_user'=>'user', 'zebra_service'=>'service'))
                        ->field('user.nick_name, service.title, service.category, prize.prize_time, prize.status')
                        ->where('prize.user_id=user.user_id '
                                . 'AND prize.service_id=service.service_id')
                        ->order('prize.prize_time DESC')
                        ->limit(20)
                        ->select();

        //以JSON数据格式返回
        $this->ajaxReturn($result,'JSON');
    }

    public function view(){

        //prize model instance
        $db =   M('prize');

        //get user id
        $user_id    =   I('param.2');

        //get service id list
        $result =   $db ->field('service_id, prize_time, status')
                        ->where("user_id=$user_id")
                        ->select();

        //return to format JSON
        $this->ajaxReturn($result, 'JSON');
    }

    //accept to get award
    public function accept(){

        $prize_db   =   M('prize');
        $user_db    =   M('user');

        $user_id        =   I('param.2');
        $service_id     =   I('param.3');
        $phone          =   I('post.phone');
        $address        =   I('post.address');

        //echo 'abc';
        //update prize data make it active
        $data   =   array('phone'=>$phone, 'address'=>$address, 'status'=>1);
        //update data
        if(!$prize_db->where("user_id=$user_id AND service_id=$service_id")->save($data))
            $this->ajaxReturn (msg("接受礼品时发现错误"));

        //user information data
        $data   =   array('phone'=>$phone, 'address'=>$address);
        //update user information
        $user_db->where("user_id=$user_id")->save($data);

        $this->ajaxReturn(msg(''));

    }

    //discard the award
    public function discard(){

        //model prize instance
        $db =   M('prize');

        $user_id        =   I('param.2');
        $service_id     =   I('param.3');

        //delete data from prize list
        if(!$db->where("user_id=$user_id AND service_id=$service_id")->delete())
            $this->ajaxReturn (msg("放弃礼品是发生错误"));

        //return successful message
        $this->ajaxReturn(msg(''));

    }

}
