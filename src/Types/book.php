<?php
	namespace Main\Product\Types;
	require_once ROOT_PATH."/src/product.php";

	use Main\Product\Products as Products;
	
	class Book extends Products {
		
		private static $fields = ["sku", "name", "price", "type", "weight"];

		function __construct ($data) {
			parent::__construct();
			$this->setSKU($data["sku"]);
			$this->setName($data["name"]);
			$this->setPrice($data["price"]);
			$this->setWeight($data["weight"]);
			$this->setType(3);
		}

		// Public == 
		public function save () {
			$this->validation(self::$fields);
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