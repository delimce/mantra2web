<?php

function _index() {

    Security::hasPermissionTo(3); //id del modulo de finanzas

    $data["backButton"] = 1;
    $data['siteTitle'] = 'Módulo de Finanzas';
    $data['body'][] = View::do_fetch(VIEW_PATH . 'finanzas/lobi.php');
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}