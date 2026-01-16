function opa()
{
    var liczba = document.getElementById("liczba").value;
    var wynik = document.getElementById("odp");

    function pierwsza(x)
    {
        if (x < 2) return false;
        for (var i = 2; i < x; i++)
        {
            if (x % i === 0) return false;
        }
        return true;
    }

    if (pierwsza(liczba))
    {
        var ktora = 0;
        for (var i = 2; i <= liczba; i++)
        {
            if (pierwsza(i)) ktora++;
        }

        if (pierwsza(ktora))
        {
            wynik.innerHTML = "Tak";
        } else
        {
            wynik.innerHTML = "Nie";
        }
    } else
    {
        wynik.innerHTML = "Nie";
    }
}
ss