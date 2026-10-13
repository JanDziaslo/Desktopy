<html lang=pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cwiczenie 1</title>
</head>
<body>
<form action="zad1.php" method="get">
    <label for="samochod">markę samochodu</label>
    <input type="text" name="samochod" id="samochod">
    <label for="rok">Rok produkcji</label>
    <input type="text" name="rok" id="rok">
    <button type="submit">opa</button>
</form>
</body>
</html>
<?php
if (isset($_SERVER['REQUEST_METHOD']) == 'get') {
    $marka = $_GET['samochod'] ?? '';
    $rok = $_GET['rok'] ?? '';
    echo 'Samochód: '. $marka . '</br>' ;
    echo 'Rok produkcji: ' . $rok;
}

?>
