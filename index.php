<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* フラッシュメッセージのスタイル */
        .flash-message {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
            padding: 10px;
            border-radius: 5px;
            width: auto;
            max-width: 300px;
        }
        .flash-message.success {
            background-color: #48BB78;
            color: white;
        }
        .flash-message.error {
            background-color: #F56565;
            color: white;
        }
        /* フォームのスタイル */
        .form-container {
            display: flex;
            flex-direction: column; /* 子要素を縦方向に並べる */
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        /* URL欄とコピーボタンのスタイル */
        .url-container {
            display: none;
            margin-top: 5px; /* フォームとコピーボタンの間にスペースを作る */
        }
        /* プログレスバーのスタイル */
        #progressBarContainer {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #progressBar {
            height: 32px;
            width: 32px;
            border-radius: 50%;
            background-color: #48BB78;
            transition: width 0.5s;
        }
        #progressText {
            margin-top: 5px;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-800">
    <div class="form-container">
        <form id="uploadForm" action="upload.php" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto mt-10">
            <input type="file" name="file" id="fileInput" class="block w-full px-3 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
            <button type="submit" name="submit" class="w-full px-4 py-2 mt-3 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">アップロード</button>
        </form>
        <!-- プログレスバーのコンテナ -->
         <div id="progressBarContainer" class="mt-4">
             <div id="progressBar" class="w-32 h-32 rounded-full bg-gray-200"></div> 
             <div id="progressText" class="text-center text-gray-700">0%</div> 
         </div>
        <div id="urlContainer" class="url-container">
            <input type="text" id="fileUrl" class="block w-full px-3 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" readonly>
            <button id="copyUrlBtn" class="w-full px-4 py-2 mt-3 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">URLコピー</button>
        </div>
    </div>
    <script src="index.js"></script>
</body>
</html>