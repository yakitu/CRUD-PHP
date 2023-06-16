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
        header("Location:crudAdvocats.php");
      } else {
        $pagina = $_GET["pagina"];
      }
    } else {
      $pagina = 1;
    }
    $iniciar_des_de = ($pagina - 1) * $tamany_pagines;
    $sql_total = "select * from Advocats";
    $resultat = $baseDades->prepare($sql_total);
    $resultat->execute(array());
    $num_files = $resultat->rowCount();
    $resultat->closeCursor();
    $total_pagines = ceil($num_files / $tamany_pagines);
    $connexio = $baseDades->query("select * from Advocats limit $iniciar_des_de, $tamany_pagines");
    $registres = $connexio->fetchAll(PDO::FETCH_OBJ);
    $connexio->closeCursor();
    if (isset($_POST["cr"])) {
      $dni = $_POST["dni"];
      $nom = $_POST["nom"];
      $cog1 = $_POST["cog1"];
      $cog2 = $_POST["cog2"];
      $tel = $_POST["tel"];
      $ema = $_POST["ema"];
      $adr = $_POST["adr"];
      $ccpp = $_POST["ccpp"];
      $sql = "insert into Advocats (dni, nom, cognom1, cognom2, telèfon, email, adreça, CCPP)
            values (:dni, :nom, :cog1, :cog2, :tel, :ema, :adr, :ccpp)";
      $resultat = $baseDades->prepare($sql);
      $resultat->execute(array(
        ":dni" => $dni, ":nom" => $nom, ":cog1" => $cog1, ":cog2" => $cog2,
        ":tel" => $tel, ":ema" => $ema, ":adr" => $adr, ":ccpp" => $ccpp
      ));
      $resultat->closeCursor();
      header("Location:crudAdvocats.php");
    }
  ?>
    <h1>CRUD 1.0<span class="subtitol"> Advocats</span></h1>
    <h3 class="centrat">Introduïu les dades per crear un nou advocat</h3>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <table width="50%" border="0" align="center">
        <tr>
          <td class="primera_fila">Id</td>
          <td class="primera_fila">DNI</td>
          <td class="primera_fila">Nom</td>
          <td class="primera_fila">Cognom1</td>
          <td class="primera_fila">Cognom2</td>
          <td class="primera_fila">Telèfon</td>
          <td class="primera_fila">email</td>
          <td class="primera_fila">Adreça</td>
          <td class="primera_fila">Codi postal</td>
          <td class="sense">&nbsp;</td>
          <td class="sense">&nbsp;</td>
          <td class="sense">&nbsp;</td>
        </tr>
        <?php
        foreach ($registres as $advocat) :
        ?>
          <tr>
            <td><?php echo $advocat->id ?></td>
            <td><?php echo $advocat->dni ?></td>
            <td><?php echo $advocat->nom ?></td>
            <td><?php echo $advocat->cognom1 ?></td>
            <td><?php echo $advocat->cognom2 ?></td>
            <td><?php echo $advocat->telèfon ?></td>
            <td><?php echo $advocat->email ?></td>
            <td><?php echo $advocat->adreça ?></td>
            <td><?php echo $advocat->CCPP ?></td>
            <td class="bot"><a href="esborraAdvocats.php?id=<?php echo $advocat->id ?>">
                <input type='button' name='del' id='del' value='Esborrar'></a></td>
            <td class='bot'><a href="editaAdvocats.php?id=<?php echo $advocat->id ?>
          &dni=<?php echo $advocat->dni ?>&nom=<?php echo $advocat->nom ?>
          &cog1=<?php echo $advocat->cognom1 ?>&cog2=<?php echo $advocat->cognom2 ?>
          &tel=<?php echo $advocat->telèfon ?>&ema=<?php echo $advocat->email ?>
          &adr=<?php echo $advocat->adreça ?>&ccpp=<?php echo $advocat->CCPP ?>">
                <input type='button' name='up' id='up' value='Editar'></a></td>
          </tr>
        <?php
        endforeach;
        ?>
        <tr>
          <td></td>
          <td><input type='text' name='dni' size='10' class='centrat'></td>
          <td><input type='text' name='nom' size='10' class='centrat'></td>
          <td><input type='text' name='cog1' size='10' class='centrat'></td>
          <td><input type='text' name='cog2' size='10' class='centrat'></td>
          <td><input type='text' name='tel' size='10' class='centrat'></td>
          <td><input type='text' name='ema' size='10' class='centrat'></td>
          <td><input type='text' name='adr' size='10' class='centrat'></td>
          <td><input type='text' name='ccpp' size='10' class='centrat'></td>
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
    echo "<h4>Aquest usuari no està autoritzat per administrar advocats</h4>";
  }
  ?>
</body>

</html>