<?php

function matrixMultiply($N, $p, $q) {
    //init result
    $r = array();
    for($i=0; $i<$N; $i++) {
        $t = array();
        for($j=0; $j<$N; $j++) {
            $t[] = 0;            
        }
        $r[] = $t;        
    }
    
    //do the matrix multiply
    for($i=0; $i<$N; $i++) {
        for($j=0; $j<$N; $j++) {
            $t = 0;
            for($k=0; $k<$N; $k++) {
                $t += $p[$i][$k] * $q[$k][$j];   
            }            
            $r[$i][$j] = $t;
        }
    }
    
    //return result
    return $r;
}

function echoMatrix($N, $r) {
    for($i=0; $i<$N; $i++) {
        for($j=0; $j<=$N; $j++) {
            if ($j==$N)
                echo "<br>";
            else
                echo $r[$i][$j];
            if ($j<($N-1))
                echo ", ";            
        }   
    }    
}

$p = array();
$p[] = array(1,3,-4);
$p[] = array(1,1,-2);
$p[] = array(-1,-2,5);

$q = array();
$q[] = array(8,3,0);
$q[] = array(3,10,2);
$q[] = array(0,2,6);

echo "matrix 1<br/>";
echoMatrix(3, $p);
echo "<br/>";

echo "matrix 2<br/>";
echoMatrix(3, $q);
echo "<br/>";

$r = matrixMultiply(3, $p, $q);
echo "result of matrix multiply<br/>";
echoMatrix(3, $r);
?>
 