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
        
        <script>
            
            function refresh_code(){
                $('#code_img').attr('src', "<?php echo U('verify', '', '');?>"+'/'+Math.random());
                return false;
            }
            
        </script>
        
    </head>
    <body>
        <div class="container">
        <form class="form-signin" action="<?php echo U('register', '', '');?>" method="POST">
            <h2 class="form-signin-heading">MajorBox管理员注册</h2>
            <div class="form-group">
                <label for="inputUsername">用户名</label>
                <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
            </div>
            <div class="form-group">
                <label for="inputPassword">密码</label>
                <input type="password" name="password"  class="form-control" placeholder="Password" required>
            </div>
            <div class="form-group">
                <label for="inputPassword">确认密码</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password" required>
            </div>
            <div class="form-group">
                <label for="inputPassword">邮箱</label>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="inputPassword">联系方式</label>
                <input type="text" name="contact" class="form-control" placeholder="Cell phone">
            </div>
            <button class="btn btn-lg btn-success btn-block" type="submit">注册</button>
            <a href="<?php echo U('login/index', '', '');?>">返回登陆</a>
        </form>
        </div>
        
        
    </body>
</html>