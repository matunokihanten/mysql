// server.js
const express = require('express');
const app = express();
const http = require('http').createServer(app);
const io = require('socket.io')(http);
const port = 3000;

// public ディレクトリを静的ファイルとして指定
app.use(express.static('public'));

let scores = {};  // { socketID: { playerName, score } } の形式で保持

io.on('connection', (socket) => {
  console.log('User connected: ' + socket.id);

  // クライアントから参加通知を受信
  socket.on('joinGame', (data) => {
    const playerName = data.playerName && data.playerName.trim() !== "" ? data.playerName : "名無し";
    scores[socket.id] = { playerName: playerName, score: data.score || 0 };
    io.emit('scoreboard', scores);
    console.log("Player joined:", playerName);
  });

  // スコア更新イベント
  socket.on('updateScore', (data) => {
    if (scores[socket.id]) {
      scores[socket.id].score = data.score;
      io.emit('scoreboard', scores);
    }
  });

  // 切断時の処理
  socket.on('disconnect', () => {
    console.log('User disconnected:', socket.id);
    delete scores[socket.id];
    io.emit('scoreboard', scores);
  });
});

http.listen(port, () => {
  console.log('Server is listening on port ' + port);
});