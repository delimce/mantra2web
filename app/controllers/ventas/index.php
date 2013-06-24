<?php

function _index() {

    Security::hasPermissionTo(4); //id del modulo de ventas


    $vendedor = Security::getUserID();


    $data["backButton"] = 1;
    $data['siteTitle'] = 'Módulo de Ventas';
    $data['body'][] = View::do_fetch(VIEW_PATH . 'ventas/lobi.php');
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}