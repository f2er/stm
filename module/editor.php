<script src="static/js/kindeditor-min.js" type="text/javascript" charset="utf-8"></script>
<script src="static/js/zh_CN.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea[name="content"]', {
            allowFileManager : true
        });
    });
</script>