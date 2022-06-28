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
		private $weight;
        private $type;
		private $height;
        private $width;
        private $length;
		private $size;
		private $id;

		public function __construct () {
			$this->conn = new \mysqli(self::$DB_SERVER, self::$DB_USERNAME, self::$DB_PASSWORD, self::$DB_DATABASE);
		}

		// Public == 
		public function __call($method,$args){
			// Do nothing ==
		}

		// Protected == 
		protected function validation ($fields) {
			foreach($fields as $field){
				if(empty($this->$field))
					$this->setError($field, "$field must be provided!");
				if($field == "sku" && !empty($this->$field) && $this->checkSKUExist($this->$field))
					$this->setError($field, "$field provided exists!");
			}
		}
		protected function checkSKUExist($data) {
			$q = "SELECT 1 FROM products WHERE sku = ?";
			$stmt = $this->conn->prepare($q);
			$stmt->bind_param("s", $data);
			$stmt->execute();
			$result = $stmt->get_result(); // $result is of type mysqli_result
			$num_rows = $result->num_rows;  // count number of rows in the result
			return $num_rows;
		}
		protected function setError ($key, $value){
			$this->error[$key] = $value;
		}
		protected function setSKU ($data) {
			$this->sku = trim($data);
		}
		protected function setName ($data) {
			$this->name = trim($data);
		}
		protected function setPrice ($data) {
			$this->price = trim($data);
		}
		protected function setType ($data) {
			$this->type = trim($data);
		}
		protected function setWeight ($data) {
			$this->weight = trim($data);
		}
		protected function setHeight ($data) {
			$this->height = trim($data);
		}
		protected function setWidth ($data) {
			$this->width = trim($data);
		}
		protected function setLength ($data) {
			$this->length = trim($data);
		}
		protected function setSize ($data) {
			$this->size = trim($data);
		}
		protected function setId ($data) {
			$this->id = trim($data);
		}
		protected function getSKU () {
			return $this->sku;
		}
		protected function getName () {
			return $this->name;
		}
		protected function getPrice () {
			return $this->price;
		}
		protected function getType () {
			return $this->type;
		}
		protected function getWeight () {
			return $this->weight;
		}
		protected function getHeight () {
			return $this->height;
		}
		protected function getWidth () {
			return $this->width;
		}
		protected function getLength () {
			return $this->length;
		}
		protected function getSize () {
			return $this->size;
		}
		protected function getId () {
			return $this->id;
		}

	}

?>