<?php
header('Content-Type: application/json');
function pfactor($n){
	// max_n = 2^31-1 = 2147483647
	$d=2;
	$factors = array();
	$dmax = floor(sqrt($n));
	$sieve = array();
	$sieve = array_fill(1, $dmax,1);
	do{
		$r = false;
		while ($n%$d==0){
			$factors[$d]++;
			$n/=$d;
			$r = true;
		}
		if ($r){
			$dmax = floor(sqrt($n));
		}
		if ($n>1){
			for ($i=$d;$i<=$dmax;$i+=$d){
				$sieve[$i]=0;
			}
			do{
				$d++;
			}while ($sieve[$d]!=1 && $d<$dmax);
			if ($d>$dmax){
				$factors[$n]++;
			}
		}
	}while($n>1 && $d<=$dmax);
	return $factors;
}

$query  = explode('&', $_SERVER['QUERY_STRING']);
$params = array();

foreach( $query as $param )
{
  list($name, $value) = explode('=', $param, 2);
  $params[urldecode($name)][] = urldecode($value);
}

if(count($params['number'])==1){
	$x = $_GET['number'];
	if(is_numeric($x)){
		if($x<1000000){
			$factors = pfactor($x);

			$f=array();
			foreach ($factors as $b=>$e){
				for($i=0;$i<$e;$i++){
					array_push($f,$b);
				}
			}

			$arr = array('number' => $x, 'decomposition' => $f);
		}else{
			$arr = array('number' => $x, 'error' => 'too big number (>1e6)');
		}
	}else{
		$arr = array('number' => $x, 'error' => 'not a number');
	}
	echo json_encode($arr);
}else{
	$semua = array();

	for($c=0;$c<count($params['number']);$c++){
		$x = $params['number'][$c];
		if(is_numeric($x)){
			if($x<1000000){
				$factors = pfactor($x);

				$f=array();
				foreach ($factors as $b=>$e){
					for($i=0;$i<$e;$i++){
						array_push($f,$b);
					}
				}

				$arr = array('number' => $x, 'decomposition' => $f);
			}else{
				$arr = array('number' => $x, 'error' => 'too big number (>1e6)');
			}
		}else{
			$arr = array('number' => $x, 'error' => 'not a number');
		}
		//echo json_encode($arr);
		array_push($semua,($arr));
	}
	echo json_encode($semua);
}
?>
