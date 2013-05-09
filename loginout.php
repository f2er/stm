<?php
    //session_start();
    require_once('module/check.php');
    $old_login = $_SESSION['uid'];
    unset($_SESSION['uid']);
    session_destroy();
    $ptitle = "退出";
    require_once('header.php');
?>
<div class="tm_loginout">
    <?php
        if(!empty($old_login)){
            echo "恭喜你，退出!";
        }else{
            echo "囧，退出失败";
        }
        //echo "<script>setTimeout(function(){window.location='index.php'},1000);</script>"
    ?>
</div>
<?php
    require_once('footer.php');
?>