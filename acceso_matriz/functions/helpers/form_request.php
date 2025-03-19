
<?php

function inputMaxLenght($string, $lenght)
{
    return strlen((string)$string) > 0 && strlen((string)$string) > $lenght;
}


function inputMinLenght($string, $lenght)
{
    return strlen((string)$string) > 0 && strlen((string)$string) < $lenght;
}


function inputMatched($regex, $string)
{
    return preg_match($regex, $string);
}


function onlyLetters($nombre) {
    return !empty($nombre) && preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $nombre);
}


function validateEmail($correo) {
    return !empty($correo) && filter_var($correo, FILTER_VALIDATE_EMAIL);
}


function validateCellPhone($telefono) {
    return !empty($telefono) && preg_match('/^[0-9]+$/', $telefono);
}


function validateCurp($curp) {
    return !empty($curp) && preg_match('/^[A-Z]{4}[0-9]{6}[HM]{1}[A-Z]{2}[A-Z]{3}[0-9A-Z]{1}[0-9]{1}$/', strtoupper($curp));
}

