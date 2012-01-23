<?php
    class db{
        public $connect_error;
        protected $query_error;
        protected $conn;
        protected $dbh;
        protected $config;
        public $debug;

          function __construct(array $config){
            $this->debug = false;
            $dbhost = $config['db_host'];
            $dbname = $config['db_name'];
            $dbuser = $config['db_user'];
            $dbpass = $config['db_pass'];
            try {
                $this->dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
                $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                }
            catch (PDOException $e) {
                $this->connect_error = "Error!: " . $e->getMessage() . "<br/>";
                $this->dbh = null;
                return;
            }
        }

        function connect(){

        }

        function close(){
            $dbh->close;
        }

        function query($query,$params=array()){
            if($this->debug === true){
                $this->debugger($params,$query);
            }
            try{
                $stmt = $this->dbh->prepare($query);
                $stmt->execute($params);
                return $stmt;
            }
            catch (PDOException $e){
                return false;
            }
        }

        function debugger($params,$query){
            if($this->debug === true){
                $keys = array();
                if(!empty($params)){
					foreach ($params as $key => $value) {
	                    if (is_string($key)) {
	                        $keys[] = '/:'.$key.'/';
	                    } else {
	                        $keys[] = '/[?]/';
	                    }
	                    $safeParams[] = "'".$value."'";
	                }
                }else $safeParams = '';

                echo "\r\n<!-- SQL QUERY: \r\n". preg_replace($keys, $safeParams, $query, 1, $count) . "\r\n-->";
            }
        }

        function query_select($query,$params=array()){
            if($this->debug === true){
                $this->debugger($params,$query);
            }
            try{
                $sth = $this->dbh->prepare($query);
                $sth->execute($params);
                $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
                if(isset($rows)){
                    return $rows;
                }
                else{
                    return false;
                }
            }
            catch (PDOException $e){
                return false;
            }
            $this->dbh = null;
        }

        function query_select_single($query,$params=array()){
            if($this->debug === true){
                $this->debugger($params,$query);
            }
            try{
                $sth = $this->dbh->prepare($query);
                $sth->execute($params);
                $row = $sth->fetch(PDO::FETCH_ASSOC);
                if(isset($row) && is_array($row)){
                    return $row;
                }
                else{
                    return false;
                }
            }
            catch (PDOException $e){
                return false;
            }
            $this->dbh = null;
        }

        function query_insert($query,$params){
            if($this->debug === true){
                $this->debugger($params,$query);
            }
            $sth = $this->dbh->prepare($query);
            if($sth->execute($params)){
                return $this->dbh->lastInsertId();
            }else return false;
        }

        function query_update($query,$params){
            if($this->debug === true){
                $this->debugger($params,$query);
            }
            try{
                $sth = $this->dbh->prepare($query);
                $sth->execute($params);
            }catch(PDOException $e){
                echo $e->getMessage();
            }
            if($sth->rowCount() > 0){
                return true;
            }else return false;
        }
    }
?>