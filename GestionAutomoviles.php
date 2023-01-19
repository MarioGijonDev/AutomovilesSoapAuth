<?php
/*
 * Servicio Web en PHP por Jose Hernández
 * https://josehernandez.es/2011/01/18/servicio-web-php.html
 * https://web.archive.org/web/20201026070426/https://josehernandez.es/2011/01/18/servicio-web-php.html
 */

class GestionAutomoviles {

    public function __construct(){

    }

    public function TestBD() {
        $con = $this->ConectarMarcas();
    }

    public function ConectarMarcas() {
        try {
            $user = "root";  // usuario con el que se va conectar con MySQL
            $pass = "459759";  // contraseña del usuario
            $dbname = "coches";  // nombre de la base de datos
            $host = "localhost";  // nombre o IP del host

            $db = new PDO("mysql:host=$host; dbname=$dbname", $user, $pass);  //conectar con MySQL y SELECCIONAR LA Base de Datos
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  //Manejo de errores con PDOException
            echo "<p>Se ha conectado a la BD $dbname.</p>\n";
            return $db;
        } catch (PDOException $e) {  // Si hubieran errores de conexión, se captura un objeto de tipo PDOException
            print "<p>Error: No se pudo conectar con la BD $dbname.</p>\n";
            print "<p>Error: " . $e->getMessage() . "</p>\n";  // mensaje de excepción

            exit();  // terminar si no hay conexión $db
        }
    }

    public function ObtenerMarcas() {
        $con = $this->ConectarMarcas();

        $marcas = array();
        if ($con) {
            $result = $con->query('select id, marca from marcas');

            while ($row = $result->fetch(PDO::FETCH_ASSOC))
                $marcas[$row['id']] = $row['marca'];
        }
        return $marcas;
    }

    public function ObtenerModelos($marca) {
        $marca = intVal($marca);
        $modelos = array();

        if ($marca !== 0) {
            $con = $this->ConectarMarcas();
            $con->query("SET CHARACTER SET utf8");

            if ($con) {
                $result = $con->query('select id, modelo from modelos ' .
                    'where marca = ' . $marca);

                while ($row = $result->fetch(PDO::FETCH_ASSOC))
                    $modelos[$row['id']] = $row['modelo'];
            }
        }

        return $modelos;
    }

    public function ObtenerMarcasUrl(){
        $con = $this->ConectarMarcas();

        $marcas_url = array();
        if ($con) {
            $result = $con->query('select marca, url from marcas');

            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                $marcas_url[$row['marca']] = $row['url'];
            }
        }
        return $marcas_url;
    }

    public function ObtenerModelosPorMarca($marca){
        $marca = strval($marca);
        $modelos = array();

        if ($marca !== 0) {
            $con = $this->ConectarMarcas();
            $con->query("SET CHARACTER SET utf8");

            if ($con) {
                $result = $con->query('SELECT id as id_modelos, modelo FROM modelos WHERE marca = (SELECT id FROM marcas where marca = "' . $marca . '")');

                $cont = 0;
                while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                    $modelos[$row['id_modelos']] = $row['modelo'];
                    $cont++;
                }

            }
        }

        return $modelos;
    }

    public static function authenticate($header_params) {

        if($header_params->username == 'ies' && $header_params->password == 'daw')
            return true;
        else
            throw new SoapFault('Wrong user/pass combination', 401);
   
    }
    
}
