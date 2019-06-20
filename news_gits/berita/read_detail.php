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

$berita->id = isset($_GET['id']) ? $_GET['id'] : die();
 
$berita->readDetail();
 
if($berita->judul!=null){
    $berita_arr = array(
        "idBerita" =>  $berita->id,
        "kategori" => $berita->kategori,
        "tanggal" => $berita->tanggal,
        "judul" => $berita->judul,
        "author" => $berita->author,
        "thumbnail" => $berita->thumbnail,
        "berita" => $berita->detail
 
    );

    http_response_code(200);

    echo json_encode($berita_arr, JSON_UNESCAPED_SLASHES);
    /*
    $fp = fopen("../detail.json", "w");
    fwrite($fp, json_encode($berita_arr, JSON_UNESCAPED_SLASHES));
    fclose($fp);
    */
    }
    
else{
     http_response_code(404);
     
    echo json_encode(array("message" => "News does not exist."));
    /*$fp = fopen("../detail.json", "w");
    fwrite($fp, json_encode(array("message" => "News does not exist.")));
    fclose($fp);
    }*/
}
?>