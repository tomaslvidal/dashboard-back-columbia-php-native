<?php
global $res;

global $tot;

global $row;

global $connect;

function connect_db(){
	global $dir_web_services;

	global $connect;

	$db="columbiaTest";

	$user="adminaptek";

	$pass="Tekap97db_new";

	$server="200.68.105.145";

	$connect=new mysqli($server, $user, $pass,$db);

	if($connect->connect_errno) {handle_error("Fallo conectar a MySQL (".$connect->connect_errno.") ".$connect->connect_error);}

	$connect->set_charset('utf8');
}

/*Funci�n para hacer consultas*/
function db_query($i,$param){
	if($i==0){$i='';}

	global ${'tot'.$i};

	global ${'res'.$i};

	global $connect;

	global ${'row'.$i};

	global $data;

	${'res'.$i}=$connect->query($param);

	if(!${'res'.$i}) {handle_error($connect->errno);}

	${'tot'.$i}=${'res'.$i}->num_rows;

	if (${'tot'.$i}>0){
		${'nres'.$i}=${'res'.$i}->data_seek(0);

		${'row'.$i}=${'res'.$i}->fetch_assoc();

		while (${'rowx'.$i} = ${'res'.$i}->fetch_assoc()){
	  		$data[] = ${'rowx'.$i};
		}
	}
}

/*Funci�n para hacer updates*/
function db_update($param){
	global $tot;

	global $connect;

	$res=$connect->query($param);

	if(!$res) {handle_error($connect->error);}else{$tot=1;}
}

/*Funci�n para insertar un nuevo registro*/
function db_insert($param){
	global $tot;

	global $newid;

	global $connect;

	$res=$connect->query($param);

	$newid=mysqli_insert_id($connect);

	if(!$res) {handle_error($connect->error);}
}

/*Funci�n para borrar dato/s*/
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
	
	header("HTTP/1.0 404 Not Found");
	
	die((string)$perror);
}

function vacioGuion($valor){
	if(trim($valor)==''){
		return ' - ';
	}
	else{
		return $valor;
	}
}
?>
