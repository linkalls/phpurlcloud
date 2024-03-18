// フラッシュメッセージを表示する関数
function showMessage(message, type) {
  // 既存のメッセージを削除
  var existingMessage = document.querySelector('.flash-message');
  if (existingMessage) {
       existingMessage.remove();
  }
 
  // 新しいメッセージ要素を作成
  var messageElement = document.createElement('div');
  messageElement.className = 'flash-message ' + type;
  messageElement.textContent = message;
  document.body.appendChild(messageElement);
 
  // 3秒後にメッセージを削除
  setTimeout(function() {
       messageElement.remove();
  }, 3000);
 }
 
 // URLをクリップボードにコピーする関数
 function copyToClipboard(text) {
     navigator.clipboard.writeText(text).then(function() {
         showMessage('URLがクリップボードにコピーされました', 'success');
     }, function(err) {
         showMessage('クリップボードにコピーできませんでした', 'error');
     });
 }
 
 document.addEventListener('DOMContentLoaded', function() {
  // フォーム送信イベントリスナーを設定
  document.getElementById('uploadForm').addEventListener('submit', function(event) {
       event.preventDefault(); // デフォルトのフォーム送信を防ぐ
 
       var formData = new FormData(this); // フォームデータを取得
 
       fetch('upload.php', {
           method: 'POST',
           body: formData
       })
       .then(response => response.json())
       .then(data => {
           if (data.success) {
               // アップロード成功時の処理
               document.getElementById('fileUrl').value = data.url; // URLをテキストボックスに設定
               document.getElementById('urlContainer').style.display = 'block';
               showMessage('ファイルがアップロードされました', 'success'); // 成功メッセージを表示
           } else {
               // アップロード失敗時の処理
               showMessage(data.message, 'error'); // エラーメッセージを表示
           }
       })
       .catch(error => {
           console.error('Error:', error);
           showMessage('エラーが発生しました', 'error'); // エラーメッセージを表示
       });
  });
 
  // 「URLコピー」ボタンにイベントリスナーを追加
  document.getElementById('copyUrlBtn').addEventListener('click', function() {
       copyToClipboard(document.getElementById('fileUrl').value);
  });
 });