<?php
$config['mail_provider'] = array(
    'protocol'=>'smtp',
    'smtp_host' => 'smtp.mandrillapp.com',
    'smtp_user'=>'handri.pangestiaji@yolkatgrey.com',
    'mailpath' => '/usr/sbin/sendmail',
    'charset' => 'UTF-8',
    'wordwrap' => TRUE,
    'smtp_pass' => 'b5o8j5YYJLGruu_q1zgLNg',
    'mailtype' => 'html',
    'smtp_port' => 587
);

$config['mail_provider_old'] = array(
    'protocol'=>'smtp',
    'smtp_host' => 'smtp.gmail.com',
    'smtp_user'=>'do-not-reply@maybk.co',
    'mailpath' => '/usr/sbin/sendmail',
    'charset' => 'UTF-8',
    'wordwrap' => TRUE,
    'smtp_pass' => '3mBBma!7',
    'mailtype' => 'html',
    'smtp_port' => 465
);


$config['mail_from'] = array(
    'name' => 'Maybank DCMS',
    'address' => 'do-not-reply@maybk.co',
    'cc' => 'benawv@gmail.com'
);