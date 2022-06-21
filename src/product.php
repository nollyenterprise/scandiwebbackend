<?php
	namespace Main\Product;

	abstract class Products {
		protected $sku;
		protected $name;
		protected $price;
		protected $conn;
		protected $error = [];
		protected static $DB_SERVER = 'localhost';
		protected static $DB_USERNAME = 'root';
		protected static $DB_PASSWORD = '';
		protected static $DB_DATABASE = 'scandiwebjwd';

		function __construct () { }

		// Public == 
		public function setSKU ($data) {
			$this->sku = trim($data);
		}
		public function setName ($data) {
			$this->name = trim($data);
		}
		public function setPrice ($data) {
			$this->price = trim($data);
		}

		// Protected == 
		protected function getSKU () {
			return $this->sku;
		}
		protected function getName () {
			return $this->name;
		}
		protected function getPrice () {
			return $this->price;
		}

	}

?>