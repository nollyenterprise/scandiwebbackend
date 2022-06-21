<?php
	namespace Main\Product\Types;
	require_once ROOT_PATH."/src/product.php";

	use Main\Product\Products as Products;
	
	class Book extends Products {
		
        private $weight;
        private $type;
		private static $fields = ["sku", "name", "price", "type", "weight"];

		function __construct ($data) {
			foreach ($data as $key => $value) {
				# code...
				$get = htmlspecialchars($value);
				$get = stripslashes($get);
				$get = trim($get);
				$$key = "$get";
			}
			$this->setSKU($sku);
			$this->setName($name);
			$this->setPrice($price);
			$this->setWeight($weight);
			$this->setType(3);
			$this->conn = new \mysqli(self::$DB_SERVER, self::$DB_USERNAME, self::$DB_PASSWORD, self::$DB_DATABASE);
		}

		// Private == 
		private function setError ($key, $value){
			$this->error[$key] = $value;
		}
		private function checkSKUExist($data) {
			$q = "SELECT 1 FROM products WHERE sku = ?";
			$stmt = $this->conn->prepare($q);
			$stmt->bind_param("s", $data);
			$stmt->execute();
			$result = $stmt->get_result(); // $result is of type mysqli_result
			$num_rows = $result->num_rows;  // count number of rows in the result
			return $num_rows;
		}

		// Public == 
		public function __call($method,$args){
			// Do nothing ==
		}
		public function validation () {
			foreach(self::$fields as $field){
				if(empty($this->$field))
					$this->setError($field, "$field must be provided!");
				if($field == "sku" && !empty($this->$field) && $this->checkSKUExist($this->$field))
					$this->setError($field, "$field provided exists!");
			}
		}
		public function setWeight ($data) {
			$this->weight = trim($data);
		}
		public function getWeight () {
			return $this->weight;
		}
		public function setType ($data) {
			$this->type = trim($data);
		}
		public function getType () {
			return $this->type;
		}
		public function save () {
			$this->validation();
			if($this->error){
				echo json_encode(["code"=>false, "message"=>implode("<br /> ",$this->error), "data"=>null]); 
				exit;
			}
			$q = "INSERT INTO products (`sku`, `name`, `price`, `type`) VALUES ('".$this->getSKU()."', '".$this->getName()."', '".$this->getPrice()."', '".$this->getType()."')";
			$stmt = $this->conn->prepare($q);
			$stmt->execute();
			$last_insert = $stmt->insert_id;
			
			$q = "INSERT INTO book (`id_product`, `weight`) VALUES ('".$last_insert."', '".$this->getWeight()."')";
			$stmt = $this->conn->prepare($q);
			$stmt->execute();
			echo json_encode(["code"=>true, "message"=>"Successful", "data"=>null]);
		}
		
	}
?>