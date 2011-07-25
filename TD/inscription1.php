<html>

<?php

  include "connect_class.php";

 
 $vConnect = new Connect;
  $vConnect->mConnect();

  include "inscription_param.php";

?>

<head>

  <title>Inscription Soutenance NF17</title>

</head>

<body>

  <h1>Inscriptions à la soutenance de NF17</h1>

  <h2>Liste des créneaux horaires</h2>

  <table border="1">

    <tr>

      <td width="100pt"><b>Session</b></td>

      <td width="100pt"><b>Début</b></td>

      <td width="100pt"><b>Fin</b></td>

      <td width="100pt"><b>Places disponibles</b></td>

    </tr>

<?php

  $vSql ="Select pknum as n, datedebut as deb, datefin as fin,$CST_DISPO_SESSION - Count(fkSession) as places
  from tSession left join tgroupe ON TSession.pknum=tgroupe.fksession
GROUP BY  pknum, datedebut, datefin
Order by pknum;";

  $vQuery=pg_query($vConnect->fConn, $vSql);

  while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {

    echo "<tr>";

    echo "<td>Session $vResult[n]</td>";

    echo "<td>$vResult[deb]</td>";

    echo "<td>$vResult[fin]</td>";

    echo "<td>$vResult[places]</td>";

    echo "</tr>";

  }

  $vConnect->mClose();

?>

  </table>

  <hr/>

  <a href="inscription2.html">S'inscrire</a>

</body>

</html>