<?php

    function sanitizer($rType, $fFields, $fTypes){
        if (sizeof($fFields) != strlen($fTypes))
            return false;
        
        $returnFields = array(
            "___invalids" => array()
        );
        
        foreach ($fFields as $index => $field) {
            
            $rfValue = false;
            
            switch ($fTypes[$index]) {
                case 's':
                    $rfValue = checkValidity($rType, $field, 'toEscapedString');
                    break;
                case 'i':
                    $rfValue = checkValidity($rType, $field, 'toInt');
                    break;
                case 'f':
                    $rfValue = checkValidity($_FILES, $field, 'fileChecker');
            }
            
            if ($rfValue === false) {
                array_push($returnFields["___invalids"], $field);
            } else {
                $returnFields[$field] = $rfValue;
            }
        }
        
        return $returnFields;
    }
    
    /* FUNZIONI DI SUPPORTO A sanitizer */
    function checkValidity($array, $field, $action){
        if (isset($array[$field])) {
            $returnValue = $action($array[$field]);
            return $returnValue;
        }
        
        return false;
    }
    
    function toEscapedString($value){
        return htmlentities($value, ENT_COMPAT, 'UTF-8');
    }
    
    function toInt($value){
        if (is_numeric($value)) {
            return (int) $value;
        }
        return false;
    }
    
    function fileChecker($value){
        $uFile = reArrayFiles(array_filter($value));
        if(isset($uFile[0]["size"]) && $uFile[0]["size"] > 0){
            return $uFile;
        }
        
        return false;
    }
    
    
    /* FUNZIONI PER CONTROLLI APPLICATIVI */
    function checkForInvalids($form){
        if(sizeof($form["___invalids"]) > 0){
            return false;
        }
        return true;
    }
    
    function isInvalid($form, $field){
        if(in_array($field, $form["___invalids"])){
            return true;
        }
        return false;
    }
    
    function countInvalids($form){
        return sizeof($form["___invalids"]);
    }
?>
