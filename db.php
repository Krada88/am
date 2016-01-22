<?php

class DB {

   public function __constract($db_server, $db_type, $db_name, $db_user, $db_password, $db_connection_charset){
	  
	  self::connect();
	   
	   }
	   
	   
    private static function connect($db_server, $db_type, $db_name, $db_user, $db_password, $db_connection_charset) {
		
        $link = null;

        $dsn = $db_type . ':host=' . $db_server . ';dbname=' . $db_name;
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $db_connection_charset,
        );

        try {
            $link = new PDO($dsn, $db_user, $db_password, $options);
        } catch (PDOException $e) {
            die("Нет соединения с базой данных");
        }
        return $link;
    }
	
	/*
	* Метод выборки данных
	*/
    public static function select($sql, $data = array()) {
		
        $link = self::$link_site;
        
		$res = $link->prepare($sql);
		
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $res->execute($data);
		
		$count = $res->rowCount();
        $result = $res->fetchAll();	
				
        return array('count' => $count, 'result' => $result);
    }
	 
	/*
	* Метод добавления данных
	*/
	public function getInsert($sql, $data = array(), $db = 'site'){
		
		$link = null;
		
		if ($db == 'site') {
            $link = self::$link_site;
        } else if ($db == 'server') {
            $link = self::$link_server;
        }
		
		$res = $link -> prepare($sql);
		$res -> execute($data);
		$lastInsertId = $link -> lastInsertId();
		return $lastInsertId;
		
		
	}
	
	/*
	* Метод обновления данных
	*/
	
	public function getUpdate($sql, $data = array(), $db = 'site'){
		
		$link = null;
		
		if($db == 'site'){
			$link = self::$link_site;
			}
			else if($db == 'server'){
				$link = self::$link_server;
				}
				
		$res = $link -> prepare($sql);
		$res -> execute($data);
		
		return $res;
		}
		
		
	public function getDelete($sql, $data = array(), $db = 'site'){
		
		$link = null;
		
		if($db == 'site'){
			$link = self::$link_site;
			}
			else if($db == 'server'){
				$link = self::$link_server;
				}
				
		$res = $link -> prepare($sql);
		$res -> execute($data);
		
		return $res;
		}
		
			
	
	public function getData($array,$ar){
		
		foreach($ar as $value){
			$data[$value] = $array[$value];
		}
		return $data;
	}

}

?>
