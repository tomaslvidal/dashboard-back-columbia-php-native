<?
include($_SERVER["DOCUMENT_ROOT"]."/columbiaAPP/admin/settings/dirsGlobal.php");

include("{$dir}settings/db.inc.php");

connect_db();
/*
function redondear_dos_decimal($valor) {
	$float_redondeado=round($valor * 100) / 100;
	return $float_redondeado;
}

db_query(10,'select * from cambiodia');

$valorDolarAgregado = $row10['dolares'];
$valorEuroAgregado = $row10['euros'];

function cambioPesos($valor,$moneda,$reconversion=0){
	global $valorDolarAgregado;
	global $valorEuroAgregado;

	$AptekExchange = file_get_contents('http://apteknet.com/AptekExchange/AptekExchangeNew.php');
	$GetDataExchange = explode('|',$AptekExchange);

	$usd = $GetDataExchange[0];
	$eur = $GetDataExchange[1];

	$valorDolar = redondear_dos_decimal($usd);
	$valorEuro = redondear_dos_decimal($eur);
	$valorDolarSumado = $valorDolar+$valorDolarAgregado;
	$valorEuroSumado = $valorEuro+$valorEuroAgregado;

	$moneda = strtolower($moneda);

	if($reconversion==0){
		if($moneda == 'usd'){
			$cambio = $valor*$valorDolarSumado;
		}
		if($moneda == 'eur'){
			$cambio = $valor*$valorEuroSumado;
		}
		if($moneda == 'ars'){
			$cambio = $valor;
		}
	} else{
		if($moneda == 'usd'){
			$cambio = $valor;
		}
		if($moneda == 'eur'){
			$cambio = $valor/$valorDolarSumado;
		}
		if($moneda == 'ars'){
			$cambio = $valor/$valorDolarSumado;
		}

	}

	$cambio = number_format($cambio,2);

	if($reconversion==0){
		return 'ARS '.$cambio;
	}else{
		return 'USD '.$cambio;
	}
}*/
?>
