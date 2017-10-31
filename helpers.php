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

    /**
     * Este helper sirve para generar los selects dinámicamente.
     *
     * @param $listaValores Array con los valores que debe mostrar el select
     * @param $seleccionados Array con los valores que debe seleccionar el select
     * @param $name String nombre de la clave que se pasará en el array $_POST
     * @param bool $multiple Bool Si el select va a admitir selección múltiple o no.
     *
     * @return string Código HTML del select
     */
    function generarSelect($listaValores, $seleccionados, $name, $multiple = false){
        $salida = '<select class="form-control" name="'.$name.($multiple?"[]":""). '"' . ($multiple?"multiple":"") .'>';

        if( !is_array($seleccionados) ){
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