<?php
// データベース接続情報
$host = 'localhost';
$user = 'root';
$password = 'password';
$dbname = 'GameDB';

// 接続の確立
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// JSON形式のデータを受け取る
$data = json_decode(file_get_contents('php://input'), true);
$final_score = intval($data['final_score']);

// 今回は簡易的に「Player1」として保存（後でフォーム等でプレイヤー名の入力に拡張可能）
$player_name = 'Player1';

// プリペアドステートメントでスコアを挿入
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