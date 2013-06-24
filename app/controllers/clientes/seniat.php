<?php

function _seniat() {

    Security::hasPermissionTo(1); //id del modulo de clientes

    $rif = Form::getVar("rif", $_POST);
    $url = 'http://contribuyente.seniat.gob.ve/getContribuyente/getrif?rif=' . $rif;

    datosSeniat($url);
}

function datosSeniat($url) {

    $xml = @file_get_contents($url);
    $xml = strip_tags(trim($xml));


    if (!$xml) {

        $estatus = "error";
    } else {

        $estatus = "ok";
        $contribuye = substr($xml, -2, strlen($xml));
        $retiene = substr($xml, -4, -2);
        $nombre = trim(substr($xml, 0, -4));
        $limpio = strpos($nombre, "(");
        if ($limpio)
            $nombre = substr($nombre, 0, $limpio);
    }

    $valores = array("estatus" => $estatus, "retiene" => $retiene, "contribuye" => $contribuye, "nombre" => $nombre);
    print json_encode($valores);
}

