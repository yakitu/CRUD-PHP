<!doctype html>
<html lang="ca">

<head>
  <meta charset="utf-8">
  <title>CRUD 1.0</title>
  <link rel="stylesheet" type="text/css" href="fulla.css">
</head>

<body>
  <h1>ACTUALITZAR</h1>
  <?php
  session_start(); //Continua la sessió vigent
  include_once('connexio.php'); //S'inclou el fitxer de connexió a la base de dades
  if ($_SESSION['admin'] == 1) { //Si l'usuari vigent és administrador
    if (isset($_GET['nom'])) { //Si a més està definida la variable nom en l'array global $_GET
      $nom = $_GET['nom'];
  ?>
      <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <table width="25%" border="0" align="center">
          <tr>
            <td>Contrasenya: </td>
            <td><input type="password" name="contrasenya" required></td>
          </tr>
          <tr>
            <td>Administrador? </td>
            <td><input type="checkbox" name="admin" value="1"></td>
          </tr>
          <tr>
            <td colspan='2'>
              <p id="boto"><input type="submit" name="Actualitzar" value="Actualitzar"></p>
            </td>
          </tr>
          <input type="hidden" name="nom" value="<?php echo $nom ?>">
        </table>
      </form>
  <?php
    }
    if (isset($_POST['Actualitzar'])) { //Si està definida la variable Actualitzar en l'array global $_POST
      if ($_POST['admin'] == 1) { //I si a més hi ha la variable admin amb el boolea true
        $admin = 1;
      } else { //sinó
        $admin = 0;
      }
      $nom = $_POST['nom'];
      $contrasenya = password_hash($_POST['contrasenya'], PASSWORD_DEFAULT); //S'encripta la contrasenya
      //Es fa la consulta preparada per evitar la injecció de codi maliciós
      $consulta = $baseDades->prepare("UPDATE usuari SET password = ?, admin = ? WHERE nom = ?");
      $consulta->bindParam(1, $contrasenya);
      $consulta->bindParam(2, $admin);
      $consulta->bindParam(3, $nom);
      $consulta->execute();
      $consulta->closeCursor();
      header("Location:crudUsuaris.php");
    }
  } else { //Si per contra l'usuari vigent no és administrador
    echo "<h4>Aquest usuari no està autoritzat per editar usuaris</h4>";
  }
  ?>
</body>

</html>