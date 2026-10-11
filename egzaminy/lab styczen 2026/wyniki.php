<?php
session_start();

if (!isset($_SESSION['uzytkownik'])) {
    header("Location: login.php");
    exit;
}
else {
    $uzytkownik = $_SESSION['uzytkownik'];

    $p = mysqli_connect('100.110.228.126', 'root', 'M2xjEm9f57R34Xub48xtH5cT56FLv7sq', 'laboratorium', '13306');
    $zapytanie = "SELECT Pacjent.imie, Pacjent.nazwisko, Pacjent.pesel, Zlecenie.data AS data_zlecenia, Wynik.data AS data_wyniku, Wynik.plik FROM Zlecenie JOIN Pacjent ON Zlecenie.idPacjenta = Pacjent.id LEFT JOIN Wynik ON Wynik.idZlecenia = Zlecenie.id ORDER BY Zlecenie.id;";
    $wynik = mysqli_query($p,$zapytanie);
}
?>

<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Przeglądaj wyniki</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <header>
        <h1>Portal laboratorium</h1>
        <p><?php echo "Witaj, <strong>$uzytkownik</strong> ";  ?></p>
        <p><a href="wyloguj.php">Wyloguj</a></p>
    </header>

    <main>
        <h2>Wyniki pacjentów</h2>
        <div id="tabela">
            <table>
                <tr>
                    <th>Imię pacjenta</th>
                    <th>Nazwisko pacjenta</th>
                    <th>PESEL</th>
                    <th>Data zlecenia</th>
                    <th>Data wykonania</th>
                    <th>Wynik</th>
                </tr>
                <?php while ($wiersz = mysqli_fetch_array($wynik)): ?>
                    <tr>
                        <td><?= $wiersz['imie'] ?></td>
                        <td><?= $wiersz['nazwisko'] ?></td>
                        <td><?= $wiersz['pesel'] ?></td>
                        <td><?= $wiersz['data_zlecenia'] ?></td>
                        <td><?= $wiersz['data_wyniku'] ?></td>
                        <td>
                            <?php if (!empty($wiersz['plik'])): ?>
                                <a href="pliki20/<?= $wiersz['plik'] ?>" target="_blank" rel="noopener">wynik</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </main>

    <footer>
        <p>Wykonał: Jan Dziąsło</p>
    </footer>

</body>
</html>
<?php
    mysqli_close($p);
?>