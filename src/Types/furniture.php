<?php
	namespace Main\Product\Types;
	require_once ROOT_PATH."/src/product.php";

	use Main\Product\Products as Products;
	
	class Furniture extends Products {
		
		private static $fields = ["sku", "name", "price", "type", "height", "width", "length"];

		function __construct ($data) {
			parent::__construct();
			$this->setSKU($data["sku"]);
			$this->setName($data["name"]);
			$this->setPrice($data["price"]);
			$this->setHeight($data["height"]);
			$this->setWidth($data["width"]);
			$this->setLength($data["length"]);
			$this->setType(2);
		}
		
		// Public == 
		public function save () {
			$this->validation(self::$fields);
			if($this->error){
				echo json_encode(["code"=>false, "message"=>implode("<br /> ",$this->error), "data"=>null]); 
				exit;
			}
			$q = "INSERT INTO products (`name`, `sku`, `price`, `type`) VALUES ('".$this->getSKU()."', '".$this->getName()."', '".$this->getPrice()."', '".$this->getType()."')";
			$stmt = $this->conn->prepare($q);
			$stmt->execute();
			$last_insert = $stmt->insert_id;
			
			$q = "INSERT INTO furniture (`id_product`, `height`, `width`, `length`) VALUES ('".$last_insert."', '".$this->getHeight()."', '".$this->getWidth()."', '".$this->getLength()."')";
			$stmt = $this->conn->prepare($q);
			$stmt->execute();
			echo json_encode(["code"=>true, "message"=>"Successful", "data"=>null]);
		}
		
	} 
?>