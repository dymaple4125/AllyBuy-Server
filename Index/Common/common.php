<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//display error,success,warning msg
function msg($msg, $code='0', $type='error'){
    return array(array('error'=>$type, 'error_code'=>$code, 'error_msg'=>$msg));
}

//use PHPMailer class to send mail
function sendMail($address, $title, $message){

    vendor('PHPMailer.class#phpmailer');

    $mail=new PHPMailer();
    // 设置PHPMailer使用SMTP服务器发送Email
    $mail->IsSMTP();

    // 设置邮件的字符编码，若不指定，则为'UTF-8'
    $mail->CharSet='UTF-8';

    // 添加收件人地址，可以多次使用来添加多个收件人
    $mail->AddAddress($address);

    // 设置邮件正文
    $mail->Body=$message;

    // 设置邮件头的From字段。
    $mail->From=C('MAIL_ADDRESS');

    // 设置发件人名字
    $mail->FromName=C('MAIL_SENDER');
    // 设置邮件标题
    $mail->Subject=$title;

    // 设置SMTP服务器。
    $mail->Host=C('MAIL_SMTP');
    $mail->Port=25;

    // 设置为“需要验证”
    $mail->SMTPAuth=true;

    // 设置用户名和密码。
    $mail->Username=C('MAIL_LOGINNAME');
    $mail->Password=C('MAIL_PASSWORD');

    // 发送邮件。
    return($mail->Send());
}

//get email conent string with email and token as info
function getMailContent($email, $token){

    $content    =   "Dear $email, Here is an verification Email from ZebraHK, we are so appreciated you join us."
                    ."<br>Please input the following verify code to bound your Email ."
                    ."<br>Verify Code:$token"
                    ."<br>After bound successfully, you can login your account with your email and password,Thanks"
                    ."尊敬的 $email，这是来自MajorBox的绑定邮箱确认邮件，感谢您加入我们，请输入正确的验证码并完成认证"
                    ."<br>验证码：$token"
                    ."<br>邮箱绑定成功后您可以使用您的邮箱及密码登陆";

    return $content;
}
