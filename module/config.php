<?php

    class Q_DB{
        private $db_name;    //数据库
        private $db_user;    //用户名
        private $db_pwd;     //密码
        private $db_host;    //主机
        private $db_charset; //编码类型
        private $db_collate;
        private $link;
        private $isCon = false;

        public function __construct($dn,$du,$dp,$dh,$dc){
            $this->db_name    = $dn;
            $this->db_user    = $du;
            $this->db_pwd     = $dp;
            $this->db_host    = $dh;
            $this->db_charset = $dc;
            //$this->db_collate = $do;
        }

        public function __destruct(){
            if( $this->isCon ){
               $this->closeCon();
            }
        }

        public function newCon(){
           if( !$this->isCon ){
               $this->link = mysql_connect( $this->db_host,$this->db_user,$this->db_pwd ) or die("无法创建数据连接".mysql_error());
               mysql_query("SET NAMES {$this->db_charset}");
               $this->isCon = true;
           }
        }

        public function closeCon(){
            if( $this->isCon ){
                mysql_close($this->link);
                $this->isCon = false;
            }
        }

        public function execute($sql){
            if( !$this->isCon ){
                $this->newCon();
            }
            $db_selected = mysql_select_db($this->db_name,$this->link) or die("无法选择数据库".mysql_error($this->link));
            $result = mysql_query($sql,$this->link);
            return $result;
        }
    }

	$Q = new Q_DB('db_tm','root','xxxx','localhost',"UTF8");
?>