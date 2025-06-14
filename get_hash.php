<?php
// Simple script to generate a password hash

$password = 'Mama.123'; // The plain text password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

echo "The hashed password for 'Mama.123' is: <br>";
echo htmlspecialchars($hashed_password); // Display the hash
?> 