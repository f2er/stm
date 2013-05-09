<?php
    require_once('module/check.php');
   // session_start();
    $uid = $_SESSION['uid'];

    $state = 1; //登录
    $ptitle = "番茄时钟工作法";
    require_once('header.php');
    //require_once('module/type.php');
    require_once('module/config.php');

    //todo列表
    $taskSql = "select * from tb_todo where uid = ".$uid." and status =0 order by id desc";
    $taskResult = $Q->execute($taskSql);
    //$taskRs = mysql_fetch_assoc($taskResult) ;
    //$listLen = mysql_num_rows($taskResult);
    //print_r($taskRs);

    //时钟列表
    $clockSql = "select todo.content from tb_todo todo ,tb_clock clock  where todo.id = clock.taskid and clock.uid =".$uid." order by clock.id desc";
    $clockResult = $Q->execute($clockSql);
    $clockLen = mysql_num_rows($clockResult);
    //$clockList = mysql_fetch_assoc($clockResult) ;
?>
<div class="mod_clock">
    <div class="m_cbox">
        <h2>请选择任务</h2>
        <select name="task_list" id="j-task-list" class="task_list">
            <?php
            while($row = mysql_fetch_assoc($taskResult)){
                $_tmpdata[$row['id']] = $row['content'];
                ?>
                <option value=<?php echo $row['id'] ?>><?php echo $_tmpdata[$row['id']] ?></option>
            <? }?>
        </select>
    </div>
    <div class="m_cbox">
        <h2>设置番茄时间：</h2>
        <div class="clock_timer" id="j-clock-timer">25:00</div>
        <input id="startB" type="button" value="开始工作"/>
        <input id="endB" type="button" value="停止"/>
    </div>
    <!--m_clock_list-->
    <div class="m_clock_list">
        <h2>任务清单：</h2>
        <?php if($clockLen>0){?>
        <ul class="clock_list">
            <?php while( $rows = mysql_fetch_assoc($clockResult)){?>
            <li>【任务】<?php echo $rows['content']; ?></li>
            <?php }?>
        </ul>
        <?php } else{?>
        <div class="nolsit">你还没完成任务</div>
        <?php }?>
    </div>
    <!--/m_clock_list-->
    <!--m_clock_setting-->
    <div class="m_clock_setting">
        <span class="btn" id="j-setting-btn">设置番茄时钟</span>
        <a href="http://baike.baidu.com/view/5259318.htm" target="_blank" class="btn what_tomato">什么是番茄工作法？</a>

        <div class="clock_box" id="j-setting-box">
            <div class="set_clock">
                <div class="c_label">

                    <label>工作时长：</label>
                    <input type="text" id="j-clock" class="txt" value=""/>
                </div>
                <input type="button" id="j-btn-setting" class="btn_set" value="设置"/><span class="time_formate">格式:01:00</span>
            </div>
        </div>
        <!--clock_box-->
    </div>
    <!--/m_clock_setting-->


</div>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript">
    (function(win){
        var tomatoClock = tomatoClock || {};
        tomatoClock = {
            start : "25:00",
            init : function(){
                var that = this;
                that.config = {
                    counter : 0,
                    startTime : 0,
                    nextelapse : 100,
                    timer : null
                };
                $('#startB').bind('click',function(){
                  that.run();
                });
                $('#endB').bind('click',function(){
                    that.stop();
                });

            },
            /*开始运行*/
            run : function(){
                var that = this;
                $('#startB')[0].disabled = true;
                $('#endB')[0].disabled = false;
                that.config.counter = 0;
                // 初始化开始时间
                that.config.startTime = new Date().valueOf();

                // nextelapse是定时时间, 初始时为100毫秒
                // 注意setInterval函数: 时间逝去nextelapse(毫秒)后, onTimer才开始执行
                that.config.timer = window.setInterval("tomatoClock.onTimer()", that.config.nextelapse);
                //that.onTimer();
            },
            /*停止运行*/
            stop : function(){
                var that = this;
                startB.disabled = false;
                endB.disabled = true;
                window.clearTimeout(that.config.timer);
            },
            onTimer : function(){
                var that = this;
                var normalelapse = 1000;
                that.config.nextelapse = normalelapse;

                var finish = "00:00";

                //var timer = null;
                var _obj = document.getElementById('j-task-list');
                var _taskId = _obj.options[_obj.selectedIndex].value;
                if (tomatoClock.start == finish){
                    window.clearInterval(that.config.timer);
                    $.ajax({
                        url:'module/doClock.php',
                        dataType:'json',
                        data:{
                            taskId:_taskId
                        },
                        success:function(data){
                            if( data.code == 100 ){
                                location.reload();
                            }
                        }
                    });
                    return;
                }

                var hms = new String(tomatoClock.start).split(":");
                var m = new Number(hms[0]);
                var s = new Number(hms[1]);

                s -= 1;
                if( s<0 ){
                    m -=1;
                    s = 59;
                    if(m<0){
                        //todo:停止
                        window.clearInterval(that.config.timer);
                    }
                }

                var ss = s < 10 ? ("0" + s) : s;
                var sm = m < 10 ? ("0" + m) : m;
                tomatoClock.start = sm + ":" + ss ;
                document.getElementById('j-clock-timer').innerHTML = tomatoClock.start;
                // 清除上一次的定时器
                window.clearInterval(that.config.timer);

                // 自校验系统时间得到时间差, 并由此得到下次所启动的新定时器的时间nextelapse
               that.config.counter++;
                //var counterSecs = that.config.counter * 100;
                //var elapseSecs = new Date().valueOf() - that.config.startTime;
                //var diffSecs = counterSecs - elapseSecs;
                //that.config.nextelapse = normalelapse + diffSecs;
                //diff.value = counterSecs + "-" + elapseSecs + "=" + diffSecs;
                //next.value = "nextelapse = " + nextelapse;
                if (that.config.nextelapse < 0) that.config.nextelapse = 0;

                // 启动新的定时器
                that.config.timer = window.setInterval("tomatoClock.onTimer()", that.config.nextelapse);
            }
        };
        win.tomatoClock = tomatoClock;
    })(window);



    /*设置番茄时钟*/
    function setClockTime(){
        var _clockTime = $("#j-clock"),
            _btnClock = $("#j-btn-setting");
        _btnClock.bind('click',function(){
            localStorage.setItem('clockTime',_clockTime.val());
            tomatoClock.start = document.getElementById('j-clock-timer').innerHTML  = localStorage.getItem('clockTime');
        })
    }

    function setTime(){
        var _settingTime = $("#j-setting-btn"),
            _settingTimeBox = $("#j-setting-box");
        var _flag = false;
        _settingTime.bind('click',function(){
            if( !_flag){
                _settingTimeBox.show();
                _flag = true;
            }else{
                _settingTimeBox.hide();
                _flag = false;
            }
        });
    }
    tomatoClock.init();
    setTime();
    setClockTime();
</script>
<?php
    require_once('footer.php');
?>