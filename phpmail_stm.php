<?php
/**
 * Simple example script using PHPMailer with exceptions enabled
 * @package phpmailer
 * @version $Id$
 */

require 'class.phpmailer.php';
require 'class.smtp.php';


header("content-type:text/html;charset=utf-8");
//ini_set("magic_quotes_runtime",0);
/*
 * sendMail 发送邮件
 * */
function sendMail($uid,$week){
    $domain = "http://".$_SERVER['SERVER_NAME']."/xmf2e/stm/";

    $mail             = new PHPMailer();
    $body             = file_get_contents($domain.'weekreport.php?uid='.$uid.'&week='.$week);

    $mail->IsSMTP();
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    $mail->Port       = 465;                   // set the SMTP port
    $mail->CharSet = 'UTF-8';
    $mail->Username   = "uezheng@gmail.com";  // GMAIL username
    $mail->Password   = "xxx";            // GMAIL password

    $mail->From       = "uezheng@gmail.com";
    $mail->FromName   = "情封";
    $mail->Subject    = "前端组第".$week."周 周报(情封)";
    $mail->AltBody    = ""; //Text Body
    $mail->WordWrap   = 50; // set word wrap

    $mail->MsgHTML($body);

    $mail->AddReplyTo("uezheng@gmail.com","情封");

    $mail->AddAddress("zhengguobao@4399.com","情封");

    $mail->IsHTML(true); // send as HTML

    if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "恭喜您～周报发送成功～～";
    }
}
    ?>