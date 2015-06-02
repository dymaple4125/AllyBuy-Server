<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PrizeAction extends CommonAction{
    
    public function index(){
        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }
    
    
    public function viewall(){
        
        //prize model instance
        $prize_list    =   M('prize')   ->table(array('zebra_user'=>'user', 'zebra_service'=>'service', 'zebra_prize'=>'prize'))
                                        ->field('prize.*, user.nick_name, user.email, service.title')
                                        ->where("prize.user_id=user.user_id "
                                                . "AND prize.service_id=service.service_id")
                                        ->select();
                
        $prize_list =   $prize_list!=NULL? $prize_list: array();
        
        $data_array =   array('data'=>$prize_list);

        //以JSON数据格式返回
        $this->ajaxReturn($data_array,'JSON');
    }
    
    public function view(){
        
        //prize model instance 
        $db =   M('prize');
        
        //get user id
        $user_id    =   I('user_id', '', 'htmlspecialchars');
        
        //get service id list
        $result =   $db ->field('service_id')
                        ->where("user_id=$user_id")
                        ->select();
        
        //return to format JSON
        $this->ajaxReturn($result, 'JSON');
    }
    
    //accept to get award
    public function accept(){
        
        $prize_db   =   M('prize');
        $user_db    =   M('user');   
        
        $user_id        =   I('user_id', '', 'htmlspecialchars');
        $service_id     =   I('service_id', '', 'htmlspecialchars');
        $phone          =   I('phone', '', 'htmlspecialchars');
        $address        =   I('address', '', 'htmlspecialchars');
        
        //echo 'abc';
        //update prize data make it active
        $data   =   array('phone'=>$phone, 'address'=>$address, 'status'=>1);
        //update data
        if(!$prize_db->where("user_id=$user_id AND service_id=$service_id")->save($data))
            $this->ajaxReturn (msg("接受礼品时发现错误"));
        
        //user information data
        $data   =   array('phone'=>$phone, 'address'=>$address);
        //update user information
        if(!$user_db->where("user_id=$user_id")->save($data))
            $this->ajaxReturn(msg("更新用户电话地址出错"));
        
        $this->ajaxReturn('接受礼品成功', '1', 'success');
        
    }
    
    //discard the award
    public function discard(){
        
        //model prize instance
        $db =   M('prize');
        
        $user_id        =   I('user_id', '', 'htmlspecialchars');
        $service_id     =   I('service_id', '', 'htmlspecialchars');
        
        //delete data from prize list
        if(!$db->where("user_id=$user_id AND service_id=$service_id")->delete())
            $this->ajaxReturn (msg("放弃礼品是发生错误"));
        
        //return successful message
        $this->ajaxReturn('放弃礼品成功', '1', 'success');
        
    }
    
}