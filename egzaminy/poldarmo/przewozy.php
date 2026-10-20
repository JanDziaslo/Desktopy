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