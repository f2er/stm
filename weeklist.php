<?php
    require_once('module/config.php');
    require_once('module/check.php');
    $uid = $_SESSION['uid'];
    $state = 1; //登录
    //$weekNum = date('W');
    //周报列表
    $wSQL = "select * from tb_week where  uid=".$uid." order by weeknum desc";
    $weekResult = $Q->execute($wSQL);
    $weekList = mysql_num_rows($weekResult);
    require_once('header.php');
?>

<div class="m_weekbox">
    <a href="weekmail.php?uid=<?php echo $uid;?>" class="m_write">写周报</a>
    <!--m_weeklist-->
    <ul class="todo_list m_weeklist">
        <?php while($rowsWeek = mysql_fetch_assoc($weekResult)) {?>
            <li><a href="sendMail.php?uid=<?php echo $uid;?>&week=<?php echo $rowsWeek['weeknum']?>" title="发送" class="send icon-direction"></a><a href="weekreport.php?uid=<?php echo $uid;?>&week=<?php echo $rowsWeek['weeknum']?>">第<?php echo $rowsWeek['weeknum']?>周</a></li>
        <?php }?>
    </ul>
    <!--/m_weeklist-->
</div>
<?php
require_once('footer.php');
?>