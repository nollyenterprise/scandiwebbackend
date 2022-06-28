<?php
	namespace Main\Product\Types;
	require_once ROOT_PATH."/src/product.php";

	use Main\Product\Products as Products;
	
	class DVD extends Products {
		
		private static $fields = ["sku", "name", "price", "type", "size"];

		function __construct ($data) {
			parent::__construct();
			$this->setSKU($data["sku"]);
			$this->setName($data["name"]);
			$this->setPrice($data["price"]);
			$this->setSize($data["size"]);
			$this->setType(1);
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
			
			$q = "INSERT INTO dvd (`id_product`, `size`) VALUES ('".$last_insert."', '".$this->getSize()."')";
			$stmt = $this->conn->prepare($q);
			$stmt->execute();
			echo json_encode(["code"=>true, "message"=>"Successful", "data"=>null]);
		}
		
	} 
?>