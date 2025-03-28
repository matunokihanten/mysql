<?php
// データベース接続情報
$host = 'localhost';
$user = 'root';
$password = 'password';
$dbname = 'GameDB';

// JSONデータを受け取る
$data = json_decode(file_get_contents('php://input'), true);
$new_score = $data['new_score'];

// データベースに接続
$conn = new mysqli($host, $user, $password, $dbname);

// エラーがある場合
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// スコアを更新（例として、プレイヤーIDが1のユーザーのスコアを更新）
$sql = "UPDATE players SET score = $new_score WHERE player_id = 1";

if ($conn->query($sql) === TRUE) {
    echo "スコアが更新されました！";
} else {
    echo "エラー: " . $conn->error;
}

$conn->close();
?>