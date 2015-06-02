<?php
$config = array(
    // 'MAIL_ADDRESS'=>'admin@zebrahk.org', // 邮箱地址
    // 'MAIL_SMTP'=>'smtp.ym.163.com', // 邮箱SMTP服务器
    // 'MAIL_LOGINNAME'=>'admin@zebrahk.org', // 邮箱登录帐号
    // 'MAIL_PASSWORD'=>'dy65895492', // 邮箱密码
    // 'MAIL_SENDER'=>'MajorBox管理员', //发件人名字
    // 'MAIL_BOUND_TITLE'=>'MajorBox邮箱绑定验证',//Major Box bound email title
    // 'LOTTERY_ARRAY_SIZE'=>100,
    // 'SUCCESS'=>'success',
    // 'SECURE_CODE'=>'ZebraSecure',
);

return array_merge(require './Conf/config.php', $config);

?>
