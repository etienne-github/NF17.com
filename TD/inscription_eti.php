<html>
<?php
include "connect_class_eti.php";
$vConnect = new Connect;
$vConnect->mConnect();
include "inscription_param_eti.php";
?>
<head>
<title>Inscription Soutenance NF17</title>
</head>
<body>
<h1>Inscriptions à la soutenance de NF17</h1>
<h2>Liste des creneaux horaires</h2>
<table border="1">
<tr>
<td width="100pt"><b>Session</b></td>
<td width="100pt"><b>Debut</b></td>
<td width="100pt"><b>Fin</b></td>
<td width="100pt"><b>Places disponibles</b></td>
</tr>
<?php
$vSql ="select pknum as n ,dateDebut as deb,dateFin as fin,$CST_DISPO_SESSION - count(fksession) as rest FROM tsession left join tGroupe ON tSession.pknum=tGroupe.fkSession Group by pknum,dateDebut,dateFin ORDER by pknum;";
    $vQuery=pg_query($vConnect->fConn, $vSql);
    while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
        echo "<tr>";
        echo "<td>Session $vResult[n]</td>";
        echo "<td>$vResult[deb]</td>";
        echo "<td>$vResult[fin]</td>";
        echo "<td>$vResult[rest]</td>";
        echo "</tr>";
    }
    $vConnect->mClose();
?>
</table>
<hr/>
<a href="inscription2.html">S'inscrire</a>
</body>
</html>