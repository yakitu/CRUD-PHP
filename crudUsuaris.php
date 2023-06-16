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
    <?php
    session_start(); //S'inicia o continua la sessió vigent
    include_once('connexio.php'); //S'inclou el fitxer de connexió a la base de dades
    if ($_SESSION['admin'] == 1) { //Si l'usuari vigent és administrador
        if (isset($_POST['create'])) { //Si a més està definida la variable create en l'array global $_POST
            if (isset($_POST['admin'])) { //i si a més està definida la variable admin en l'array global $_POST
                $admin = 1;
            } else {
                $admin = 0;
            }
            $usuari = $_POST['usuari'];
            $contrasenya = password_hash($_POST['contrasenya'], PASSWORD_DEFAULT); //S'encripta la contrasenya
            //Es fa la consulta preparada per evitar la injecció de codi maliciós
            $sql = "SELECT * FROM usuari WHERE nom = ?";
            $resultSet = $baseDades->prepare($sql);
            $resultSet->execute(array($usuari));
            $arrayRegistres = $resultSet->fetch(PDO::FETCH_ASSOC);
            $resultSet->closeCursor();
            if (!isset($arrayRegistres[0])) { //Si no es troba cap registre amb aquest nom d'usuari
                //Es fa la consulta preparada amb marcadors per evitar la injecció de codi maliciós
                $sql = "insert into usuari (nom, password, admin) values (:nom, :password, :admin)";
                $resultSet = $baseDades->prepare($sql);
                $resultSet->execute(array(":nom" => $usuari, ":password" => $contrasenya, ":admin" => $admin));
                $resultSet->closeCursor();
                header('Location: crudUsuaris.php'); //Es torna a carregar la pàgina
            } else { //Si per contra es troba un registre amb aquest nom d'usuari
                echo "<h4>L'usuari $usuari està registrat ja a la base de dades, utilitzi un altre nom.</h4>";
            }
        } else { //Si no està definida la variable create en l'array global $_POST
            $resultSet = $baseDades->query("SELECT * FROM usuari");
    ?>
            <h1>CRUD 1.0<span class='subtitol'> Usuaris</span></h1>
            <h3 class="centrat">Introduïu les dades per crear un usuari nou</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <table width="50%" border="0" align="center">
                    <tr>
                        <td class="primera_fila">Nom</td>
                        <td class="primera_fila">Contrasenya</td>
                        <td class="primera_fila">Administrador</td>
                        <td class="sense">&nbsp;</td>
                        <td class="sense">&nbsp;</td>
                        <td class="sense">&nbsp;</td>
                    </tr>
                    <?php
                    while ($arrayRegistres = $resultSet->fetch(PDO::FETCH_ASSOC)) : //Mentre hi hagi registres per copiar, s'itera
                        if ($arrayRegistres['admin'] == 1) { //Si l'usuari de la base de dades és administrador
                            $administrador = "Sí";
                        } else { //sinó
                            $administrador = "No";
                        }
                    ?>
                        <tr>
                            <td><?php echo $arrayRegistres['nom']; ?></td>
                            <td>Encriptada</td>
                            <td><?php echo $administrador; ?></td>
                            <td class="bot"><a href="esborraUsuaris.php?nom=<?php echo $arrayRegistres['nom'] ?>">
                                    <input type="button" name="delete" id="del" value="Esborrar"></a></td>
                            <td class="bot"><a href="editaUsuaris.php?nom=<?php echo $arrayRegistres['nom'] ?>">
                                    <input type="button" name="update" id="up" value="Actualitzar"></a></td>
                        </tr>
                    <?php
                    endwhile; //Final del bucle
                    $resultSet->closeCursor();
                    ?>
                    <tr>
                        <td><input type="text" name="usuari" size="10" required></td>
                        <td><input type="password" name="contrasenya" size="10" required></td>
                        <td><input type="checkbox" name="admin" value="1"></td>
                        <td class="bot"><input type="submit" name="create" id="cr" value="Inserir"></td>
                    </tr>
                </table>
            </form>
            <p class="centrat"><a href="index.php">Tornar enrere</a></p>
            <p class="centrat"><a href="tanca.php">Tancar la sessió</a></p>
    <?php
        }
    } else { //Si per contra l'usuari vigent no és administrador
        echo "<h4>Aquest usuari no està autoritzat per administrar usuaris</h4>";
    }
    ?>
</body>

</html>