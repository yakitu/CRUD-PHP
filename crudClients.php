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
        header("Location:crudClients.php");
      } else {
        $pagina = $_GET["pagina"];
      }
    } else {
      $pagina = 1;
    }
    $iniciar_des_de = ($pagina - 1) * $tamany_pagines;
    $sql_total = "select * from Clients";
    $resultat = $baseDades->prepare($sql_total);
    $resultat->execute(array());
    $num_files = $resultat->rowCount();
    $resultat->closeCursor();
    $total_pagines = ceil($num_files / $tamany_pagines);
    $connexio = $baseDades->query("select * from Clients limit $iniciar_des_de, $tamany_pagines");
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
      $sql = "insert into Clients (dni, nom, cognom1, cognom2, telèfon, email, adreça, CCPP)
            values (:dni, :nom, :cog1, :cog2, :tel, :ema, :adr, :ccpp)";
      $resultat = $baseDades->prepare($sql);
      $resultat->execute(array(
        ":dni" => $dni, ":nom" => $nom, ":cog1" => $cog1, ":cog2" => $cog2,
        ":tel" => $tel, ":ema" => $ema, ":adr" => $adr, ":ccpp" => $ccpp
      ));
      $resultat->closeCursor();
      header("Location:crudClients.php");
    }
  ?>
    <h1>CRUD 1.0<span class="subtitol"> Clients</span></h1>
    <h3 class="centrat">Introduïu les dades per crear un client nou</h3>
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
        foreach ($registres as $client) :
        ?>
          <tr>
            <td><?php echo $client->id ?></td>
            <td><?php echo $client->dni ?></td>
            <td><?php echo $client->nom ?></td>
            <td><?php echo $client->cognom1 ?></td>
            <td><?php echo $client->cognom2 ?></td>
            <td><?php echo $client->telèfon ?></td>
            <td><?php echo $client->email ?></td>
            <td><?php echo $client->adreça ?></td>
            <td><?php echo $client->CCPP ?></td>
            <td class="bot"><a href="esborraClients.php?id=<?php echo $client->id ?>">
                <input type='button' name='del' id='del' value='Esborrar'></a></td>
            <td class='bot'><a href="editaClients.php?id=<?php echo $client->id ?>
          &dni=<?php echo $client->dni ?>&nom=<?php echo $client->nom ?>
          &cog1=<?php echo $client->cognom1 ?>&cog2=<?php echo $client->cognom2 ?>
          &tel=<?php echo $client->telèfon ?>&ema=<?php echo $client->email ?>
          &adr=<?php echo $client->adreça ?>&ccpp=<?php echo $client->CCPP ?>">
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
    echo "<h4>Aquest usuari no està autoritzat per administrar clients</h4>";
  }
  ?>
</body>

</html>