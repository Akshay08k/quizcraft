<?php

// If you want to use an environment variable for the connection string, you can do:
// $uri = getenv('DATABASE_URL');
// For now, hardcode the Aiven connection string as in your example:
$uri = "postgres://avnadmin:AVNS_sEx0LecECB8TqXlrPpl@pg-205888ec-donateravengers-f443.i.aivencloud.com:26172/defaultdb";

$fields = parse_url($uri);

// Build the DSN including SSL settings
$connStr = "pgsql:";
$connStr .= "host=" . $fields["host"];
$connStr .= ";port=" . $fields["port"];
$connStr .= ";dbname=" . ltrim($fields["path"], '/');

try {
    $conn = new PDO($connStr, $fields["user"], $fields["pass"]);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


