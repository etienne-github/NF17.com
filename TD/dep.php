<HTML>
<TITLE>Exercice</TITLE>
<HEAD><FONT SIZE="20"><B>Population par d�partement</B></FONT></HEAD>
<BR>
<BR>
<TABLE>
<TABLE BORDER="2">
<TR><TH>Num�ro</TH><TH>Nom</TH><TH>Population</TH></TR>
<?php

$vHost="tuxa.sme.utc";

  $vDbname="dbnf17p066";

  $vPort="5432";

  $vUser="nf17p066";

  $vPassword="CANUTa7q";

  $vConn = pg_connect("host=$vHost port=$vPort dbname=$vDbname user=$vUser password=$vPassword");

  $vSql ="SELECT num, nom, pop FROM dpt2;";

  $vQuery=pg_query($vConn, $vSql);

  while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {

    echo "<tr>";

    echo "<td>$vResult[num]</td>";

    echo "<td>$vResult[nom]</td>";
	
	echo "<td>$vResult[pop]</td>";

    echo "</tr>";

  }
?>
</TABLE>
<BR>
<BR>
<ul>
<?php
$vSql ="SELECT nom,pop from dpt2 where pop=(Select max(pop) from dpt2);";
$vQuery=pg_query($vConn, $vSql);
while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
echo "<li> D�partement le plus peupl� <B>$vResult[nom] (</B>$vResult[pop]<B>)</B></li>";
}
$vSql ="SELECT nom,pop from dpt2 where pop=(Select min(pop) from dpt2);";
$vQuery=pg_query($vConn, $vSql);
while ($vResult = pg_fetch_array($vQuery, null, PGSQL_ASSOC)) {
echo "<li> D�partement le moins peupl� <B>$vResult[nom] (</B>$vResult[pop]<B>)</B></li>";
}
?>
</ul>
</HTML>