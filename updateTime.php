<?php
    require_once('module/check.php');
    //session_start();
    $state = 1; //登录
    require_once('module/config.php');
    require_once('header.php');
    require_once('module/type.php');

?>
<?php

    $tid = $_GET['tid'];
    $updateSQL = "select * from tb_tm where id =  ".$tid;
    /*$result = querySql($updateSQL);
    $rows = $result->fetch_assoc();*/
    $result = $Q->execute($updateSQL);
    $rows = mysql_fetch_assoc($result);
?>
<?php
require_once('module/editor.php');
?>

    <div class="q_form">
        <fieldset>
            <legend>日报修改</legend>
            <form action="module/doTime.php?op=1" method="POST">
                <!--<div class="q_dv">
                    <label class="q_field">昵称：</label>
                    <input type="text" class="q_ipt q_readonly" name="nickname" value="<?php echo $rows['nickname'] ?>" readonly="readonly"/>
                </div>-->
                <input type="hidden" class="q_ipt q_readonly" name="nickname" value="<?php $nickname ?>" readonly="readonly"/>
                <div class="q_dv">
                    <label class="q_field">日期：</label>
                    <input type="date" class="q_ipt" value="<?php echo $rows['dateTime'] ?>" name="dateTime"/>
                </div>
                <!--<div class="q_dv">
                    <label class="q_field">组：</label>
                    <select name="mgroup">
                        <?php
                        	foreach( $typeArray as $key => $value){
                        		if( $value[0] == $rows['mgroup'] ){
                        ?>
                            <option value="<?php echo $value[0]; ?>" selected = "selected"><?php echo $value[0]; ?></option>
                        <?php
                            }else{
                        ?>
                            <option value="<?php echo $value[0]; ?>"><?php echo $value[0]; ?></option>
                        <?php	}
                       } ?>
                    </select>
                </div>-->
                <div class="q_dv">
                    <label class="q_field">内容：</label>
                    <!--<textarea class="q_area" name="content"><?php echo $rows['mcontent'] ?></textarea>-->
                    <textarea name="content" class="editor"><?php echo $rows['mcontent'] ?></textarea>
                </div>
                <div class="q_dv">
                    <label class="q_field">任务总时间：</label>
                    <input type="text" class="q_ipt m_time" name="totalTime" value="<?php echo $rows['totalTime'] ?>"/>(小时/H)
                </div>
                <div class="q_do">
                    <input type="hidden" name="id" value="<?php echo $rows['id'] ?>"/>
					<input type="hidden" name="typeForm" value="update"/>
                    <input type="submit" value="修改日报" class="q_submit"/>
                </div>
            </form>
        </fieldset>
    </div>
<?php
    require_once('footer.php');
?>