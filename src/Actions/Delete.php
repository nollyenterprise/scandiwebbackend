<?php
	namespace Main\Product\Actions;
	require_once ROOT_PATH."/src/product.php";
	require_once ROOT_PATH."/src/db.php";

	use Main\Product\Products as Products;
	use Main\Db\db as db;
	
	class Delete extends Products {
		// Private ==

		// Public ==
		public function main() {
			$db = db::_g();
			$db->reset();
			$db->use_db('tekxsacd_scandiwebjwd');
			
			$id = $this->id;

			$sql = "DELETE FROM products WHERE id IN ($id)";
			$db->q($sql);
			$db->execute();
			$db->reset();
			$sql = "DELETE FROM dvd WHERE id_product IN ($id)";
			$db->q($sql);
			$db->execute();
			$db->reset();
			$sql = "DELETE FROM book WHERE id_product IN ($id)";
			$db->q($sql);
			$db->execute();
			$db->reset();
			$sql = "DELETE FROM furniture WHERE id_product IN ($id)";
			$db->q($sql);
			$db->execute();
			$db->reset();

			echo json_encode(["code"=>true, "message"=>"Successful", "data"=>null]);
		}
	}

?>