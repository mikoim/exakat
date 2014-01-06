<?php

namespace Report;

class Dataset {
    protected function escapeForMarkdown($value) {
        if (is_array($value)) {
            foreach($value as $id => $v) {
                $value[$id] = $this->escapeForMarkdown($v);
            }
            return $value;
        }
        
        $value = str_replace( "\n", '<BR />', $value );
        $value = str_replace('|', '\\|', $value);
        $value = str_replace('\\', '\\\\', $value);
        $value = str_replace('_', '\\_', $value);
        if (strlen($value) > 255) {
            $value = substr($value, 0, 250).' ...';
        }
        $value = str_replace("\n", '`<br />\n`', $value);

        return $value;
    }
}

?>