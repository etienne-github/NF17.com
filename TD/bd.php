<html>

<body>

<table border="1">

<tr><td>A</td><td>B</td><td>C</td></tr>

<?php

  $vHost="tuxa.sme.utc";

  $vDbname="dbnf17p066";

  $vPort="5432";

  $vUser="nf17p066";

  $vPassword="CANUTa7q";

  $vConn = pg_connect("host=$vHost port=$vPort dbname=$vDbname user=$vUser password=$vPassword");

  $vSql ="SELECT a, b, c FROM t;";

  $vQuery=pg_query($vConn, $vSql);

  while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {

    echo "<tr>";

    echo "<td>$vResult[a]</td>";

    echo "<td>$vResult[b]</td>";
	
	echo "<td>$vResult[c]</td>";

    echo "</tr>";

  }

?>

</table>

</body>

</html>

