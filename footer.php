    <footer>&copy;情封 2012~2013</footer>
    <script type="text/javascript">
        var TM = TM || {};
        TM.on = function(target,otype,fn){
            target.addEventListener(otype,fn,false);
        };
        TM.isObj = function(id){
            return  ( document.getElementById(id)!= null ) ? true : false;
        };
        TM.dropDown = function(targetId,dropId){
          var _dropDown = document.getElementById(targetId),
              _dlist = document.getElementById(dropId);
          TM.on(_dropDown,'mouseover',function(){
             _dlist.style.display = "block";
          });
          TM.on(_dropDown,'mouseout',function(){
             _dlist.style.display = "none";
          });
        };
        TM.listContent = function(id){
            var _header = document.getElementById(id).getElementsByTagName('header');
            for(var j=0;j<_header.length;j++){
                (function(n){
                    var _flag = false;
                    TM.on(_header[n],'click',function(){

                        if(_header[n].nextSibling.nodeType !=1){
                            var _obj = _header[n].nextSibling.nextSibling;
                            if(!_flag){
                                _obj.style.display = "block";
                                _flag = true;
                            }else{
                                _obj.style.display = "none";
                                _flag = false;
                            }
                        }
                    })
                })(j);
            }
        };
        if(TM.isObj('j-dropDown') && TM.isObj('j-setting')){
            TM.dropDown('j-dropDown','j-list');
            TM.dropDown('j-setting','j-sdrop');
        }
        if(TM.isObj('j-table')){
            TM.listContent('j-table');
        }
    </script>
</body>
</html>