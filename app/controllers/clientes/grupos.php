<?php

function _grupos($ope = false, $id = false) {

    Security::hasPermissionTo(1); //id de clientes

    $db = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $db->setTable("tbl_grupo_cliente");

    if ($ope == "edit") { ///editar
        $db->getTableFields("id,nombre,descripcion,activo", "id=$id");
        $db->close();
        $vista = 'clientes/grupo_edit.php';
        $param = array("datos" => $db);
        $newBoton = '';
    } else if ($ope == "new") { ///crear
        $vista = 'clientes/grupo_new.php';
        $param = '';
        $newBoton = '';
    } else { //listar
        $db->getTableAllRecords("id,nombre"," borrado=0");
        $db->freeAndClose();
        $vista = 'clientes/grupo_list.php';
        $param = array("datos" => $db);
        $newBoton = 'clientes/grupos/new';
    }



    $data['backButton'] = 1;
    $data['siteTitle'] = 'Grupos de Clientes';
    $data['newButton'] = $newBoton;
    $data['body'][] = View::do_fetch(VIEW_PATH . $vista, $param);
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}

