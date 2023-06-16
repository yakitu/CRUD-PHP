<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD 1.0</title>
    <link rel="stylesheet" href="fulla.css">
</head>

<body>
    <?php //Inici etiquetes PHP
    session_start(); //S'inicia la sessió
    include('connexio.php'); //S'inclou el fitxer de connexió a la base de dades

    if (isset($_SESSION['usuari'])) { //Si està definida la variable usuari a l'array global $_SESSION
        if ($_SESSION['admin'] == 1) { //I si a més hi ha la variable admin amb el boolea true
            $rol = "Administrador";
        } else { //sinó
            $rol = "No administrador";
        }
        echo "<h1>CRUD 1.0<span class='subtitol'> Create Read Update Delete</span></h1>
              <h2 class='centrat'>Usuari: " . $_SESSION['usuari'] . " ($rol)</h2>";
        if ($rol == "Administrador") { //Si l'usuari és administrador
            echo "<br><br>
                <h3 class='centrat'>Administració dels CRUDs:</h3>
                <table align='center'>
                <td><a href='crudAdvocats.php'>
                <input type='button' value='CRUD Advovats'></a></td>
                <td><a href='crudCasos.php'>
                <input type='button' value='CRUD Casos'></a></td>
                <td><a href='crudClients.php'>
                <input type='button' value='CRUD Clients'></a></td>
                <td><a href='crudProcuradors.php'>
                <input type='button' value='CRUD Procuradors'></a></td>
                <td><a href='crudTasques.php'>
                <input type='button' value='CRUD Tasques'></a></td>
                <td><a href='crudUsuaris.php'>
                <input type='button' value='CRUD Usuaris'></a></td></table>
                <p class='centrat'><a href='tanca.php'>Tancar la sessió</a></p>";
        } else { //sinó
            echo "<br><br>
                <h3 class='centrat'>Administració de tasques:</h3>
                <table align='center'>
                <td><a href='crudTasques.php'>
                <input type='button' value='CRUD Tasques'></a></td></table>
                <p class='centrat'><a href='tanca.php'>Tancar la sessió</a></p>";
        }
        //Es tanca la base de dades
        $baseDades=null;
    } elseif (isset($_POST['usuari'])) { //Si per contra, està definida la variable usuari a l'array global $_POST
        $usuari = $_POST['usuari'];
        $contrasenya = $_POST['contrasenya'];
        //A part de crear variables amb les credencials introduïdes al formulari,
        //es fa la consulta preparada per evitar la injecció de codi maliciós
        $sql = "SELECT * FROM usuari WHERE nom = ?";
        $resultSet = $baseDades->prepare($sql);
        $resultSet->execute(array($usuari));
        $arrayRegistres = $resultSet->fetch(PDO::FETCH_ASSOC);
        $resultSet->closeCursor();
        //i es crea una altra inserint el resultat de la consulta en un array
        if (password_verify($contrasenya, $arrayRegistres['password'])) { //Si la contrasenya introduïda és correcta
            $_SESSION['usuari'] = $usuari; //es guarda el nom d'usuari dintre de la variable global $_SESSION
            $_SESSION['admin'] = $arrayRegistres['admin']; //i si és administrador o no
            header('Location: index.php'); //Es torna a carregar aquesta pàgina
        } else { //Si no és correcta la contrasenya introduïda
            echo "<h4>Usuari o contrasenya incorrectes</h4>";
        }
    }
    if (!isset($_SESSION['usuari'])) { //Si no està definida la variable usuari a l'array global $_SESSION
    ?>

        <h1>CRUD 1.0<span class='subtitol'> Create Read Update Delete</span></h1>
        <h3 class="centrat">Introduïu les credencials</h3>
        <form action="index.php" method="post">
            <table width="50%" border="0" align="center">
                <tr>
                    <td>Usuari: </td>
                    <td><input type="text" name="usuari" required></td>
                </tr>
                <tr>
                    <td>Contrasenya: </td>
                    <td><input type="password" name="contrasenya" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p id="boto"><input type="submit" value="Accedir"></p>
                    </td>
                </tr>
            </table>
        </form>

    <?php

    }
    ?>

</body>

</html>
