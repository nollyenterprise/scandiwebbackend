<?php
	namespace Main\Product\Actions;
	require_once ROOT_PATH."/src/product.php";
	require_once ROOT_PATH."/src/db.php";

	use Main\Product\Products as Products;
	use Main\Db\db as db;
	
	class Add extends Products {
		// Private ==
		private function addTypeDVD($id) {
			$db = db::_g();
			$db->reset();
			$db->use_db('tekxsacd_scandiwebjwd');

			$sql = "INSERT INTO dvd (`id_product`, `size`) VALUES ('".$id."','".$this->size."')";
			$db->q($sql);
			$db->execute();
			$db->reset();
		}
		private function addTypeBook($id) {
			$db = db::_g();
			$db->reset();
			$db->use_db('tekxsacd_scandiwebjwd');

			$sql = "INSERT INTO book (`id_product`, `weight`) VALUES ('".$id."','".$this->weight."')";
			$db->q($sql);
			$db->execute();
			$db->reset();
		}
		private function addTypeFurniture($id) {
			$db = db::_g();
			$db->reset();
			$db->use_db('tekxsacd_scandiwebjwd');

			$sql = "INSERT INTO furniture (`id_product`, `height`, `width`, `length`) VALUES ('".$id."','".$this->height."','".$this->width."','".$this->length."')";
			$db->q($sql);
			$db->execute();
			$db->reset();
		}
		private function isValidateDVD() {
			$array = Array();
			if(empty($this->name))
				array_push($array, "Name");
			if(empty($this->sku))
				array_push($array, "Sku");
			if(empty($this->price))
				array_push($array, "Price");
			if(empty($this->productType))
				array_push($array, "Product Type");
			if(empty($this->size))
				array_push($array, "Size");
			return $array;
		}
		private function isValidateBook() {
			$array = Array();
			if(empty($this->name))
				array_push($array, "Name");
			if(empty($this->sku))
				array_push($array, "Sku");
			if(empty($this->price))
				array_push($array, "Price");
			if(empty($this->productType))
				array_push($array, "Product Type");
			if(empty($this->weight))
				array_push($array, "Weight");
			return $array;
		}
		private function isValidateFurniture() {
			$array = Array();
			if(empty($this->name))
				array_push($array, "Name");
			if(empty($this->sku))
				array_push($array, "Sku");
			if(empty($this->price))
				array_push($array, "Price");
			if(empty($this->productType))
				array_push($array, "Product Type");
			if(empty($this->height))
				array_push($array, "Height");
			if(empty($this->width))
				array_push($array, "Width");
			if(empty($this->length))
				array_push($array, "Length");
			return $array;
		}
		private function checkSKUExist($sku) {
			$db = db::_g();
			$db->reset();
			$db->use_db('tekxsacd_scandiwebjwd');

			$sql = "SELECT count(1) as count FROM products a WHERE sku = '$sku'";
			$db->q($sql);
			$rows = $db->get_assoc_rows();
			$db->reset();

			return $rows[0]["count"];
		}

		// Public ==
		public function main() {
			$db = db::_g();
			$db->reset();
			$db->use_db('tekxsacd_scandiwebjwd');
			$type = $this->productType;
			$error = 0;
			
			$validate = $this->{"isValidate$type"}();
			while ($error < count($validate)) {
				# code...
				echo json_encode(["code"=>false, "message"=>implode(", ",$validate)." fields are required!", "data"=>null]);
				exit;
			}
			
			$isSKUExist = $this->checkSKUExist($this->sku);
			while ($error < $isSKUExist) {
				# code...
				echo json_encode(["code"=>false, "message"=>"SKU exist! Use another", "data"=>null]);
				exit;
			}

			$sql = "INSERT INTO products (`name`, `sku`, `price`, `type`) VALUES ('".$this->name."','".$this->sku."','".$this->price."','".$this->productType."')";
			$db->q($sql);
			$db->execute();
			$lastInsert = $db->insert_id;
			$db->reset();

			$this->{"addType$type"}($lastInsert);

			echo json_encode(["code"=>true, "message"=>"Successful", "data"=>null]);
		}
	}

?>