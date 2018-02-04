<?php  
	class Database {

		private $link;

		public function __construct() {
			$this->connect();
		}

		private function connect() {
			$config = require_once "config.php";
			$dsn = 'mysql:host='.$config['host'].';dbname='.$config['db_name'].';';
			$options = array(
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
			);
			$this->link = new PDO($dsn, $config['username'], $config['password'], $options);
		}

		public function insert($sql, $name, $comment) {
			$sth = $this->link->prepare($sql);
			$sth->execute(array(":name"=>$name,":comment"=>$comment));
		}

		public function num_rows_table($sql) {
			$sth = $this->link->prepare($sql);
			$sth->execute();
			$num_rows = $sth->rowCount();
			return $num_rows;
		}

		public function query($sql) {
			$sth = $this->link->prepare($sql);
			$sth->execute();
			$result = $sth->fetchAll(PDO::FETCH_ASSOC);

			if($result === false) {
				return [];
			}

			return $result;
		}
	}
?>