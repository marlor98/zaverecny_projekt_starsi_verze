<?php

$DB_SERVER = 'localhost';
$DB_USER = 'root';
$DB_PASSWORD = '';

// Connect to mysqli
$conn = new mysqli($DB_SERVER,$DB_USER,$DB_PASSWORD);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql_database = "CREATE DATABASE IF NOT EXISTS zakaznici";
if ($conn->query($sql_database) === TRUE) {
  echo "Database created successfully<br>";
} else {
  echo "Error creating database: " . $conn->error;
}

// sql to create table
$sql_table = "CREATE TABLE IF NOT EXISTS zakaznici.zakaznici (
id int(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
jmeno varchar(50) NOT NULL,
prijmeni varchar(50) NOT NULL,
ulice varchar(100) NOT NULL,
cp int(10) UNSIGNED NOT NULL,
mesto varchar(30) NOT NULL,
psc int(10) UNSIGNED NOT NULL)";

if ($conn->query($sql_table) === TRUE) {
  echo "Table Zakaznici created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}

$sql = "INSERT INTO zakaznici.zakaznici (jmeno, prijmeni, ulice, cp, mesto, psc)
VALUES
('Adam', 'Bernau', 'Bernauova', 100, 'Bernauov', 12345),
('Adolf', 'Born', 'V Gmi', 254, 'Grňov', 66666),
('David', 'Davidov', 'Davidova', 200, 'Davidtown', 45678),
('Emil', 'Emilov', 'Emilova', 12, 'Emiltown', 78945),
('Cecil', 'Cecilov', 'Cecilova', 300, 'Cecilovtown', 65321);
";


if ($conn->query($sql) === TRUE) {
  echo "New records screated successfully<br>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
