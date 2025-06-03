<?php
// koneksi.php - Database Connection Configuration
$host = 'localhost';
$port = 3308; 
$dbname = 'partisipasi_kelas';
$username = 'root'; // Sesuaikan dengan username database Anda
$password = '';   

// $host = 'sql102.infinityfree.com';
// $port = 3306; 
// $dbname = 'if0_39142544_partisipasi_kelas';
// $username = 'if0_39142544'; 
// $password = 'cZrTZEb2QXFOaz';    

try {
    // Create PDO connection
    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    
    // Set PDO attributes
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    // Set timezone
    $pdo->exec("SET time_zone = '+07:00'");
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage() . "\nPlease check your database configuration.");
}

// Function to get connection
function getConnection() {
    global $pdo;
    return $pdo;
}

// Function to close connection
function closeConnection() {
    global $pdo;
    $pdo = null;
}

// Test connection function
function testConnection() {
    try {
        global $pdo;
        $stmt = $pdo->query("SELECT 1");
        return true;
    } catch (PDOException $e) {
        return false;
    }
}
?>