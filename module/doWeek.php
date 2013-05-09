<?php
   session_start();
    $uid = $_SESSION['uid'];
   header("Content-Type:text/html;charset=utf-8");
   require_once('config.php');

    /*添加*/
    $weekNum = $_POST['weeknum'];
    $workSummary = $_POST['worksummary'];
    $sql = "insert into tb_week (uid,weeknum,summary) values ($uid,$weekNum,'$workSummary')";

    $Q->execute($sql);
    header("Location:../weeklist.php");
?>