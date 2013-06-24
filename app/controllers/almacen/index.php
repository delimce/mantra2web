<?php

function _index() {

    Security::hasPermissionTo(2); //id del modulo de almacen

    $data["backButton"] = 1;
    $data['siteTitle'] = 'Módulo de Almacen';
    $data['body'][] = View::do_fetch(VIEW_PATH . 'almacen/lobi.php');
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}