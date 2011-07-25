<html>
<?php
  /* Connexion à la base de données */
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
<?php
  /* Récupération des variables passées par le fomulaire */
  $vLogin=$_POST[login];
  $vChoix=$_POST[password];
  /* Inscription */
  $vSql="udapte tSession set fksession= numsession where  tGroupe.login=pklogin and tGroupe.apassword=password";
  $vQuery=pg_query($vConnect-> fConn, $vSql);
  echo "<p>Inscription de $vLogin à la session $vChoix validée</p>";
?>
  <hr/>
  <p><a href="inscription1.php">Retour</a></p>
</body>
</html>
Solution