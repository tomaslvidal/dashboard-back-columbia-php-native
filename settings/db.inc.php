<?php
include("/www/docs/eflyco.com/db_settings.incEFLY.php");
connect_db();

global $res;
global $tot;
global $row;
global $connect;

function connect_db(){
	global $host;
	global $db;
	global $user;
	global $pass;
	global $connect;

	$connect=new mysqli($host, $user, $pass,$db);
	if($connect->connect_errno) {handle_error("Fallo conectar a MySQL (".$connect->connect_errno.") ".$connect->connect_error);}

	$connect->set_charset('utf8');

}

/*Función para hacer consultas*/
function db_query($i,$param){
	if($i==0){$i='';}
	global ${'tot'.$i};
	global ${'res'.$i};
	global $connect;
	global ${'row'.$i};

	${'res'.$i}=$connect->query($param);

	if(!${'res'.$i}) {handle_error($connect->error);}

	${'tot'.$i}=${'res'.$i}->num_rows;

	if (${'tot'.$i}>0){
		${'nres'.$i}=${'res'.$i}->data_seek(0);
		${'row'.$i}=${'res'.$i}->fetch_assoc();
	}
}

/*Función para hacer updates*/
function db_update($param){
	global $tot;
	global $connect;

	$res=$connect->query($param);
	if(!$res) {handle_error($connect->error);}else{$tot=1;}
}

/*Función para insertar un nuevo registro*/
function db_insert($param){
	global $tot;
	global $newid;
	global $connect;

	$res=$connect->query($param);
	$newid=mysqli_insert_id($connect);
	if(!$res) {handle_error($connect->error);}
}

/*Función para borrar dato/s*/
function db_delete($param){
	global $tot;
	global $connect;

	$res=$connect->query($param);
	if(!$res) {handle_error($connect->error);}
}

function cleanVar($param){
	$param = str_replace(' ','',$param);
	$param = str_replace('INSERT','',$param);
	$param = str_replace('UNION','',$param);
	$param = str_replace('SELECT','',$param);
	$param = str_replace('DELETE','',$param);
	$param = str_replace('*','',$param);
	$param = str_replace('[','',$param);
	$param = str_replace(']','',$param);
	$param = str_replace('-','',$param);
	$param = str_replace('&','',$param);
	$param = str_replace('\'','',$param);
	$param = str_replace('"','',$param);
	$param = addslashes($param);
	return $param;
}

function handle_error($perror){
	//mail("nbellosi@aptek.com.ar","Error en DB","Ocurrio el error: ".$perror,"");
	die("<b>Database Error:</b> ".$perror);
}
?>
