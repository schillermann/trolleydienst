<h2>Neue Schichten</h2>
<div class="container-center">
    <form action="index.php?Type=Termine" method="post">
        <table border="0" cellspacing="0">
            <colgroup>
                <col width="150">
                <col width="150">
            </colgroup>
            <tbody><tr>
                <td>Schichtart:</td>
                <td>
                    <select name="Art">
                        <option value="0">Infostand</option>
                        <option value="1" selected="">Trolley</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Ort:</td>
                <td><input type="text" name="ort" size="30"></td>
            </tr>
            <tr>
                <td>Datum:</td>
                <td><input type="date" name="Datum" size="30"></td>
            </tr>
            <tr>
                <td>von:</td>
                <td><input type="time" name="von" size="30" value="10:00"></td>
            </tr>
            <tr>
                <td>bis:</td>
                <td><input type="time" name="bis" size="30" value="18:00"></td>
            </tr>
            <tr>
                <td>Sonderschicht:</td>
                <td><input type="checkbox" name="Sonderschicht" value="Sonderschicht"></td>
            </tr>
            <tr>
                <td>Stundenanzahl:</td>
                <td><input type="number" name="Stundenanzahl" size="30" value="1"></td>
            </tr>
            <tr>
                <td>Terminserie bis zum:</td>
                <td><input type="date" name="Terminserie" size="30"></td>
            </tr>
            </tbody></table>
        <input type="Submit" name="SaveNewDS" value="Speichern">
    </form>
</div>