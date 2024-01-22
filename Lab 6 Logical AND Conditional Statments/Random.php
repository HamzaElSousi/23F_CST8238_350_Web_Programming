<?php
include 'Header.php';
include 'Menu.php';
include 'Footer.php';

displayHeader();
displayMenu();

echo "<div style='margin-left: 210px; padding: 10px;'>";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ranges = [0, 0, 0, 0, 0];
    for ($i = 0; $i < 500; $i++) {
        $num = rand(1, 50);
        if ($num <= 10) $ranges[0]++;
        elseif ($num <= 20) $ranges[1]++;
        elseif ($num <= 30) $ranges[2]++;
        elseif ($num <= 40) $ranges[3]++;
        else $ranges[4]++;
    }

    $labels = [
        "01 - 10", "11 - 20", "21 - 30", "31 - 40", "41 - 50"
    ];

    for ($i = 0; $i < 5; $i++) {
        echo $ranges[$i] . " numbers are randomly generated in the range between " . $labels[$i] . "<br/>";
    }

    echo "Histogram of stars:<br/>";
    for ($i = 0; $i < 5; $i++) {
        $percentage = $ranges[$i] * 100 / 500;
        echo $labels[$i] . ": " . str_repeat('*', $percentage) . "<br/>";
    }
}

// Button to regenerate output
echo "<form method='post' action='Random.php'>";
echo "<input type='submit' value='Regenerate'>";
echo "</form>";

echo "</div>";

displayFooter();
?>
