<?php
   header("Content-Type:text/html;charset=utf-8");
   require_once('module/check.php');
   //session_start();
   $uid = $_SESSION['uid'];
   $state = 1; //登录
   $ptitle = "我的日报";
   require_once('header.php');
   require_once('module/config.php');
   $nSql = "select * from tb_tm where uid=" .$uid. " order by dateTime desc";
   /*$list = querySql($nSql);
   $listLen = $list->num_rows; */
    $list = $Q->execute($nSql);
    $listLen = mysql_num_rows($list);
?>

    <div class="q_table" id="j-table">
        <p class="q_count">恭喜，你已经记录了<?php echo($listLen) ?>篇日报了～</p>
        <!--q_tlist-->
        <?php if($listLen>0){
		    while($rows = mysql_fetch_assoc($list)){
        ?>
        <div class="q_tlist">
            <header class="q_thd clearfix"><span class="total_time" title="总共:<?php echo $rows['totalTime']?>小时"><?php echo $rows['totalTime']?></span><?php echo $nickname ?>日报 <time><?php echo $rows['dateTime']?></time></header>
            <div class="q_tbd">
                <?php echo $rows['mcontent']?>
                <div class="q_topera"><a href="updateTime.php?uid=<?php echo $uid ?>&tid=<?php echo $rows['id']?>" class="edit_ico">编辑</a><a href="module/doTime.php?tid=<?php echo $rows['id']?>&op=0" class="delete_ico">删除</a></div>
            </div>
        </div>
        <?php
            }
        }else{
        ?>
            <div class="nodata"><?php echo "亲，没日报记录~" ?></div>
        <?php }
        ?>
        <!--/q_tlist-->
    </div>
<?php
    require_once('footer.php');
?>