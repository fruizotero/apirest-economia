<?php

function splitAsociativeArray($array)
{

    $arrayKeys = [];
    $arrayValues = [];

    $finalArray = array();

    foreach ($array as $key => $value) {
        # code...
        array_push($arrayKeys, $key);
        array_push($arrayValues, $value);
    }


    $finalArray = array(
        "keys" => $arrayKeys,
        "values" => $arrayValues
    );


    return $finalArray;
}


