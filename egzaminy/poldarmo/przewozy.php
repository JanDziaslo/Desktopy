<?php
$polaczenie = mysqli_connect("100.110.228.126", "root", "M2xjEm9f57R34Xub48xtH5cT56FLv7sq","przewozy", 13306);

$zapytanie = "SELECT id_zadania, zadanie, data FROM zadania;";
$wynik = mysqli_query($polaczenie, $zapytanie);

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $zapytanie3 = "DELETE FROM zadania WHERE id_zadania = $id;";
    mysqli_query($polaczenie, $zapytanie3);

}
if (isset($_POST['zadanie'])) {
    if (isset($_POST['data'])) {
        $zadanie = $_POST['zadanie'] ?? '';
        $data = $_POST['data'] ?? '';
        $zapytanie2 = "INSERT INTO zadania (zadanie, data, osoba_id) VALUES ('$zadanie', '$data', 1);";
        mysqli_query($polaczenie,$zapytanie2);
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Firma Przewozowa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Firma przewozowa Półdarmo</h1>
    </header>

    <nav>
        <a href="kw1.png">kwarenda1</a>
        <a href="kw2.png">kwarenda2</a>
        <a href="kw3.png">kwarenda3</a>
        <a href="kw4.png">kwarenda4</a>
    </nav>

    <main>
        <section id="lewy">
            <h2>Zadania do wykonania</h2>
            <table>
                <tr>
                    <td>Zadanie do wykonania</td>
                    <td>Data realizacji</td>
                    <td>Usuń</td>
                </tr>
                <?php
                while($wiersz = mysqli_fetch_array($wynik)) {
                    echo "<tr>";
                    echo "<th>" . $wiersz['zadanie']. "</th>";
                    echo "<th>" . $wiersz['data'] . "</th>";
                    echo '<th> <a href="?id=' .$wiersz["id_zadania"] .  '">Usuń</a>'. "</th>";
                    echo "</tr>";
                }


                ?>
            </table>
            <form action="przewozy.php" method="post">
                <label for="zadanie">Zadanie do wykonania</label>
                <input type="text" name="zadanie" id="zadanie">
                <label for="data">Data realizacji</label>
                <input type="date" name="data" id="data">
                <button type="submit">Dodaj</button>
            </form>
        </section>

        <section id="prawy">
            <img src="auto.png" alt="auto firmowe">
            <h3>Nasza spcjalność</h3>
            <ol>
                <li>Przeprowadzki</li>
                <li>Przewóz mebli</li>
                <li>Przesyłki gabarytowe</li>
                <li>Wynajem pojazdów</li>
                <li>Zakupy towarów</li>
            </ol>
        </section>
    </main>

    <footer>
        <p>Stronę wykonał: Jan Dziąsło</p>
    </footer>
</body>
</html>
<?php
mysqli_close($polaczenie);
?>
