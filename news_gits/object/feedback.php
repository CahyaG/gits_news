<?php
	class Feedback{
		private $conn;
		private $table_name = "tb_feedback";

		public $id;
		public $nama;
		public $rating;
		public $tanggal;
		public $deskripsi;

		public function __construct($db){
	        $this->conn = $db;
	    }

		function create(){
 
		    $query = "INSERT INTO
		                " . $this->table_name . "(nama, rating, deskripsi)
		              VALUES(?,?,?)";
		 
		    $stmt = $this->conn->prepare($query);
		 
		    $this->nama=htmlspecialchars(strip_tags($this->nama));
		    $this->rating=htmlspecialchars(strip_tags($this->rating));
		    $this->deskripsi=htmlspecialchars(strip_tags($this->deskripsi));
		 
		    $stmt->bindParam(1, $this->nama);
		    $stmt->bindParam(2, $this->rating);
		    $stmt->bindParam(3, $this->deskripsi);
		 
		    // execute query
		    if($stmt->execute()){
		        return true;
		    }
		 
		    return false;
		     
		}
	}
?>