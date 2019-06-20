<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../object/berita.php';

$database = new Database();
$db = $database->getConnection();

$berita = new Berita($db);

$berita->kategori = isset($_GET['kategori']) ? $_GET['kategori'] : die();

$stmt = $berita->readByCategory();
$num = $stmt->rowCount();
 

if($num>0){
 

    $berita_arr=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
 
        $berita_item=array(
            "idBerita" => $id_berita,
            "kategori" => $kategori,
            "judul" => $judul,
            "tanggal" => $tanggal,
            "author" => $author,
            "thumbnail" => $thumbnail,
            "review" => $review
        );
 
        array_push($berita_arr, $berita_item);
    }
 
    http_response_code(200);
 
    echo json_encode($berita_arr, JSON_UNESCAPED_SLASHES);
    /*$fp = fopen("../category.json", "w");
    fwrite($fp, json_encode($berita_arr, JSON_UNESCAPED_SLASHES));
    fclose($fp);*/
}
else{
    http_response_code(404);
    
    echo json_encode(array("message" => "News Not Found"));
}
?>