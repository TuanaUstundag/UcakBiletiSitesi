<?php
$host = 'localhost';
$port = '3306'; 
$dbname = 'ucak_bileti_db';
$username = 'root'; 
$password = ''; 

try {
    // Port bilgisini dsn stringine dahil
    $db = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Veritabanı yeni porttan bağlandı, uçuşa hazırız!"; 
} catch(PDOException $e) {
    die("Motorlar arızalandı: " . $e->getMessage());
}
?>