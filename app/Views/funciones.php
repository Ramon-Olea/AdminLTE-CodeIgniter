<?php

/**
 * @author     🆁🅼🅽
 * @copyright 12/12/2022
 * 
 * 
 *$variable = isset($_POST['status_ac']) ? $_POST['status_ac'] : null;
 *   list($var1, $var2) = explode(',', $_POST['id_area']);
 */
/* delete('tabla_demo','id',$id); */
function precode($variable, $numero) //funcion para debuguear el codigo
{
	if ($numero == 0) { //si el mumero es cero imprime la variable y deja correr el programa
		print_r($variable);
	} else {
		print_r($variable); // si el numero es diferente a cero imprime la variable y detiene el programa despues de imprimir
		exit;
	}
}
/* function variable_isset($variable)//funcion para debuguear el codigo
{
    $v= isset($variable) ? $variable : null;
    return $v;

} */


function db_query($query)
{
	/*Datos para conexion*/
	$host = 'localhost';
	$db = 'AI-ML';
	$user = 'root';
	$pass = '';
	$conexion = new mysqli($host, $user, $pass, $db);

	$result = mysqli_query($conexion, $query);
	return $result;
}

// Crear La función Insertar
function insertar($tblname, $form_data)
{
	$fields = array_keys($form_data);
	$sql = "INSERT INTO " . $tblname . "(" . implode(',', $fields) . ")  VALUES('" . implode("','", $form_data) . "')";
	// precode($sql,0);
	return db_query($sql);
}

function delete($tblname, $field_id, $id)
{ //Funcion para borrar registros

	$sql = "delete from " . $tblname . " where " . $field_id . "=" . $id . "";

	return db_query($sql);
}
function consulta($sql)
{ //Funcion manda consultas y ejecuta 
	/* print_r($sql); */

	return  db_query($sql);
}
function select_where($tblname, $field_where, $field_id)
{ //Funcion para mostrar registros con where en la consulta
	$sql = "Select * from " . $tblname . " where " . $field_where . " = " . $field_id . " ";


	return  db_query($sql);
}
function select_where_in($tblname, $field_where, $field_id)
{ //Funcion para mostrar registros con where en la consulta
	$sql = "Select * from " . $tblname . " where " . $field_where . " IN ('" . $field_id . "') ";
	/* 	print_r($sql); */
	return  db_query($sql);
}
function select_where_in_mas($tblname, $field_where, $field_id)
{ //Funcion para mostrar registros con where en la consulta
	$sql = "Select * from " . $tblname . " where " . $field_where . " IN (" . $field_id . ") ";
	/* 	print_r($sql); */
	return  db_query($sql);
}
function select_todo($tblname)
{ //Funcion para mostrar  todos los registros 
	$sql = "Select * from " . $tblname . "  ";

	return  db_query($sql);
}


function select_dato_where($tblname, $field_where, $field_id)
{ //Funcion para mostrar un registro de la base de datos
	$sql = "Select * from " . $tblname . " where " . $field_where . " = " . $field_id . " ";
	$consulta =  db_query($sql);
	$regresa =  $consulta->fetch_array(MYSQLI_BOTH);
	return  $regresa;
}


/* 🆁🅼🅽*/


/* FIN HANNAS QUERYS */