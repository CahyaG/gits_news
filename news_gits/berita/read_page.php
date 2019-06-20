<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/paginate.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../object/berita.php';
 
$utilities = new Utilities();
 
$database = new Database();
$db = $database->getConnection();
 
$brt = new Berita($db);
 
$stmt = $brt->readPage($from_record_num, $records_per_page);
$num = $stmt->rowCount();

 
if($num>0){
 

    $berita_arr=array();
    $berita_arr_paging=array();
 

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
 
        $berita_item=array(
            "idBerita" => $id_berita,
            "judul" => $judul,
            "tanggal" => $tanggal,
            "thumbnail" => $thumbnail,
            "author" => $author,
            "review" => $review
        );
 
        array_push($berita_arr, $berita_item);
    }
 
    $total_rows=$brt->count();
    $page_url="{$home_url}berita/read_page.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $berita_arr_paging=$paging;
    array_push($berita_arr, $berita_arr_paging);
    http_response_code(200);
 
    echo json_encode($berita_arr, JSON_UNESCAPED_SLASHES);
}
 
else{
 
    http_response_code(404);
 
    echo json_encode(
        array("message" => "No news found.")
    );
}
?>