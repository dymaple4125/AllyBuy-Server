<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- 新 Bootstrap 核心 CSS 文件 -->
        <link rel="stylesheet" href="__PUBLIC__/css/bootstrap.min.css">
        <!-- 可选的Bootstrap主题文件（一般不用引入） -->
        <link rel="stylesheet" href="__PUBLIC__/css/bootstrap-theme.min.css">
        <!--加入zebra独有样式表-->
        <link rel="stylesheet" href="__PUBLIC__/css/zebra.css">
        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="__PUBLIC__/js/jquery/jquery-1.11.2.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="__PUBLIC__/js/bootstrap.min.js"></script>
        <!--load header or footer template -->
        <script>
            $(function(){
               
               //subject action
//               $('#submit_btn').click(function(e){
//                   
//                   var subject_name =   $("input[name=subject_name]");
//                   
//                   if(subject_name.val()==''){
//                       alert('subject name不能为空');
//                       subject_name.focus();
//                       return;
//                   }
//                   
//                   
//                   $.post("<?php echo U('insert', '', '');?>",{subject_name:subject_name.val()},function(data){
//                        //add fail
//                        if(data['status']==0){
//                            $('#alert_fail').html("添加《"+subject_name.val()+"》不成功，请再试");
//                            $('#alert_fail').attr('hidden', false);
//                        }
//                        //add success
//                        else if(data['status']==1) { 
//                            $('#alert_success').html("添加《"+subject_name.val()+"》成功");
//                            $('#alert_success').attr('hidden', false);
//                            subject_name.val('');
//                        }
//                       
//                   }, 'json');
//               });
//        
//               $('input').focus(function(e){
//                   $('#alert_fail').attr('hidden', true);
//                   $('#alert_success').attr('hidden', true);
//               });
        
            });
            
            $(function(){
               
                $('#main_nav').load("__PUBLIC__/html/nav.html", function(){
                    $('#admin_name').html("<?php echo ($admin_name); ?>，欢迎登陆猎购盟后台系统");
                });
            });
        </script>
    </head>
    <body>
<!--        header-->
        <div id="main_nav"></div>
<!--        content-->
        <div class="container-fluid">
            <div class="row">
                <div class="main">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo U('index');?>">Service</a></li>
                        <li class="active">edit</li>
                    </ol>
                    
                    <form method="POST" enctype="multipart/form-data" action="<?php echo U('update', '', '');?>">   
                        <div class="form-group">
                          <label>现在图片</label>
                          <img width="200" src="__ROOT__/public/uploads/promotion/<?php echo ($promotion['img']); ?>">    
                          <p>更改图片</p>
                          <input type="file" name="img">
                          <p class="help-block">上传一个thumb图像，最大不可超过600*1000，必须为PNG格式</p>
                        </div>
                        <input type="hidden" name="promotion_id" value="<?php echo ($promotion['promotion_id']); ?>">
                        <button id="submit_btn" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>