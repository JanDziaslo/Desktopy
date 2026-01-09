function oblicz()
{
    var zielona = document.getElementById('zielona').checked
    var km = document.getElementById('km').value
    var wynik = document.getElementById('wynik')
    if (zielona == true)
    {
        wynik.innerHTML = "Dostawa za darmo"
    }
    else
    {
        var cena = km *2
        wynik.innerHTML = "Dowóz bedzie cie kosztowal: " + cena + " złotych"
    }
}