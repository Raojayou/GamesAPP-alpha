<?php
    function dameDato($dato){
        echo '<pre>';
        print_r($dato);
        echo '</pre>';
    }

    function convierteCadena($array){
        return implode(", ", $array);
    }