function opa()
{
    var liczba = document.getElementById("goscie").value
    var stan = document.getElementById("poprawiny").checked
    var osoba = 100
    var poprawiny = 130
    if (stan == true)
    {
        var koszt = poprawiny *  liczba
        var opcja1 =document.getElementById("wynik")
        opcja1.innerHTML = "koszt twojgo wesela to " +koszt+ " zlotych"
    }
    else
    {
        var koszt = osoba * liczba
        var opcja2 = document.getElementById("wynik")
        opcja2.innerHTML="koszt twojego wesela to " +koszt+ " zlotych"
    }
}