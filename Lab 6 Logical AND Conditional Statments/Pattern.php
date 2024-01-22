<?php
include 'Header.php';
include 'Menu.php';
include 'Footer.php';

displayHeader();
displayMenu();

echo "<div style='margin-left: 210px; padding: 10px; height: calc(100vh - 120px); overflow-y: auto;'>";  // adjusted margin-left


// Setting the initial number of symbols
$numStars = 10;
$numDollars = 9;

while ($numStars >= 2) {
    // Printing stars
    for ($i = 0; $i < $numStars; $i++) {
        echo "*";
    }
    echo "<br/>";

    // Printing dollars
    for ($i = 0; $i < $numDollars; $i++) {
        echo "$";
    }
    echo "<br/>";

    $numStars -= 2;
    $numDollars -= 2;
}

echo "</div>";

displayFooter();
