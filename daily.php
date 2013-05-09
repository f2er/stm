<?php
    require_once('module/check.php');
   // session_start();
    $uid = $_SESSION['uid'];
    $state = 1; //登录
    $ptitle = "日报管理";
    require_once('header.php');
    require_once('module/type.php');
    require_once('module/config.php');
    $gSQL = "select ngroup from tb_user where id =" .$uid;
    //$result = querySql($gSQL);
    $result = $Q->execute($gSQL);
   // if($result->num_rows>0){
    if( mysql_num_rows($result)>0){
        //$rs = $result->fetch_assoc();
        $rs = mysql_fetch_assoc($result) ;
        $ngroup = $rs['ngroup'];
    }

?>
<?php
  require_once('module/editor.php');
?>


<div class="q_form">
        <fieldset>
            <legend>写日报</legend>
            <form action="module/doTime.php?op=1" method="POST">
                <!--<div class="q_dv">
                    <label class="q_field">昵称：</label>
                    <input type="text" class="q_ipt q_readonly" name="nickname" value="qf" readonly="readonly"/>
                </div>-->
                <input type="hidden" class="q_ipt" name="nickname" value="<?php echo $nickname ?>"/>
                <input type="hidden" class="q_ipt" name="mgroup" value="<?php echo $ngroup ?>"/>
                <div class="q_dv">
                    <label class="q_field">日期：</label>
                    <input type="date" class="q_ipt" value="<?php echo date('Y/m/d H:i:s',time());?>" name="dateTime"/>
                </div>
                <!--<div class="q_dv">
                    <label class="q_field">组：</label>
                    <select name="mgroup" readonly = "readonly">
                        <?php
                        	foreach( $typeArray as $key => $value){
                        	    if( $value[0] == $ngroup ){
                        ?>
                            <option value="<?php echo $ngroup ?>" selected = "selected"><?php echo $value[0]; ?></option>
                        <?php
                           }else{
                        ?>
                        <option value="<?php echo $value[0]; ?>"><?php echo $value[0]; ?></option>
                        <?php }
                       } ?>
                    </select>
                </div> -->
                <div class="q_dv">
                    <label class="q_field">内容：</label>
                    <!--<textarea class="q_area" name="content"></textarea>-->
                    <textarea name="content" class="editor"></textarea>

                </div>
                <div class="q_dv">
                    <label class="q_field">任务总时间：</label>
                    <input type="text" class="q_ipt m_time" name="totalTime"/>(小时/H)
                </div>
                <div class="q_do">
					<input type="hidden" name="typeForm" value="add"/>
                    <input type="submit" value="提交日报" class="q_submit"/>
                </div>
            </form>
        </fieldset>
    </div>
<?php
    require_once('footer.php');
?>