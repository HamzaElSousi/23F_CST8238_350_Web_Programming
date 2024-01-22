<?php
// Define your first name and last name as PHP variables
$firstName = "Hamza";
$lastName = "El Sousi";

// Define the STUDENT_NUMBER constant
define("STUDENT_NUMBER", "040982818");

// Concatenate two strings and store the result in a variable
$concatenatedText = "Hello World!! " . "This is the first time I am using PHP!!";

// Get the length of the concatenated text
$textLength = strlen($concatenatedText);

// Find the position of the word "PHP" in the concatenated text
$phpPosition = strpos($concatenatedText, "PHP");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My PHP Website</title>
</head>
<body>
    <?php include 'Header.php'; ?>

    <div id="content" style="width: 85%; float: right; padding: 20px; box-sizing: border-box;">
        <p><?php echo $firstName . ' ' . $lastName; ?></p>
        <p>Student Number: <?php echo STUDENT_NUMBER; ?></p>
        <p><?php echo $concatenatedText; ?></p>
        <p>Length of Concatenated Text: <?php echo $concatenatedText; ?> <?php echo $textLength; ?></p>
        <p>Position of "PHP" in Text: <?php echo $concatenatedText; ?> <?php echo $phpPosition; ?></p>
    </div>

    <?php include 'Menu.php'; ?>
    <?php include 'Footer.php'; ?>
</body>
</html>
