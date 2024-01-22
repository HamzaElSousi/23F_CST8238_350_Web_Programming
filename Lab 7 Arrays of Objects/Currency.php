<?php include('Header.php'); ?>
<?php include('Menu.php'); ?>

<div class="content">
    <h2>Currency Converter</h2>

    <form method="post">
        <label for="srcamt">Conversion amount:</label>
        <input type="text" name="srcamt" id="srcamt" required>

        <label for="basecurr">Base currency:</label>
        <select name="basecurr" id="basecurr" required>
            <option value="CAD">Canadian Dollar</option>
            <option value="NZD">New Zealand Dollar</option>
            <option value="USD">US Dollar</option>
        </select>

        <label for="destcurr">Destination currency:</label>
        <select name="destcurr" id="destcurr" required>
            <option value="CAD">Canadian Dollar</option>
            <option value="NZD">New Zealand Dollar</option>
            <option value="USD">US Dollar</option>
        </select>

        <input type="submit" value="Convert">
    </form>

    <?php
    // Sub-Task: Handle the currency conversion form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $amount_input = $_POST["srcamt"];
        $basecurr = $_POST["basecurr"];
        $destcurr = $_POST["destcurr"];

        $currencies = array(
            "CAD" => "Canadian Dollar",
            "NZD" => "New Zealand Dollar",
            "USD" => "US Dollar"
        );

        $rates = array(
            "CAD" => 0.97645,
            "NZD" => 1.20642,
            "USD" => 1.0
        );

        $converted_output = ($amount_input / $rates[$basecurr]) * $rates[$destcurr];

        echo "<h3>Conversion Result:</h3>";
        echo "$amount_input {$currencies[$basecurr]} converts to $converted_output {$currencies[$destcurr]}";
    }
    ?>
</div>

<?php include('Footer.php'); ?>
