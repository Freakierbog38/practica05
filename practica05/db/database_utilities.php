<?php
	require_once('database_credentials.php');

	//Se realiza la conexion a la base de datos, utilizando las constantes definidas en database_credentials.php
	function getPDO(){//Una instancia de PDO necesaria para la conexión con la Base de Datos
        $host = DB_HOST; //El host
        $dbname = DB_DATABASE; //El nombre de la base de datos
        $dbOtp = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'");// Habilitar el utf8 
        $pdoObj = new PDO("mysql:host={$host};dbname={$dbname};port=3307", DB_USER, DB_PASSWORD, $dbOtp); //Se crea la instancia
        return $pdoObj;// Y se regresa
    }

	//Funcion que permite agregar un nuevo usuario a la base de datos, requiere nombre y correo.
	function add($nombre,$correo){
		global $db;
		$db = getPDO();
		$stmt = $db->prepare("INSERT INTO user (nombre,correo) VALUES (:nombre,:correo)");
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':correo', $correo);
		$stmt->execute();
	}

	//Funcion que permite actualizar los atributos de un usuario existente, requiere nombre, correo y su id.
	function update($id,$nombre,$correo){
		global $db;
		$db = getPDO();
		$stmt = $db->prepare("UPDATE user SET nombre=:nombre, correo=:correo where id=:id");
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':correo', $correo);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
	}

	//Funcion que permite eliminar un usuario de la base de datos utilizando su id.
	function delete($id){
		global $db;
		$db = getPDO();
		$stmt = $db->prepare("DELETE FROM user where id=:id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
	}

	//Funcion que permite obtener todos los registros encontrados en la tabla usuarios de la base de datos.
	function get_all(){
		global $db;
		$db = getPDO();
		$stmt = $db->prepare("SELECT * FROM user");
		$stmt->execute();
		if($stmt->rowCount())
			return $stmt;
		return [];
	}

	//Funcion que permite realizar una busqueda de un usuario para obtener todos sus atributos mediante su id.
	function search($id){
		global $db;
		$db = getPDO();
		$stmt = $db->prepare("SELECT * FROM user where id=:id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		if($r = $stmt->fetch(PDO::FETCH_ASSOC))
			return $r;
		return [];
	}
?>