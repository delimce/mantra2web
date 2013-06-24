<?php

function _empresas($ope = false, $id = false) {

    Security::isSessionAdmin(99);

    $db = new ObjectDB();
    $db->setTable("tbl_cuenta");

    if ($ope == "edit") { ///editar
        $db->getTableFields("*", "id=$id");
        $db->close();
        $vista = 'admin/empresas_edit.php';
        $param = array("datos" => $db);
        $newBoton = '';
    } else if ($ope == "new") { ///crear
        $vista = 'admin/empresas_new.php';
        $param = '';
        $newBoton = '';
    } else { //listar
        $db->getTableAllRecords("id,nombre,activo");
        $db->freeAndClose();
        $vista = 'admin/empresas_list.php';
        $param = array("datos" => $db);
        $newBoton = 'admin/empresas/new';
    }


    $data['backButton'] = 1;
    $data['siteTitle'] = 'Empresas';
    $data['newButton'] = $newBoton;
    $data['body'][] = View::do_fetch(VIEW_PATH . $vista, $param);
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}

