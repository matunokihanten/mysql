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

$data = json_decode(file_get_contents('php://input'), true);
$player_name = isset($data['player_name']) && trim($data['player_name']) !== "" ? $data['player_name'] : '名無し';
$score = intval($data['score']);

// スコアを登録
$stmt = $conn->prepare("INSERT INTO leaderboard (player_name, score) VALUES (?, ?)");
$stmt->bind_param("si", $player_name, $score);
if ($stmt->execute()) {
    echo "スコアが記録されました！";
} else {
    echo "エラー: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>