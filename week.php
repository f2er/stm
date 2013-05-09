<?php
   require_once('module/check.php');
   header("Content-Type:text/html;charset=utf-8");
   //session_start();
   $uid = $_SESSION['uid'];
   $state = 1; //登录
   $ptitle = "周报";
   $mtype = $_GET['m'];
   require_once('header.php');
   require_once('module/config.php');


   /*按年月查询*/
   if( !empty($_POST['BeginMonthTime']) && !empty($_POST['EndMonthTime']) ){
      $BeginMonthTime = $_POST['BeginMonthTime'];
      $EndMonthTime = $_POST['EndMonthTime'];
      $Msql = "select user.nickname as nikename, tm.dateTime, tm.totalTime, tm.mcontent from tb_tm as tm left join tb_user as user on (tm.uid=user.id) where tm.dateTime between '$BeginMonthTime' and '$EndMonthTime'".(($uid ==1) ? "": "and mgroup='$ngroup'" ). "order by tm.dateTime";
      /*$res = mysql_query($Msql,$con);
      $resNum = mysql_num_rows($res);*/
       $res = $Q->execute($Msql);
       $resNum = mysql_num_rows($res);
      echo mysql_error();

      //$len = mysql_num_rows($res);
      //var_dump($len);
      //echo exit;
      //$nickname = "";
      if($resNum <= 0){
          $nodata = "在该时间段内暂无日报";
          //var_dump("无数据");
          //echo exit;
      }else{
      while($row = mysql_fetch_assoc($res)){
		$_tmpNameList[$row['nikename']] = '无';
            $_date = substr($row['dateTime'],8,10);
           if( substr($_date,0,1) == "0"){
                $_date =substr(substr($_date,0),1);
            }
			//$tmpDate[] = $_date;
			//$tmpTime[] = $row['dateTime'];
            //$nickname =  $row['nikename'];
            //$tmpdata[$row['nikename']][$_date] = $row['totalTime'];
           $_tmpdata[$row['nikename']][$row['dateTime']] = $row['totalTime'];
           $cttdata[$row['dateTime']][$row['nikename']] = $row['mcontent'];
      }
	  $nameList = array_keys($_tmpNameList);
	  //var_dump($cttdata);
	  $arrD = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
	  $_month0 = date("Y-m-01",strtotime($BeginMonthTime));
	  $_start = strtotime($_month0)-86400;
	  foreach ($_tmpdata as $_name => $_val){
		foreach ($arrD as $i){
			$_date = date("Y-m-d",$_start+86400*$i);
			if(isset($_val[$_date])){
				$tmpdata[$_name][] = $_val[$_date];
			}
			else{
				$tmpdata[$_name][] = 0;
			}
		}
	  }
	


      $c = 0;
      foreach ($tmpdata as $_name => $_val){
		$a = dechex(rand(0,255));
		$b = dechex(rand(0,255));
		$c = dechex(rand(0,255));
        //$col = dechex($c);
        $data[]=array(
            'name'=>$_name,
            'value'=>$_val,
            'color'=>"#$a$b$c",
            );
          //$c++;
      }
	  //var_dump($data);

      //foreach ($cttdata as $_date => $_val){
      //  $tmp_task_data[] = $_val;
      //}
	  $_date = $BeginMonthTime;
	  foreach ($arrD as $i){
		$_date = date("Y-m-d",$_start+86400*$i);
		if(isset($cttdata[$_date])){
			$tmp_task_data[] = array_merge($_tmpNameList,$cttdata[$_date]);
		}
		else{
			$tmp_task_data[] = $_tmpNameList;
		}
		//$_date = date("Y-m-d",strtotime($_date)+86400);
	  }
	  //echo exit;
	  //print_r($_tmpNameList);
      $timeData = json_encode($data);
      $task_data = json_encode($tmp_task_data);
	  
	  //var_dump($task_data);
      }
   }else{
      $gSql = "select user.nickname,tm.dateTime,tm.mgroup,tm.mcontent,tm.totalTime from tb_tm tm,tb_user user where tm.uid = user.id" .(($uid ==1)?"" : " and tm.mgroup='" .$ngroup."'") ." order by tm.dateTime desc";
	  /*$glist = querySql($gSql);
      $glistLen = $glist->num_rows;*/
       $glist = $Q->execute($gSql);
       $glistLen = mysql_num_rows($glist);
   }
