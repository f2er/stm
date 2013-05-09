<?php
    require_once('module/check.php');
    require_once('module/type.php');
   // session_start();
    $uid = $_SESSION['uid'];
    $state = 1; //登录
    $ptitle = "STM -- Todo";
    require_once('header.php');
   // require_once('module/type.php');
    require_once('module/config.php');
    //想做的事
    $gSQL = "select * from tb_todo todo,tb_project project where todo.projectID = project.projectID and uid =" .$uid ." and status = 0";
    $result = $Q->execute($gSQL);
    $listLen = mysql_num_rows($result);

    //已完成
    $cSQL = "select * from tb_todo todo,tb_project project where todo.projectID = project.projectID and uid =" .$uid ." and status = 1 order by dateTime desc";
    $completeResult = $Q->execute($cSQL);
    $completeList = mysql_num_rows($completeResult);
    if($completeList<=0 ){
        $todoListNoData = "暂无完成任务";
    }else{
        while($rowsComplete = mysql_fetch_assoc($completeResult)){
            $completeTaskList[$rowsComplete['dateTime']][] = $rowsComplete;
        }
    }

    //项目
    $pSql = "select * from tb_project";
    $projectResult = $Q->execute($pSql);
?>
<!--<?php
require_once('module/editor.php');
?>-->
<!--mod_todo-->
<div class="mod_todo clearfix">
    <!--m_todo_aside-->
    <div class="m_todo_aside">
        <!--m_project-->
        <div class="m_todo_edit m_project">
            <fieldset>
                <div class="clearfix">
                    <span class="m_rt" id="j-select-color">选择项目颜色</span>
                    <label><span>新建项目</span></label>
                </div>
                <div class="project_color" id="j-project-color" style="display:none;">
                    <ul class="clearfix">
                        <?php foreach ($projectType as $key => $projectV){ ?>
                            <li data-color="<?php echo $projectV ?>" class="cp_<?php echo ($key+1)?>"></li>
                        <?php } ?>
                    </ul>
                </div>
                <form action="module/doProject.php?op=1" method="POST">
                    <input type="text" value="" name="projectName" class="ipt_project"/>
                    <input type="hidden" value="" name="projectColor" id="j-projectColor"/>
                    <input type="submit" value="创建" class="q_submit"/>
                </form>
            </fieldset>
        </div>
        <!--/m_project-->
        <!--m_todo_edit-->
        <div class="m_todo_edit">
            <fieldset>
                <div class="clearfix">
                    <span class="m_rt" id="j-select-project">选择项目名称</span>
                    <label><span>添加Todo</span></label>
                </div>
                <div class="project_list" id="j-project-list" style="display:none;">
                    <ul class="clearfix">
                        <?php while($rowsProject = mysql_fetch_assoc($projectResult)){?>
                        <li data-projectId='<?php echo $rowsProject['projectId'];?>'><?php echo $rowsProject['projectDesc'];?></li>
                        <?php }?>
                    </ul>
                </div>
                <form action="module/doTodo.php?op=1" method="post" id="j-todoForm">
                    <input name="todoContent" class="todo_edit" id="j-content"/>
                    <div class="m_todesc">
                        <span>todo描述：</span>
                        <textarea class="m_txtarea" name="todoDesc"></textarea>
                    </div>
                    <input type="hidden" value="" id="j-projectid" name="projectid"/>
                    <input type="hidden" value="" name="weeknum"/>
                    <input type="submit" value="提交" class="q_submit" id='j-todo-submit'/>
                </form>
            </fieldset>
        </div>
        <!--/m_todo_edit-->
    </div>
    <!--/m_todo_aside-->
    <div class="m_todo_list">
        <!--m_wlist-->
        <div class="m_wlist">
            <h2>待办事项（<?php echo $listLen ?>）</h2>
            <div class="bd">
            <?php if($listLen>0){ ?>
            <ul id="j-todo" class="todo_list">
            <?php    while($rows = mysql_fetch_assoc($result)){
               ?>
                <li data-id="<?php echo $rows['id']?>" style="border-left:2px solid <?php echo $rows['projectColor']?>">
                    <span class="typicn tick" data-action="complete" title="完成"></span>
                    <span class="typicn delete" data-action = "delete" title="删除"></span>
                    【<?php echo $rows['projectDesc']?>】<?php echo $rows['content'] ?>
                </li>
                <?php }?>
            </ul>
             <?php } else{ ?>
                    <div class="nodata">哇塞。。没事做。。</div>
                <? }
                ?>
            </div>
        </div>
        <!--/m_wlist-->
        <div class="m_clist">
            <h2>已完成（<?php echo $completeList ?>）</h2>
            <div class="bd">
               <?php if($completeList >0){ ?>
               <?php foreach( $completeTaskList as $v ){ ?>
                    <time class="c_time""><?php echo $v[0]['dateTime']?></time>
                   <?php foreach( $v as $task){?>
                    <ul id="j-ctodo" class="c_todo_list">
                        <li>
                            【<?php echo $task['projectDesc']?>】<?php echo $task['content'] ?>
                        </li>
                    </ul>
                <?php }
                    }
                ?>
                <?php } else{ ?>
                    <div class="nodata"><?php echo $todoListNoData;?></div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!--/mod_todo-->
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
    var Todo = Todo ||{};
    Todo.complete = function(_id){
        $.ajax({
            url:'module/doTodo.php?op=2',
            dataType : 'json',
            data : {id:_id},
            success:function(data){
                if( data.code == 100 ){
                    location.reload();
                }
            }
        });
    };
    Todo.delete = function(id){
        $.ajax({
            url:'module/doTodo.php?op=0',
            dataType : 'json',
            data : {id:id},
            success:function(data){
                if( data.code == 100 ){
                    location.reload();
                }
            }
        });
    };
    $('#j-todo').bind('click',function(e){
        var _target = $(e.target);
        var _id = _target.parent().attr('data-id');
        var _actionType = _target.attr('data-action');
        if(_actionType == undefined){
            return;
        }
        switch(_actionType){
            case "complete":
                Todo.complete(_id);
                break;
            case "delete":
                //alert('删除');
                Todo.delete(_id);
                break;
        }
    });
    (function(){
        var _flag = 0;
        $("#j-select-project").bind('click',function(e){

            if(_flag==1){
                $("#j-project-list").hide();
                _flag = 0;
            }else{
                $("#j-project-list").show();
                _flag = 1;

            }
            function doToDo(){
                $("#j-project-list").bind('click',function(e){
                    $(e.target).siblings().removeClass('cur').end().addClass('cur');
                    var _projectID = $(e.target).attr('data-projectid');
                    $("#j-projectid").val(_projectID);
                    //$("#j-select-project").html($(e.target).html());
                    //$(this).hide();
                    //_flag = 0;

                });
            }
            doToDo();
        });
    })();

    (function(){
        var _flag = 0;
        $("#j-select-color").bind('click',function(){
            if(_flag==1){
                $("#j-project-color").hide();
                _flag = 0;
            }else{
                $("#j-project-color").show();
                _flag = 1;

            }
            function docolor(){
                $("#j-project-color").bind('click',function(e){
                    var _color = $(e.target).attr('data-color');
                    $(e.target).siblings().removeClass('cur').end().addClass('cur');
                    $("#j-projectColor").val(_color);
                });
            }
            docolor();
        });
    })();


</script>
<?php
    require_once('footer.php');
?>