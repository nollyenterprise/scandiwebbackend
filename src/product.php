<?php
	namespace Main\Product;
	require_once ROOT_PATH."/src/db.php";

	abstract class Products {

		protected $productType;
		protected $sku;
		protected $name;
		protected $price;
		protected $size;
		protected $height;
		protected $width;
		protected $length;
		protected $weight;
		protected $id;

		function __construct ($data) {
			foreach ($data as $key => $value) {
				# code...
				$get = htmlspecialchars($value);
				$get = stripslashes($get);
				$get = trim($get);
				$this->$key = "$get";
			}
		}

		// Protected ==
		protected function random_strings($length_of_string){
			$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
			return substr(str_shuffle($str_result), 0, $length_of_string);
		}
		protected function isEmpty($value){
			return (int)empty($value);
		}
		public function __set($property,$value){
			$this->$property = $value;
		}
		public function __get($property){
			return $this->$property;
		}
		public function __isset($property){
			return isset($this->$property);
		}
		
	}

?>