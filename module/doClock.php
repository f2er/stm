<?php
   session_start();
   $uid = $_SESSION['uid'];
   header("Content-Type:text/html;charset=utf-8");
   require_once('config.php');
   $taskId = $_GET['taskId'];

    /*添加*/
   //if( $opType == 1){
    $content = $_POST['todoContent'];
    $clockJson = array();
     $sql = "INSERT INTO tb_clock (uid,taskid) VALUES ($uid,'$taskId')";
    $clockJson['code'] = 100;
    echo json_encode($clockJson);
      //header("Location:../tomatoClock.php");
  // }
    $Q->execute($sql);
?>