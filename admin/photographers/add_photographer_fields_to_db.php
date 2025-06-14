<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/db.php';

echo "Attempting to add new columns to photographers table...<br>";

$sql_location = "ALTER TABLE photographers ADD COLUMN location VARCHAR(255) NULL AFTER bio";
$sql_experience = "ALTER TABLE photographers ADD COLUMN years_experience INT NULL AFTER location";
$sql_rating = "ALTER TABLE photographers ADD COLUMN rating DECIMAL(3,2) NULL AFTER years_experience";

$success = true;

if (mysqli_query($db, $sql_location)) {
    echo "Column 'location' added successfully.<br>";
} else {
    if (strpos(mysqli_error($db), 'Duplicate column name') !== false) {
        echo "Column 'location' already exists.<br>";
    } else {
        echo "Error adding column 'location': " . mysqli_error($db) . "<br>";
        $success = false;
    }
}

if (mysqli_query($db, $sql_experience)) {
    echo "Column 'years_experience' added successfully.<br>";
} else {
    if (strpos(mysqli_error($db), 'Duplicate column name') !== false) {
        echo "Column 'years_experience' already exists.<br>";
    } else {
        echo "Error adding column 'years_experience': " . mysqli_error($db) . "<br>";
        $success = false;
    }
}

if (mysqli_query($db, $sql_rating)) {
    echo "Column 'rating' added successfully.<br>";
} else {
    if (strpos(mysqli_error($db), 'Duplicate column name') !== false) {
        echo "Column 'rating' already exists.<br>";
    } else {
        echo "Error adding column 'rating': " . mysqli_error($db) . "<br>";
        $success = false;
    }
}

if ($success) {
    echo "Database update process completed.";
} else {
    echo "Database update process encountered errors.";
}

mysqli_close($db);
?> 