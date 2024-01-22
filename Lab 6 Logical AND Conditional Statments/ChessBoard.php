<?php
include 'Header.php';
include 'Menu.php';
include 'Footer.php';

displayHeader();
displayMenu();

echo "<div style='margin-left: 210px; padding: 10px; height: calc(100vh - 120px); overflow-y: auto;'>";


for($i=0; $i<8; $i++) {
    echo "<div>";
    for($j=0; $j<8; $j++) {
        $color = (($i + $j) % 2 == 0) ? "white" : "black";
        echo "<span style='display: inline-block; width: 30px; height: 30px; background-color: $color;'></span>";
    }
    echo "</div>";
}

echo "</div>";

displayFooter();
echo "</div>";