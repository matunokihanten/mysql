<?php
// データベース接続情報
$host = 'localhost';
$user = 'root';
$password = 'your_mysql_password';
$dbname = 'ゲームDB';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// スコアが高い順に並べ、上位 10 件を取得
$sql = "SELECT player_name, score, recorded_at FROM leaderboard ORDER BY score DESC LIMIT 10";
$result = $conn->query($sql);
$leaderboard = array();
while ($row = $result->fetch_assoc()) {
    $leaderboard[] = $row;
}
header('Content-Type: application/json');
echo json_encode($leaderboard);

$conn->close();
?>