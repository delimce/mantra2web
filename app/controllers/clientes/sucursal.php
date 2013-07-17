<?php

function _sucursal($ope = false, $id = false) {

    Security::hasPermissionTo(1); //id de clientes

    $db2 = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $db2->setTable("tbl_cliente_sucursal");

    if ($ope == "edit") { ///editar
        $db2->setFields("*", "id = $id");
        $datos = $db2->vectorDb();
        $dvende = $datos["vendedor"];
        $dzona = $datos["zona_id"];
        $dcliente = $datos["cliente_id"];
        $db2->close();
        $vista = 'clientes/sucursal_edit.php';
        $newBoton = '';
    } else if ($ope == "new") { ///crear
        $vista = 'clientes/sucursal_new.php';
        $newBoton = '';
    } else { //listar
        $db2->setSql(FactoryDao::getSucursalList());
        $db2->executeQuery();
        $db2->freeAndClose();
        $datos = $db2;
        $vista = 'clientes/sucursal_list.php';
        $newBoton = 'clientes/sucursal/new';
    }



    /*
     * para los combos
     */
    $form = new Form();
    ////combo de vendedores

    $db2 = new ObjectDB();
    $db2->setTable("tbl_usuario");
    $db2->getTableAllRecords("id,nombre", "perfil_id = 3"); //perfil vendedor
    $vendedor = $form->dbComboMobile("vendedor", $db2, "nombre", "id", false, $dvende);

    /////////

    $db = new ObjectDB(Security::getSessionVar("DATASOURCE"));

    ////combo de zonas
    $db->setTable("tbl_zona");
    $db->getTableAllRecords("id,nombre");
    $zonas = $form->dbComboMobile("r0zona_id", $db, "nombre", "id", "seleccione", $dzona);

    ////combo de clientes
    $db->setTable("tbl_cliente");
    $db->getTableAllRecords("id,nombre", "activo = 1", "nombre");
    $clientes = $form->dbComboMobile("r0cliente_id", $db, "nombre", "id", "seleccione", $dcliente);

    $db->close();


    $param = array("datos" => $datos, "vendedor" => $vendedor, "zona" => $zonas, "clientes" => $clientes);


    $data['backButton'] = 1;
    $data['siteTitle'] = 'Sucursales de Clientes';
    $data['newButton'] = $newBoton;
    $data['body'][] = View::do_fetch(VIEW_PATH . $vista, $param);
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}

