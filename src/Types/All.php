<?php
	namespace Main\Product\Types;
	require_once ROOT_PATH."/src/product.php";

	use Main\Product\Products as Products;
	
	class All extends Products {

		function __construct ($data) {
			parent::__construct();
			$this->setId($data["id"]);
		}

		// Public == 
		public function getProducts () {
			$q = "SELECT `id`,`name`, `sku`, `price`, `type`,
			(
				CASE
					WHEN `type` = '1' 
					THEN (SELECT concat('Size: ', size,' MB') FROM dvd WHERE id_product = a.id)
					WHEN `type` = '3' 
					THEN (SELECT concat('Weight: ', weight,' KG') FROM book WHERE id_product = a.id)
					WHEN `type` = '2' 
					THEN (SELECT concat('Dimension: ', height,'x', width,'x', Length) FROM furniture WHERE id_product = a.id)
					ELSE ''
				END
			) AS prodType
			FROM products a ORDER BY id DESC";
			$stmt = $this->conn->prepare($q);
			$stmt->execute();
			$result = $stmt->get_result();
			$rows = [];
			while ($row = $result->fetch_assoc()) {
				array_push($rows,$row);
			}
			echo json_encode(["code"=>true, "message"=>"Successful", "data"=>$rows]);
		}
		public function deleteProducts () {
			$q = "DELETE FROM products WHERE id IN (".$this->getId().")";
			$stmt = $this->conn->prepare($q);
			$stmt->execute();

			$q = "DELETE FROM dvd WHERE id_product IN (".$this->getId().")";
			$stmt = $this->conn->prepare($q);
			$stmt->execute();

			$q = "DELETE FROM book WHERE id_product IN (".$this->getId().")";
			$stmt = $this->conn->prepare($q);
			$stmt->execute();

			$q = "DELETE FROM furniture WHERE id_product IN (".$this->getId().")";
			$stmt = $this->conn->prepare($q);
			$stmt->execute();

			echo json_encode(["code"=>true, "message"=>"Successful", "data"=>null]);
		}
		
	} 
?>
