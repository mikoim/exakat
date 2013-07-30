<?php

namespace Tokenizer;

class Staticproperty extends TokenAuto {
    static public $operators = array('T_DOUBLE_COLON');

    function _check() {
        $operands = array('Constant', 'String', 'Variable');
        
        $this->conditions = array( -1 => array('atom' => $operands), 
                                    0 => array('token' => Staticproperty::$operators),
                                    1 => array('atom' => array('Variable', 'Array')),
                                    2 => array('filterOut' => array('T_OPEN_PARENTHESIS')));
        
        $this->actions = array('makeEdge'   => array( -1 => 'CLASS',
                                                       1 => 'PROPERTY'),
                               'atom'       => 'Staticproperty');
        $this->checkAuto(); 

        return $this->checkRemaining();
    }
}

?>