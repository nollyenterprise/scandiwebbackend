<?php
	namespace Main\Db;

	class db {
		public $conn = NULL;
		public $result = NULL;
		public $error = "";
		public $insert_id = 0;
		public $affected_rows = 0;
		public static $instance;
		private static $DB_SERVER = '';
		private static $DB_USERNAME = '';
		private static $DB_PASSWORD = '';
		private $sql = "";
		private $querry = "";

		function __construct($mysqli = NULL) {
			$this->querry = "";
			$this->conn = new \mysqli(self::$DB_SERVER, self::$DB_USERNAME, self::$DB_PASSWORD);
			$this->conn->set_charset('utf8');
			if ($this->conn->connect_error) { $this->state = FALSE; }
			self::$instance = $this;
		}
		public static function _g() {
			if (self::$instance === null) {
				self::$instance = new self();
			}
			return self::$instance;
		}
		private function ref_values($a){
			if (strnatcmp(phpversion(),'5.3') >= 0){
				$refs = array();
				$refs[0] = $a[0];
				for($i = 1;$i<count($a);$i++)
					$refs[$i] = &$a[$i];
				return $refs;
			}
			return $a;
		}
		public function use_db($db){
			return $this->conn->select_db($db);
		}	
		public function reset(){
				$this->querry = "";
				$this->result = NULL;
				$this->state = NULL;
				$this->sql = "";
				$this->error = "";
				$this->values = [];  
				$this->types = ""; 
				$this->insert_id = 0;
				$this->affected_rows = 0;
				$this->num_rows = 0;
		}
		public function error(){
			return $this->error;
		}	
		public function get(){
			if(!($this->sql = $this->conn->prepare($this->querry))){
				$this->error = $this->conn->error;
				return FALSE;
			}
			
			if(count($this->values) > 0){
				
				array_unshift($this->values,$this->types);
				
				
				if(!call_user_func_array(array($this->sql,'bind_param'),$this->ref_values($this->values))){
					$this->error = $this->conn->error;
					return FALSE;
				}
			}
			
			if(!$this->sql->execute()){
				return FALSE;
			}
			$this->result = $this->sql->get_result();
			$this->num_rows = $this->result->num_rows;
			
			return $this->result;
			
		}
		public function get_assoc_rows(){
			if(!($this->result = $this->get())){
				$this->error = $this->conn->error;
				return FALSE;
			}
			if($this->result->num_rows > 0){
				$this->num_rows = $this->result->num_rows;
				$rows = [];
				while($row=$this->result->fetch_assoc()){
					$rows[] = $row;
				}
				return $rows;
			}
			return [];
		}	
		public function select($select){
			$this->querry = "SELECT " . $select;
		}
		public function q($q){
			$this->querry = $q." ";
		}
		public function execute(){
			if(!$output = $this->conn->query($this->querry)){ $this->error = $this->conn->error;}
			if($this->conn->insert_id){$this->insert_id = $this->conn->insert_id;}
			if($this->conn->affected_rows){$this->affected_rows = $this->conn->affected_rows;}
			return $output;
			
		}
		public function insert($table,array $insert,$type=""){
			$this->querry = "INSERT INTO " . $table . " (" ;
			$h = " VALUES (";
			$i = 0;
			$vals = [];
			foreach($insert as $k => $v){
			
				$i++;
				if($i<=strlen($type)){
						$this->querry.= $k;
						$vals[] = $v;
						$h.= "?";
				}else{
						$this->querry.= $k;
						$h.= $v;
					}
				if($i == count($insert)){
					$this->querry.= ")";
					$h.= ")";
						}else{ 
							$this->querry.= ",";
							$h.= ",";
							};
			}
			$this->querry.= $h; 
			if(!$this->sql = $this->conn->prepare($this->querry)){ //echo $this->querry;
				$this->error = $this->conn->error;
				return FALSE;
			};
			array_unshift($vals,$type);
			
			if(trim($type)!="" && !call_user_func_array(array($this->sql,'bind_param'),$this->ref_values($vals))){
				$this->error = $this->conn->error;
				return FALSE;
			}
			
			if(!$output = $this->sql->execute()){ $this->error = $this->conn->error;}
			
			$this->insert_id = $this->conn->insert_id;
			return $output;
			
		}
	}

?>