<?php

    function dameDato($dato){
        echo '<pre>';
        print_r($dato);
        echo '</pre>';
        die();
    }

    function convierteCadena($array){
        return implode(", ", $array);
    }

    function generarSelect($listaValores, $seleccionados, $name, $multiple = false){
        $salida = '<select class="form-control" name="'.$name.'" '. ($multiple?"multiple":"") .'>';

        if (!is_array($seleccionados)){
            $seleccionados = (array) $seleccionados;
        }
        foreach ($listaValores as $valor){
            $selected = "";
            if( in_array($valor, $seleccionados) ) $selected = " selected";
            $salida .= "<option value=\"{$valor}\"{$selected}>{$valor}</option>";
        }

        $salida .= '</select>';

        return $salida;
    }