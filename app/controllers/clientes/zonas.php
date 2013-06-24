<?php

function _zonas($ope = false, $id = false) {

    Security::hasPermissionTo(1); //id de clientes

    $db = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $db->setTable("tbl_zona");

    if ($ope == "edit") { ///editar
        $db->getTableFields("id,nombre", "id=$id");
        $db->close();
        $vista = 'clientes/zona_edit.php';
        $param = array("datos" => $db);
        $newBoton = '';
    } else if ($ope == "new") { ///crear
        $vista = 'clientes/zona_new.php';
        $param = '';
        $newBoton = '';
    } else { //listar
        $db->getTableAllRecords("id,nombre");
        $db->freeAndClose();
        $vista = 'clientes/zona_list.php';
        $param = array("datos" => $db);
        $newBoton = 'clientes/zonas/new';
    }



    $data['backButton'] = 1;
    $data['siteTitle'] = 'Zonas de Clientes';
    $data['newButton'] = $newBoton;
    $data['body'][] = View::do_fetch(VIEW_PATH . $vista, $param);
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}

