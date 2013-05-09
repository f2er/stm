<?php
   session_start();
   $uid = $_SESSION['uid'];
   header("Content-Type:text/html;charset=utf-8");
   require_once('config.php');
   $opType = $_GET['op'];

   if( $opType==1 ){
       $typeForm = $_POST['typeForm'];

           //$nickname = $_POST['nickname'];
		  $_POST['content'] = str_replace("\r\n",'',$_POST['content']);
		  
		   foreach ($_POST as $_key => $_val){
			$_POST[$_key] = addslashes($_val);
			}
           $dateTime = $_POST['dateTime'];
           $group = $_POST['mgroup'];
           $content = $_POST['content'];
           $totalTime = $_POST['totalTime'];
       if( $typeForm == 'add'){
           $sql = "INSERT INTO tb_tm (uid,totalTime,mgroup,mcontent,dateTime) VALUES ($uid,$totalTime,'$group','$content','$dateTime')";
           header("Location:../list.php?uid=".$uid);
       }else if( $typeForm == 'update'){
            $id = $_POST['id'];
            $sql = "update tb_tm set uid = $uid, totalTime =  $totalTime, mgroup = '$group',mcontent='$content',dateTime = '$dateTime' where id ='".$id."'";
            header("Location:../list.php?uid=".$uid);
       }
   }else if( $opType == 0 ){
       $tid = $_GET['tid'];
       $sql = "delete  from tb_tm where id = '".$tid."'";
       header("Location:../list.php?uid=".$uid);

   }
    $Q->execute($sql);
   //querySql($sql);
?>