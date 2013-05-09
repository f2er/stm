<?php
    require_once('module/check.php');
   // session_start();
    $uid = $_SESSION['uid'];
    $state = 1; //登录
    $ptitle = "STM -- 版本记录";
    require_once('header.php');
?>
<!--mod_version-->
<div class="mod_version">
    <h2>版本记录</h2>
    <div class="bd">
        <dl class="m_vlist">
            <dt>2013.04.23</dt>
            <dd>新增新建项目模块（通过颜色标识不同的项目）</dd>
            <dd>添加todo，新增选择项目</dd>
        </dl>
        <dl class="m_vlist">
            <dt>2013.04.01</dt>
            <dd>利用css3,更新todo中删除、完成图形化</dd>
        </dl>
        <dl class="m_vlist">
            <dt>2013.03.31</dt>
            <dd>添加todo功能、番茄时钟功能</dd>
        </dl>
        <dl class="m_vlist">
            <dt>2012.08.13</dt>
            <dd>STM v0.1上线</dd>
        </dl>
    </div>
</div>
<!--/mod_version-->
<?php
    require_once('footer.php');
?>