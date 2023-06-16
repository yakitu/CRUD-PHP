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
  $tamany_pagines = 5;
  if (isset($_GET["pagina"])) {
    if ($_GET["pagina"] == 1) {
      header("Location:crudTasques.php");
    } else {
      $pagina = $_GET["pagina"];
    }
  } else {
    $pagina = 1;
  }
  $iniciar_des_de = ($pagina - 1) * $tamany_pagines;
  $sql_total = "select * from TODO";
  $resultat = $baseDades->prepare($sql_total);
  $resultat->execute(array());
  $num_files = $resultat->rowCount();
  $resultat->closeCursor();
  $total_pagines = ceil($num_files / $tamany_pagines);
  $connexio = $baseDades->query("select * from TODO limit $iniciar_des_de, $tamany_pagines");
  $registres = $connexio->fetchAll(PDO::FETCH_OBJ);
  $connexio->closeCursor();
  if (isset($_POST["cr"])) {
    $cre = $_POST["cre"];
    $nom = $_POST["nom"];
    $des = $_POST["des"];
    $est = $_POST["est"];
    $com = $_POST["com"];
    $sql = "insert into TODO (creador, nom, descripció, estat, comentaris)
            values (:cre, :nom, :des, :est, :com)";
    $resultat = $baseDades->prepare($sql);
    $resultat->execute(array(
      ":cre" => $cre, ":nom" => $nom, ":des" => $des, ":est" => $est, ":com" => $com
    ));
    $resultat->closeCursor();
    header("Location:crudTasques.php");
  }
  ?>
  <h1>CRUD 1.0<span class="subtitol"> Tasques</span></h1>
  <h3 class="centrat">Introduïu les dades per crear una nova tasca</h3>
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <table width="50%" border="0" align="center">
      <tr>
        <td class="primera_fila">Id</td>
        <td class="primera_fila">Creador</td>
        <td class="primera_fila">Nom</td>
        <td class="primera_fila">Descripció</td>
        <td class="primera_fila">Estat</td>
        <td class="primera_fila">Comentaris</td>
        <td class="sense">&nbsp;</td>
        <td class="sense">&nbsp;</td>
        <td class="sense">&nbsp;</td>
      </tr>
      <?php
      foreach ($registres as $tasca) :
      ?>
        <tr>
          <td><?php echo $tasca->id ?></td>
          <td><?php echo $tasca->creador ?></td>
          <td><?php echo $tasca->nom ?></td>
          <td><?php echo $tasca->descripció ?></td>
          <td><?php echo $tasca->estat ?></td>
          <td><?php echo $tasca->comentaris ?></td>
          <td class="bot"><a href="esborraTasques.php?id=<?php echo $tasca->id ?>">
              <input type='button' name='del' id='del' value='Esborrar'></a></td>
          <td class='bot'><a href="editaTasques.php?id=<?php echo $tasca->id ?>
          &cre=<?php echo $tasca->creador ?>&nom=<?php echo $tasca->nom ?>
          &des=<?php echo $tasca->descripció ?>&est=<?php echo $tasca->estat ?>
          &com=<?php echo $tasca->comentaris ?>">
              <input type='button' name='up' id='up' value='Editar'></a></td>
        </tr>
      <?php
      endforeach;
      ?>
      <tr>
        <td></td>
        <td><input type='text' name='cre' size='10' class='centrat'></td>
        <td><input type='text' name='nom' size='10' class='centrat'></td>
        <td><input type='text' name='des' size='10' class='centrat'></td>
        <td><input type='text' name='est' size='10' class='centrat'></td>
        <td><input type='text' name='com' size='10' class='centrat'></td>
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
</body>

</html>