<?php
// データベース接続情報
$host = 'localhost';
$user = 'root';
$password = 'A53080000abab';
$dbname = 'GameDB';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// スコアの高い順に並べ、トップ10を取得
$query = "SELECT player_name, score, created_at FROM scores ORDER BY score DESC LIMIT 10";
$result = $conn->query($query);

$leaderboard = array();
while ($row = $result->fetch_assoc()) {
    $leaderboard[] = $row;
}
header('Content-Type: application/json');
echo json_encode($leaderboard);

$conn->close();
?>