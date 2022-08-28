<?php
include "config.php";

function connect_db()
{
    return mysqli_connect("db", "user", "test", "myDb");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to mysql";
    }
}

function inscriptTab($prenom, $nom, $nbrePts, $numLicence, $club, $tableaux)
{
    global $tabValues;
    $cnx = connect_db();
    foreach ($tableaux as $i => $tableau) {
        if ($tableau != "") {
            if (1000 < $numLicence && $numLicence < 9999999) {
                $sql = "INSERT INTO $tableau (`prenom`, `nom`, `nombrePoints`, `numLicence`, `club`) VALUES (\"$prenom\",\"$nom\",$nbrePts,$numLicence,\"$club\")";
                $place = "SELECT count(*) as nbInscrits FROM $tableau";
                $result = mysqli_query($cnx, $place);
                $row = mysqli_fetch_assoc($result);
                $nameTab = substr($tableau, -1);
                $ptsMax = $tabValues[$tableau]["ptsMax"];
                $place = $tabValues[$tableau]["place"];
                if ($row["nbInscrits"] >= $place) {
                    echo $row["nbInscrits"];
                    echo "<h2 class='center'>Le tableau $nameTab est complet</h2>";
                } elseif ($nbrePts < $ptsMax) {
                    $res = $cnx->query($sql);
                    echo "<h2 class='center'>Vous êtes inscrit au tableau $nameTab</h2>";
                } else {
                    echo "<h2 class='center'>Vous n'avez pas le bon nombre de Points pour participer au tableau $nameTab</h2>";
                }
            } else {
                echo "<h2 class='center'>Le numéro de Licence est incorrecte</h2>";
            }
        }
    }
    mysqli_close($cnx);
}

function getPlace($tab)
{
    $cnx = connect_db();
    $sql = "SELECT count(*) as nbInscrits FROM $tab";
    $result = mysqli_query($cnx, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row["nbInscrits"];
    mysqli_close($cnx);
}

function printArrayPlayers($tab)
{
    $cnx = connect_db();
    $req = "SELECT `prenom`, `nom`, `nombrePoints`, `club` FROM $tab ORDER BY `nombrePoints` DESC";
    $res = $cnx->query($req);
    echo "<table>";
    echo "<tr><th>Nom</th><th>Prénom</th><th>Nombre de Points</th><th>Club</th>";
    while ($data = mysqli_fetch_array($res)) {
        echo "<tr><td>" .
            $data["nom"] .
            "</td><td>" .
            $data["prenom"] .
            "</td><td>" .
            $data["nombrePoints"] .
            "</td><td>" .
            $data["club"] .
            "</td></tr>";
    }
    echo "</table>";
    mysqli_close($cnx);
}

function execSqlFile($path)
{
    $cnx = connect_db();
    $sql=file_get_contents($path);
    $res = $cnx->query($sql);
    $row = mysqli_fetch_assoc($res);
    return $row["total"];
    mysqli_close($cnx);
}
function getRecipies()
{
    global $tabValues;
    $cnx = connect_db();
    foreach ($tabValues as $tableauName => $tableauObject) {
        $sql = "SELECT count(*) as nbInscrits FROM $tableauName";
        $result = mysqli_query($cnx, $sql);
        $row = mysqli_fetch_assoc($result);
        $total += $row["nbInscrits"] * $tableauObject["prixInscript"]; 
    }
    return $total;
    mysqli_close($cnx);
}
?>
