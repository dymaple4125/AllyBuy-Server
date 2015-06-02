<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PromotionAction extends CommonAction{
    
    
    public function index(){
        
        $this->assign('admin_name', $_SESSION['admin_name'])->display();
    }
    
    //view all promotions
    public function viewAll(){
        
        //get result
        $promotion_list =   M('promotion')->select();
                
        $promotion_list   =   $promotion_list!=NULL? $promotion_list: array();
        
        $data_array =   array('data'=>  $promotion_list);
                
        //return as ajax
        $this->ajaxReturn($data_array);
        
    }
    
    
    //get edit page
    public function edit(){
        
        //get country id
        $promotion_id =   I('promotion_id');
        
        //get country result
        $result =  M('promotion')->where("promotion_id=$promotion_id")->find();
        
        //display
        $this->assign('promotion', $result)->assign('admin_name', $_SESSION['admin_name'])->display();
        

    }
    
    
    public function insert(){
       
        //create upload object
        $upload = createUploadObj(600000, './Public/Uploads/Promotion/', false);
        
        if (!$upload->upload()) {
           //捕获上传异常
           $this->error($upload->getErrorMsg());
        } 
        else {
           //取得成功上传的文件信息
           $uploadList = $upload->getUploadFileInfo();
          
           $data    =   array(
               'img'=>$uploadList[0]['savename']
           );
           
           if(M('promotion')->add($data)){
               $this->success('新建promotion成功', U('add', '', ''));
           }
           else
           {
               $this->error('新建promotion失败', U('add', '', ''));
           }
        }

    }
    
    public function update(){
        
        //get promotion id
        $promotion_id =   I('promotion_id');
        
        //create upload object
        $upload = createUploadObj(600000, './Public/Uploads/Promotion/', false);
        
        if (!$upload->upload()) {
           //捕获上传异常
           $this->error($upload->getErrorMsg());
        } 
        else {

           //取得成功上传的文件信息
           $uploadList = $upload->getUploadFileInfo();
           
          
           $data    =   array(
               'img'=>$uploadList[0]['savename']
           );
           
           if(M('promotion')->where("promotion_id=$promotion_id")->save($data)){
               $this->success('更新promotion成功', U('index', '', ''));
           }
           else
           {
               $this->error('更新promotion失败');
           }
        }
    }
    
    //delete service record
    public function delete(){
        
        if(!IS_AJAX) halt("页面错误");
        
        //get country id
        $promotion_id =   I('promotion_id');
        
        //delete
        if(M('promotion')->where("promotion_id=$promotion_id")->delete())
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