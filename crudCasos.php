<!doctype html>
<html lang="ca">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD 1.0</title>
  <link rel="stylesheet" href="fulla.css">


</head>

<body>
  <?php
  session_start(); //S'inicia o continua la sessió vigent
  include_once('connexio.php'); //S'inclou el fitxer de connexió a la base de dades
  if ($_SESSION['admin'] == 1) { //Si l'usuari vigent és administrador
    $tamany_pagines = 5;
    if (isset($_GET["pagina"])) {
      if ($_GET["pagina"] == 1) {
        header("Location:crudCasos.php");
      } else {
        $pagina = $_GET["pagina"];
      }
    } else {
      $pagina = 1;
    }
    $iniciar_des_de = ($pagina - 1) * $tamany_pagines;
    $sql_total = "select * from Casos";
    $resultat = $baseDades->prepare($sql_total);
    $resultat->execute(array());
    $num_files = $resultat->rowCount();
    $resultat->closeCursor();
    $total_pagines = ceil($num_files / $tamany_pagines);
    $connexio = $baseDades->query("select * from Casos limit $iniciar_des_de, $tamany_pagines");
    $registres = $connexio->fetchAll(PDO::FETCH_OBJ);
    $connexio->closeCursor();
    if (isset($_POST["cr"])) {
      $exp = $_POST["exp"];
      $desc = $_POST["desc"];
      $estat = $_POST["estat"];
      $idCli = $_POST["idCli"];
      $idAdv = $_POST["idAdv"];
      $idPro = $_POST["idPro"];
      $sql = "insert into Casos (expedient, descripció, estat, idClient, idAdvocat, idProcurador)
            values (:exp, :desc, :estat, :idCli, :idAdv, :idPro)";
      $resultat = $baseDades->prepare($sql);
      $resultat->execute(array(
        ":exp" => $exp, ":desc" => $desc, ":estat" => $estat, ":idCli" => $idCli,
        ":idAdv" => $idAdv, ":idPro" => $idPro
      ));
      $resultat->closeCursor();
      header("Location:crudCasos.php");
    }
  ?>
    <h1>CRUD 1.0<span class="subtitol"> Casos</span></h1>
    <h3 class="centrat">Introduïu les dades per crear un nou cas</h3>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <table width="50%" border="0" align="center">
        <tr>
          <td class="primera_fila">Id</td>
          <td class="primera_fila">Expedient</td>
          <td class="primera_fila">Descripció</td>
          <td class="primera_fila">Estat</td>
          <td class="primera_fila">Id Client</td>
          <td class="primera_fila">Id Advocat</td>
          <td class="primera_fila">Id Procurador</td>
          <td class="primera_fila">Data</td>
          <td class="sense">&nbsp;</td>
          <td class="sense">&nbsp;</td>
          <td class="sense">&nbsp;</td>
        </tr>
        <?php
        foreach ($registres as $cas) :
        ?>
          <tr>
            <td><?php echo $cas->id ?></td>
            <td><?php echo $cas->expedient ?></td>
            <td><?php echo $cas->descripció ?></td>
            <td><?php echo $cas->estat ?></td>
            <td><?php echo $cas->idClient ?></td>
            <td><?php echo $cas->idAdvocat ?></td>
            <td><?php echo $cas->idProcurador ?></td>
            <td><?php echo $cas->data ?></td>
            <td class="bot"><a href="esborraCasos.php?id=<?php echo $cas->id ?>">
                <input type='button' name='del' id='del' value='Esborrar'></a></td>
            <td class='bot'><a href="editaCasos.php?id=<?php echo $cas->id ?>
          &exp=<?php echo $cas->expedient ?>&desc=<?php echo $cas->descripció ?>
          &estat=<?php echo $cas->estat ?>&idCli=<?php echo $cas->idClient ?>
          &idAdv=<?php echo $cas->idAdvocat ?>&idPro=<?php echo $cas->idProcurador ?>">
                <input type='button' name='up' id='up' value='Editar'></a></td>
          </tr>
        <?php
        endforeach;
        ?>
        <tr>
          <td></td>
          <td><input type='text' name='exp' size='10' class='centrat'></td>
          <td><input type='text' name='desc' size='10' class='centrat'></td>
          <td><input type='text' name='estat' size='10' class='centrat'></td>
          <td><input type='text' name='idCli' size='10' class='centrat'></td>
          <td><input type='text' name='idAdv' size='10' class='centrat'></td>
          <td><input type='text' name='idPro' size='10' class='centrat'></td>
          <td class='bot'><input type='submit' name='cr' id='cr' value='Inserir'></td>
        </tr>
        <tr>
          <td><?php
              for ($i = 1; $i <= $total_pagines; $i++) {
                echo "<a href='?pagina=" . $i . "'>" . $i . "</a> ";
              }
              ?></td>
        </tr>
      </table>
    </form>
    <p>&nbsp;</p>
    <p class="centrat"><a href="index.php">Tornar enrere</a></p>
    <p class="centrat"><a href="tanca.php">Tancar la sessió</a></p>
  <?php
  } else { //Si per contra l'usuari vigent no és administrador
    echo "<h4>Aquest usuari no està autoritzat per administrar casos</h4>";
  }
  ?>
</body>

</html>