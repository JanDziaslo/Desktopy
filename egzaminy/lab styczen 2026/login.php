<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];

    if ($login === 'admin' && $haslo === 'TajneHaslo321*') {
        $_SESSION['uzytkownik'] = $login;
        header('Location: wyniki.php');
        exit;
    }
}
?>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zaloguj się</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <header>
        <h1>Portal laboratorium</h1>
    </header>

    <main>
        <div id="login-main">
            <h2>Zaloguj sie do systemu</h2>
            <form action="login.php" method="post">
                <label for="login">Login:</label>
                <input type="text" name="login" id="login"><br>
                <label for="haslo">Hasło: </label>
                <input type="password" name="haslo" id="haslo"><br>
                <button type="submit" name="zaloguj">Zaloguj</button>
            </form>
        </div>
    </main>

    <footer>
        <p>Wykonał: Jan Dziąsło</p>
    </footer>

</body>
</html>
