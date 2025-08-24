<?php
// データベース接続情報
$host = 'localhost';
$user = 'root';
$password = 'A53080000abab';
$dbname = 'GameDB';

// MySQLに接続
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// JSONデータの受け取り
$data = json_decode(file_get_contents('php://input'), true);
$final_score = intval($data['final_score']);
$player_name = htmlspecialchars($data['player_name']); // HTML特殊文字をエスケープ

if (empty($player_name)) {
    $player_name = "名無し";
}

// プリペアドステートメントでスコアとプレイヤー名を挿入
$stmt = $conn->prepare("INSERT INTO scores (player_name, score) VALUES (?, ?)");
$stmt->bind_param("si", $player_name, $final_score);

if ($stmt->execute()) {
    echo "スコアが記録されました！";
} else {
    echo "エラー: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>