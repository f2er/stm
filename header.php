<?php
    session_start();
    require_once('module/config.php');
    $Q->newCon();
    $nickname = "";
    if( isset($_SESSION['uid'])){
        /*
		  * 权限管理
		  mike : 1
		*/
        $uid = $_SESSION['uid'];
        $uidSql = 'select nickname,ngroup,avatar from tb_user where id ="'. $uid .'"';
        //$nresult = querySql($uidSql);
        $nresult =$Q->execute($uidSql);
        $nrs = mysql_fetch_assoc($nresult);
        //$nrs = $nresult->fetch_assoc();
        $nickname = $nrs['nickname'];
        $ngroup = $nrs['ngroup'];
        $avatar = $nrs['avatar'];
        $Q->closeCon();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title><?php echo $ptitle ?></title>
    <link type="text/css" href="static/css/Q.css" rel="stylesheet"/>
    <link type="text/css" href="static/css/time.css" rel="stylesheet"/>
    <link href="static/css/typicons.css" rel="stylesheet"/>
    <link href="static/css/edit.css" rel="stylesheet"/>
</head>
<body>
<header class="header clearfix">
    <div class="wrapper">
    <?php
        if( $state == 1 ){
    ?>
    <div class="info">
        <span class="nickname"><img src="<?php echo $avatar; ?>" class="avatar"/><?php echo $nickname; ?></span>
        <div class="setting" id="j-setting">
            <span>个人资料</span>
            <ul class="dropdown" id="j-sdrop">
                <!--<li><a href="list.php?uid=<?php echo $uid ?>">日报管理</a></li>-->
                <li><a href="updatepwd.php">修改密码</a></li>
                <li><a href="version.php">版本记录</a></li>
                <li><a href="loginout.php" class="out">退出</a></li>
            </ul>
        </div>
    </div>
    <div  class="logo">STM</div>
    <ul class="nav clearfix">
        <li><a href="todo.php">Todo</a></li>
        <li><a href="tomatoClock.php">番茄时钟</a></li>
        <!--<li><a href="daily.php">日报管理</a></li>-->

       <!-- <li><a href="week.php"><?php echo $ngroup?>日报</a></li>-->
        <li  id="j-dropDown"><span>日记</span>
            <!--<span>
				<?php if( $uid == 1){ ?>
					部门日报
				<?php }else{?>
					<?php echo $ngroup ?>日报
				<?php }?>
			</span>-->
            <ol class="nlist" id="j-list">
                <li><a href="daily.php">写日记</a></li>
                <li><a href="list.php?uid=<?php echo $uid ?>">日记管理</a></li>
                <!--<li><a href="week.php?m=list">列表</a></li>
                <li><a href="week.php?m=visual">日报图形化</a></li>-->
            </ol>
        </li>
        <li><a href="weeklist.php">周记</a> </li>
    </ul>
    <?php }else{ ?>
        <div class="logo"><img src="static/images/daily_logo.png" width="187" height="48" alt=""/> </div>
    <?php } ?>
    </div>
</header>
