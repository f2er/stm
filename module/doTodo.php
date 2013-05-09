<?php
   session_start();
   $uid = $_SESSION['uid'];
   header("Content-Type:text/html;charset=utf-8");
   require_once('config.php');
   $opType = $_GET['op'];

    /*添加*/
   if( $opType == 1){
     $content = $_POST['todoContent'];
     $projectId = $_POST['projectid'];
     $todoDesc = $_POST['todoDesc'];
     $weeknum = $_POST['weeknum'];

     $dateTime = date("Y-m-d");
     $sql = "INSERT INTO tb_todo (uid,content,status,dateTime,projectID,todoDesc,weekNum) VALUES ($uid,'$content',0,'$dateTime',$projectId,'$todoDesc',$weeknum)";
     header("Location:../todo.php");
   }

   /*完成*/
   if( $opType == 2){
        $completeJson = array();
       $id = $_GET['id'];
       $dateTime = date("Y-m-d");
       $sql = "update tb_todo set status = 1,dateTime = '$dateTime' where id ='".$id."'";
       $completeJson['code'] = 100;
       //header("Location:../todo.php");
       echo json_encode($completeJson);
   }
    /*删除*/
    if( $opType == 0){
        $deleteJson = array();
        $id = $_GET['id'];
        $sql = "delete  from tb_todo where id = '".$id."'";
        $deleteJson['code'] = 100;
        echo json_encode($deleteJson);
        //header("Location:../todo.php");
    }

    $Q->execute($sql);
?>