?>

		<div class="q_table" id="j-table">
             <?php
                if( $mtype == "list"){
                    ?>
            <!--q_tlist-->
                    <?php if($glistLen>0){
                        while($rows = mysql_fetch_assoc($glist)){
                            ?>
                <div class="q_tlist">
                    <header class="q_thd clearfix"><span class="total_time" title="总共:<?php echo $rows['totalTime']?>小时"><?php echo $rows['totalTime']?></span><?php echo $rows['nickname']?>日报 <time><?php echo $rows['dateTime']?></time></header>
                    <div class="q_tbd">
                        <?php echo $rows['mcontent']?>
                    </div>
                </div>
                <?php
            }
        }else{
            ?>
            <div class="nodata"><?php echo "亲，没日报记录~" ?></div>
            <?php }
            ?>
            <!--/q_tlist-->



			<?php }else if( $mtype == "visual"){ ?>
			    <!--m_search-->
			    <div class="m_search">
			        <fieldset>
			            <legend>按年月查询</legend>
			            <form action="week.php?m=visual" method="POST">
                        	从<input type="date" class="q_ipt" value="" name="BeginMonthTime"/>至<input class="q_ipt" type="date" value="" name="EndMonthTime"/><input type="submit" class="q_submit" value-"查询"/>
                        </form>
			        </fieldset>
			    </div>
			    <!--/m_search-->
			    <div class="m_visual" id="j-visual"></div>
			<?php }?>

		</div>
  <script type="text/javascript" src = "static/js/ichart-1.0.beta.js"></script>
  <script type="text/javascript">
     <?php if( $mtype == "visual"){  ?>
      var data_labels = ["01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31"];

    <?php }?>
     <?php
        if($resNum <=0){?>
          if( document.getElementById('j-visual')){
                document.getElementById('j-visual').innerHTML = '<?php echo $nodata ?>';
          }
     <?php   }else if( !empty($_POST['BeginMonthTime']) && !empty($_POST['EndMonthTime']) ){ ?>
        var uid = <?php echo $uid ?>;
        var timeData = eval('('+'<?echo $timeData;?>'+')');
        var task_data = eval('('+'<?echo $task_data;?>'+')');
        var _timeRange =  '<?php echo $BeginMonthTime; ?>~<?php echo $EndMonthTime; ?>';
        var _DepartentTitle = ( uid == 1) ? '部门日报' : '<?php echo $ngroup; ?>';
        new iChart.LineBasic2D({
            render : 'j-visual',
            data: timeData,
            title : _DepartentTitle,
            footnote : '数据来源：个人日报',
            subtitle : _timeRange,
            width : 980,
            height : 600,
            data_labels:data_labels,
            tip:{
                enable:true,
                shadow:true
            },
            legend : {
                enable : true
            },
            crosshair:{
                enable:true,
                line_color:'#62bce9'
            },
            tip:{
                enable:true,
                shadow:true
            },
            listeners:{
                parseTipText:function(d,t,i){
                    //console.log(d.name)
                    return '<strong class="name">'+d.name+"</strong>" + "<br/>"+task_data[i][d.name];
                }
            },
            coordinate:{
                width:800,
                height:460,
                axis:{
                    color:'#9f9f9f',
                    width:[0,0,2,2]
                },
                grids:{
                    vertical:{
                        way:'share_alike',
                        value:5
                    }
                },
                scale:[{
                    position:'left',
                    start_scale:0,
                    end_scale:12,
                    scale_space:0,
                    scale_size:2,
                    scale_color:'#9f9f9f'
                },{
                    position:'bottom',
                    labels:data_labels
                }]
            }
        }).draw();
        <?php }
     ?>
  </script>
  <?php
    require_once('footer.php');
?>