<?php
	namespace Main\Product\Actions;
	require_once ROOT_PATH."/src/product.php";
	require_once ROOT_PATH."/src/db.php";

	use Main\Product\Products as Products;
	use Main\Db\db as db;
	
	class Get extends Products {
		// Private ==

		// Public ==
		public function main() {
			$db = db::_g();
			$db->reset();
			$db->use_db('tekxsacd_scandiwebjwd');

			$sql = "SELECT `id`,`name`, `sku`, `price`, `type`,
			(
				CASE
					WHEN `type` = 'DVD' 
					THEN (SELECT concat('Size: ', size,' MB') FROM dvd WHERE id_product = a.id)
					WHEN `type` = 'Book' 
					THEN (SELECT concat('Weight: ', weight,' KG') FROM book WHERE id_product = a.id)
					WHEN `type` = 'Furniture' 
					THEN (SELECT concat('Dimension: ', height,'x', width,'x', Length) FROM furniture WHERE id_product = a.id)
					ELSE ''
				END
			) AS prodType
			FROM products a ORDER BY id DESC";
			$db->q($sql);
			$rows = $db->get_assoc_rows();
			$db->reset();

			echo json_encode(["code"=>true, "message"=>"Successful", "data"=>$rows]);
		}
	}

?>