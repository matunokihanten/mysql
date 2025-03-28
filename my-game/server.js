// server.js
const express = require('express');
const app = express();
const http = require('http').createServer(app);
const io = require('socket.io')(http);
const port = 3000;

// public フォルダ内の静的ファイルを配信
app.use(express.static('public'));

// プレイヤーのスコアと情報を保持するオブジェクト
let scores = {};

// Socket.IO 接続処理
io.on('connection', (socket) => {
  console.log('User connected: ' + socket.id);

  // ゲーム参加時のイベント
  socket.on('joinGame', (data) => {
    // クライアント側で送信されたプレイヤー名が空の場合は "名無し" を設定
    const playerName = data.playerName && data.playerName.trim() !== "" ? data.playerName : "名無し";
    scores[socket.id] = { playerName: playerName, score: data.score || 0 };
    io.emit('scoreboard', scores);
    console.log("Player joined:", playerName);
  });

  // クライアントからのスコア更新イベント
  socket.on('updateScore', (data) => {
    if (scores[socket.id]) {
      scores[socket.id].score = data.score;
      io.emit('scoreboard', scores);
    }
  });

  // クライアントの切断処理
  socket.on('disconnect', () => {
    console.log('User disconnected:', socket.id);
    delete scores[socket.id];
    io.emit('scoreboard', scores);
  });
});

// サーバー起動
http.listen(port, () => {
  console.log('Server is listening on port ' + port);
});