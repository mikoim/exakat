<?php

$expected     = array('for($i4 = 0 ; $i4 < 10 ; $i4++) { /**/ } ', 
                      'for($i3 = 0 ; $i3 < 10 ; $i3++) { /**/ } ', 
                      'for($i2 = 0 ; $i2 < 10 ; $i2++) { /**/ } ', 
                      'for($i1 = 0 ; $i1 < 10 ; $i1++) { /**/ } '
);

$expected_not = array('for($i5 = 0 ; $i5 < 10 ; $i5++) { /**/ } ');

?>