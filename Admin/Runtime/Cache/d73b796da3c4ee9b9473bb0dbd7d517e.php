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

               //brand action
               $('#submit_btn').click(function(e){

                   var brand_name =   $("input[name=brand_name]");
                   var brand_desc =   $("input[name=brand_desc]");

                   if(brand_name.val()==''){
                       alert('brand name不能为空');
                       brand_name.focus();
                       return;
                   }

                   if(brand_desc.val()==''){
                       alert('brand desc不能为空');
                       brand_desc.focus();
                       return;
                   }

                   $.post("<?php echo U('insert', '', '');?>",{brand_name:brand_name.val(), brand_desc:brand_desc.val()},function(data){
                        //add fail
                        if(data['status']==0){
                            $('#alert_fail').html("添加《"+brand_name.val()+"》不成功，请再试");
                            $('#alert_fail').attr('hidden', false);
                        }
                        //add success
                        else if(data['status']==1) {
                            $('#alert_success').html("添加《"+brand_name.val()+"》成功");
                            $('#alert_success').attr('hidden', false);
                            brand_name.val('');
                            brand_desc.val('');
                        }

                   }, 'json');
               });

               $('input').focus(function(e){
                   $('#alert_fail').attr('hidden', true);
                   $('#alert_success').attr('hidden', true);
               });

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
                        <li><a href="<?php echo U('index');?>">Brand</a></li>
                        <li class="active">add</li>
                    </ol>
                    <div id="alert_fail" class="alert alert-danger" hidden role="alert">没有插入成功</div>
                    <div id="alert_success" class="alert alert-success" hidden role="alert">插入成功</div>
                    <div class="form-group">
                      <label for="brandInput">Brand Name</label>
                      <input type="text" class="form-control" id="brand_name_input" name="brand_name" placeholder="Add a new brand name">
                    </div>
                    <div class="form-group">
                      <label for="brandInput">Brand Description</label>
                      <input type="text" class="form-control" id="brand_name_input" name="brand_desc" placeholder="Add a short description for brand">
                    </div>
                    <button id="submit_btn" class="btn btn-default">Submit</button>
                </div>
            </div>
        </div>
    </body>
</html>