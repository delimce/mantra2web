<?php

function _index() {

    Security::hasPermissionTo(1); //id del modulo de clientes

    $data["backButton"] = 1;
    $data['siteTitle'] = 'Módulo de clientes';
    $data['body'][] = View::do_fetch(VIEW_PATH . 'clientes/lobi.php');
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}