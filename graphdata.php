<?php 

$db = mysqli_connect("127.0.0.1","DB_USERNAME","DB_PASS","ogreTrack");
    if (!$db) {
            die();
    }
mysqli_set_charset($db,"utf8mb4");

$pair = $_GET["pair"];

$stmt = $db->stmt_init();
$stmt->prepare("SELECT * FROM buybook WHERE tradePair = ?");
$stmt->bind_param("s",$pair);
$stmt->execute();


$statistic = array();

$result = $stmt->get_result();

while ($data = $result->fetch_assoc()) {

    $statistic[] = $data;

}

echo json_encode($statistic);

?>