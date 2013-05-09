<?php
    //session_start();
    require_once('module/check.php');
    $uid = $_SESSION['uid'];
    $state = 1; //登录
    $ptitle = "修改密码";
    require_once('module/config.php');
    require_once('header.php');

?>
<?php
    if(!empty($_POST['opwd'])){
        $pwd = $_POST['pwd'];
        $updateSQL = "update tb_user set pwd = '$pwd' where id ='".$uid."'";
        //querySql($updateSQL);
        $Q->execute($updateSQL);
        echo "<script>setTimeout(function(){window.location='daily.php'},2000)</script>";
    }
?>

    <div class="q_form">
        <fieldset>
            <legend>密码修改</legend>
                <form action="updatepwd.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                   <?php echo $msg ?>
                   <div class="q_dv">
                        <label class="q_field">旧密码：</label>
                            <input type="password" class="q_ipt" name="opwd" value=""/>
                        </div>
                        <div class="q_dv">
                            <label class="q_field">新密码：</label>
                            <input type="password" class="q_ipt" value="" name="pwd"/>
                        </div>
                        <div class="q_do">
                            <input type="submit" value="修改" class="q_submit"/>
                        </div>
                    </form>
                </fieldset>
    </div>
<?php
    require_once('footer.php');
?>