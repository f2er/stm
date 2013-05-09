<?php
   //session_start();
   //$uid = $_SESSION['uid'];
   header("Content-Type:text/html;charset=utf-8");
   require_once('config.php');
   $opType = $_GET['op'];

    /*添加*/
   if( $opType == 1){
     $projectName = $_POST['projectName'];
     $projectColor = $_POST['projectColor'];
     $sql = "insert into tb_project (projectDesc,projectColor) values ('$projectName','$projectColor')";
     //echo $sql;
     header("Location:../todo.php");

   }
    $Q->execute($sql);
?>