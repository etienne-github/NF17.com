<html>
<?php
  /* Connexion � la base de donn�es */
  include "connect_class.php";
  $vConnect = new Connect;
  $vConnect->mConnect();
  include "inscription_param.php";
?>
<head>
  <title>Inscription Soutenance NF17</title>
</head>
<body>
  <h1>Inscriptions � la soutenance de NF17</h1>
<?php
  /* R�cup�ration des variables pass�es par le fomulaire */
  $vLogin=$_POST[login];
  $vChoix=$_POST[password];
  /* Inscription */
  $vSql="udapte tSession set fksession= numsession where  tGroupe.login=pklogin and tGroupe.apassword=password";
  $vQuery=pg_query($vConnect-> fConn, $vSql);
  echo "<p>Inscription de $vLogin � la session $vChoix valid�e</p>";
?>
  <hr/>
  <p><a href="inscription1.php">Retour</a></p>
</body>
</html>
Solution