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
$x=$_GET['number']?$_GET['number']:16;
$factors = pfactor($x);

$f=array();
foreach ($factors as $b=>$e){
	for($i=0;$i<$e;$i++){
		array_push($f,$b);
	}
}

$arr = array('number' => $x, 'decomposition' => $f);
echo json_encode($arr);
?>
