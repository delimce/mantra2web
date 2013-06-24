<?php

function _index() {

    Security::isSessionAdmin(99);

    $data['backButton']= 1;
    $data['siteTitle'] = 'Administración';
    $data['body'][] = View::do_fetch(VIEW_PATH . 'admin/lobi.php');
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}