<?php
	class Berita{
		private $conn;
	    private $table_name = "tb_berita";
	 

	    public $id;
	    public $kategori;
	    public $judul;
	    public $author;
	    public $tanggal;
	    public $detail;
	    public $review;
	    public $thumbnail;
	 
	    public function __construct($db){
	        $this->conn = $db;
	    }

	    function read(){
 
		    
		    $query = "SELECT
		                *
		              FROM 
		    			". $this->table_name ." b 
		    		  JOIN 
		    		  	tb_kategori k 
		    		  		ON 
		    		  			b.id_kategori=k.id_kategori
		    		  ORDER BY
		    		  	tanggal DESC";
		 
		    $stmt = $this->conn->prepare($query);
		 
		    $stmt->execute();
		 
		    return $stmt;
		}

		function readDetail(){
 
		    $query = "SELECT
		                *
		            FROM
		                " . $this->table_name . " b
		                JOIN
		                    tb_kategori k
		                        ON b.id_kategori = k.id_kategori
		            WHERE
		                b.id_berita = ?
		            LIMIT
		                0,1";
		 
		    $stmt = $this->conn->prepare( $query );
		 
		    $stmt->bindParam(1, $this->id);
		 
		    $stmt->execute();
		 
		    $row = $stmt->fetch(PDO::FETCH_ASSOC);
		 
		    $this->kategori = $row['kategori'];
		    $this->judul = $row['judul'];
		    $this->author = $row['author'];
		    $this->tanggal = $row['tanggal'];
		    $this->detail = $row['berita'];
		    $this->thumbnail = $row['thumbnail'];
		}

		function readByCategory(){
 
		    $query = "SELECT
		                *
		            FROM
		                " . $this->table_name . " b
		                JOIN
		                    tb_kategori k
		                        ON 
		                        	b.id_kategori = k.id_kategori
		            WHERE
		                k.kategori = ?";
		 
		    $stmt = $this->conn->prepare( $query );
		 
		    $stmt->bindParam(1, $this->kategori);
		 
		    $stmt->execute();

		    return $stmt;
		}

		function readPage($from_record, $record){
			$query = "SELECT
						*
					  FROM
					    ". $this->table_name." b
					  	JOIN
					  		tb_kategori k
					  			ON
					  				b.id_kategori=k.id_kategori
					  ORDER BY 
					  	b.tanggal DESC
					  LIMIT
					  	?,?";

		    $stmt = $this->conn->prepare( $query );
		    $stmt->bindParam(1, $from_record, PDO::PARAM_INT);
		    $stmt->bindParam(2, $record, PDO::PARAM_INT);
		    $stmt->execute();

		    return $stmt;

		}

		public function count(){
		    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
		 
		    $stmt = $this->conn->prepare( $query );
		    $stmt->execute();
		    $row = $stmt->fetch(PDO::FETCH_ASSOC);
		 
		    return $row['total_rows'];
		}
	}
?>