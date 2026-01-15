<?php

try {
     // 接続設定 (mysql:host=ホスト名;dbname=データベース名)
     $dsn = 'mysql:host=****;charset=utf8mb4';
     $pdo = new PDO($dsn, '****', '****');

     echo "✅ Success (PDO connection)";
} catch (PDOException $e) {
     echo "❌ Error: " . $e->getMessage();
}
phpinfo();
