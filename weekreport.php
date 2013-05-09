<?php
    require_once('module/config.php');
    //require_once('module/check.php');
    $uid = $_GET['uid'];
    $weekNum = $_GET['week'];
    //已完成
    //$pSQL = "select * from tb_todo todo,tb_project project where todo.projectID = project.projectID and uid =" .$uid ." and status = 1 and weekNum = ".$weekNum;

    $pSQL = "select * from tb_todo as todo right join  tb_project as project on todo.projectId = project.projectID left join  tb_week as week on week.weekNum = todo.weekNum where todo.uid=".$uid." and todo.status= 1 and week.weekNum = ".$weekNum;
    $projectResult = $Q->execute($pSQL);
    $projectList = mysql_num_rows($projectResult);
    if($projectList<=0 ){
        $todoListNoData = "暂无完成任务";
    }else{
        while($rowsProject = mysql_fetch_assoc($projectResult)){
            $projectTaskList[$rowsProject['projectID']][] = $rowsProject;
        }
    }


?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
            <title>周报邮件</title>
        </head>
        <body>
            <!--mail_week-->
            <div  style=" width:700px;margin:0 auto;padding:0 0 20px 0;border:1px solid #ddd;background:#fff;">
                <header style="height:100px;background:#f00;color:#fff;padding:0 50px;width:600px;line-height:100px;">
                    <h1 style="margin:0;padding:0;font-size:16px;">前端组<span style="margin-left:10px;">第<?php echo $weekNum; ?>周</span>周报【情封】</h1>
                </header>
                <?php foreach( $projectTaskList as $v ){ ?>
                <!--mail_box-->
                <div  style="padding: 0 50px;margin:50px 0;">
                    <div  style="font-size:14px;border-bottom:1px solid #f00;">
                        <h2 style="display:inline-block;margin:0;color:#fff;font-size:14px;background:#f00;padding:0 10px;height:25px;line-height:25px;"><?php echo $v[0]['projectDesc'] ?></h2>
                    </div>
                    <div  style="line-height:2;padding:10px 0;">
                        <ul style="list-style: none;padding-left:2em;">
                            <?php foreach( $v as $task){ ?>
                            <li><?php echo $task['content'] ?><?php echo $task['todoDesc'];?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <!--/mail_box-->
                <?php }?>
                <div  style="padding:0 50px;">
                    <div  style="font-size:14px;border-bottom:1px solid #f00;">
                        <h2 style="display:inline-block;color:#fff;background:#f00;margin:0;font-size:14px;padding:0 10px;height:25px;line-height:25px;">工作总结</h2>
                    </div>
                    <div style="line-height:2;padding:10px 0;padding-left:2em">
                        <?php foreach( $projectTaskList as $v ){ ?>
                        <p><?php echo $v[0]['summary']?></p>
                        <?php }?>
                    </div>
                </div>
            </div>
            <!--/mail_week-->
        </body>
    </html>