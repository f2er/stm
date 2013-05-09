<?php
    require_once('module/config.php');
    $state = 0; //未登录
    $ptitle = "登录";
    $loginTip = "";
    if( isset($_POST['email']) && isset( $_POST['pwd']) ){
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];
        $loginSql = "select id from tb_user where email = '$email' and pwd = '$pwd'";
        //$result = querySql($loginSql);
        $result = $Q->execute($loginSql);
        if( $result && mysql_num_rows($result)>0 ){
            session_start();
            //$rs = $result->fetch_assoc();
            $rs = mysql_fetch_assoc($result);
            $_SESSION['uid'] = $rs['id'];
            header("Location:todo.php?uid=$rs[id]");
        }else{
            $loginTip = "登录失败,帐号与密码不匹配";
        }
        /*if( $result && $result->num_rows >0 ){
            session_start();
            $rs = $result->fetch_assoc();
            $_SESSION['uid'] = $rs['id'];
            header("Location:daily.php?uid=$rs[id]");
        }else{
            $loginTip = "登录失败,帐号与密码不匹配";
        }*/
    }
    //require_once('header.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title><?php echo $ptitle ?></title>
    <link type="text/css" href="static/css/Q.css" rel="stylesheet"/>
    <link type="text/css" href="static/css/time.css" rel="stylesheet"/>
</head>
<body>
    <!--q_about-->
    <div class="mod_login_box">
        <div class="q_logo"></div>
        <fieldset class="mod_login_form">
            <legend>MrTime个人管理</legend>
            <div class="mod_login">
                <form action="index.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                    <div class="q_ltip"><?php echo $loginTip ?></div>
                    <div class="q_dv">
                        <input type="email" class="q_ipt" name="email" placeholder="4399邮箱"/>
                    </div>
                    <div class="q_dv">
                        <input type="password" name="pwd" class="q_ipt" placeholder="密码"/>
                    </div>
                    <div class="q_dbtn">
                        <input type="submit" class="q_btn"  value="登录"/>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>
    <!--/q_about-->


</body>
</html>