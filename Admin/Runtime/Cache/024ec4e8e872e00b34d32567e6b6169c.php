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
        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="__PUBLIC__/js/jquery/jquery-1.11.2.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="__PUBLIC__/js/bootstrap.min.js"></script>
        <!--load header or footer template -->
        <script>
            $(function(){
               
               //district action
               $('#submit_btn').click(function(e){
                   
                   var district_name =   $("input[name=district_name]");
                   var district_id   =   <?php echo ($district['district_id']); ?>;
                                     
                   if(district_name.val()==''){
                       alert('district name不能为空');
                       district_name.focus();
                       return;
                   }
                   
                   $.post("<?php echo U('update', '', '');?>",{district_id:district_id, district_name:district_name.val()},function(data){
                        //add fail
                        if(data['status']==0){
                            $('#alert_fail').html("更新《"+district_name.val()+"》不成功，请再试");
                            $('#alert_fail').attr('hidden', false);
                        }
                        //add success
                        else if(data['status']==1) { 
                            $('#alert_success').html("更新《"+district_name.val()+"》成功");
                            $('#alert_success').attr('hidden', false);
                        }
                       
                   }, 'json');
               });
        
               $('input').focus(function(e){
                   $('#alert_fail').attr('hidden', true);
                   $('#alert_success').attr('hidden', true);
               });
        
            });
            
            $(function(){
               
               $('#main_nav').load("__PUBLIC__/html/nav.html", function(){                     $('#admin_name').html("{$admin_name}，欢迎登陆Majorbox后台系统");                 });
               $('#side_nav').load("__PUBLIC__/html/basic.info.side.nav.html");
               
            });
        </script>
    </head>
    <body>
<!--        header-->
    <!--        header-->
        <div id="main_nav"></div>
        
        <div class="container-fluid">
            <div class="row">
                <div id="side_nav" class="col-sm-3 col-md-2 sidebar"></div> 
                
                <div class="col-sm-10 col-md-10 main">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo U('country/viewall', '', '');?>">country</a></li>
                        <li><a href="<?php echo U('district/viewall','country_id='.$district['country_id'], '');?>"><?php echo ($district['country_name']); ?></a></li>
                        <li class="active">view</li>
                    </ol>
                    <div id="alert_fail" class="alert alert-danger" hidden role="alert">没有插入成功</div>
                    <div id="alert_success" class="alert alert-success" hidden role="alert">插入成功</div>
                    <div class="form-group">
                        <label>District ID</label>
                        <p style="color: gray;">#<?php echo ($district['district_id']); ?></p>
                    </div>
                    <div class="form-group">
                        <label for="districtInput">District Name</label>
                        <p style="color: gray;"><?php echo ($district['district_name']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>