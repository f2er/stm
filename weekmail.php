<?php
    require_once('module/config.php');
    require_once('module/check.php');
    $uid = $_GET['uid'];
    if( empty($_GET['week'])){
        $weekNum = date('W');
    }else{
        $weekNum = $_GET['week'];
    }
    //已完成
    $pSQL = "select * from tb_todo todo,tb_project project where todo.projectID = project.projectID and uid =" .$uid ." and status = 1 and weekNum = ".$weekNum;
    $projectResult = $Q->execute($pSQL);
    $projectList = mysql_num_rows($projectResult);
    if($projectList<=0 ){
        $todoListNoData = "暂无完成任务";
    }else{
        while($rowsProject = mysql_fetch_assoc($projectResult)){
            $projectTaskList[$rowsProject['projectID']][] = $rowsProject;
        }
    }
   // $weekNum = date('W');
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
            <title>编写周报邮件</title>
            <link href="static/css/Q.css" rel="stylesheet"/>
            <link href="static/css/time.css" rel="stylesheet"/>
        </head>
        <body>
            <form action="module/doWeek.php" method="post">
            <!--mail_week-->
            <div class="mail_week">
                <header>
                    <h1>前端组情封周报<span style="margin-left:10px;">第<?php echo $weekNum; ?>周</span></h1>
                </header>

                <?php foreach( $projectTaskList as $v ){ ?>
                    <!--mail_box-->
                    <div class="mail_box">
                        <div class="hd">
                            <h2><?php echo $v[0]['projectDesc'] ?></h2>
                        </div>
                        <div class="bd">
                            <ul>
                                <?php foreach( $v as $task){ ?>
                                    <li><?php echo $task['content'] ?><?php echo $task['todoDesc'];?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <!--/mail_box-->
                <?php }?>
                <div class="mail_summary">
                    <h2>工作总结：</h2>
                    <textarea class="summary" name="worksummary"></textarea>
                </div>
                <input type="hidden" value="<?php echo $weekNum;?>" name="weeknum"/>
                <input type="submit" value="保存" class="btn_week"/>
            </div>
            <!--/mail_week-->
            </form>
        </body>
    </html>