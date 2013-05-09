<?php
   require('phpmail_stm.php');
   $uid = $_GET['uid'];
   $week = $_GET['week'];
   sendMail($uid,$week);
?>
