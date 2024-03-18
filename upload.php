<?php
session_start(); // セッションを開始

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $file = $_FILES['file'];
  $fileName = $_FILES['file']['name'];
  $fileTmpName = $_FILES['file']['tmp_name'];
  $fileError = $_FILES['file']['error'];

  // ファイルの拡張子を取得
  $fileExt = strtolower(end(explode('.', $fileName)));

  // 許可する拡張子のリスト
  $allowed = array('jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'mp4', 'webm', 'ogg',  'wav');

  if (in_array($fileExt, $allowed)) {
    if ($fileError === 0) {
      // ファイル名をランダムに生成
      $fileNameNew = md5(uniqid('', true)).".".$fileExt;
      // ファイル形式に応じて保存先ディレクトリを変更
      $fileDestination = in_array($fileExt, ['mp4', 'webm', 'ogg', 'wav']) ? 'video/' . $fileNameNew : 'img/' . $fileNameNew;

      // 保存先ディレクトリが存在しない場合、ディレクトリを作成
      $dir = dirname($fileDestination);
      if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
      }

      if (move_uploaded_file($fileTmpName, $fileDestination)) {
        // JPEG, PNG, GIF, WebP画像の場合、EXIFデータを削除
        if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
          $img = imagecreatefromstring(file_get_contents($fileDestination));
          if ($img) {
            // 画像を再度保存
            switch ($fileExt) {
              case 'jpg':
              case 'jpeg':
                imagejpeg($img, $fileDestination, 100);
                break;
              case 'png':
                imagepng($img, $fileDestination, 9);
                break;
              case 'webp':
                imagewebp($img, $fileDestination, 100);
                break;
              case 'gif':
                imagegif($img, $fileDestination);
                break;
            }
            imagedestroy($img);
          }
        }

        // サーバーのドメイン名を取得
        $domain = $_SERVER['HTTP_HOST'];
        // 成功メッセージとURLをJSON形式で出力
        echo json_encode([
          'success' => true,
          'message' => 'ファイルがアップロードされました',
          'url' => "https://".$domain."/".$fileDestination
        ]);
      } else {
        // ファイル移動に失敗した場合のメッセージをJSON形式で出力
        echo json_encode(['success' => false, 'message' => 'ファイルの移動に失敗しました']);
      }
    } else {
      // ファイルアップロードに失敗した場合のメッセージをJSON形式で出力
      echo json_encode(['success' => false, 'message' => 'ファイルのアップロードに失敗しました']);
    }
  } else {
    // 許可されていないファイル形式のメッセージをJSON形式で出力
    echo json_encode(['success' => false, 'message' => '許可されていないファイル形式です']);
  }
}
?>