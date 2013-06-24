<?php

function _cajas($ope = false, $id = false) {

    Security::hasPermissionTo(4); //id de ventas

    $db = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $db->setTable("tbl_caja");

    if ($ope == "new") { ///crear
        ////combo de vendedores
        $form = new Form();
        $db2 = new ObjectDB();
        $db2->setSql(FactoryDao::getUsersList());
        $db2->executeQuery();
        $vendedor = $form->dbComboMobile("r0usuario_id", $db2, "nombre", "id", 'Seleccionar', $default);



        $vista = 'ventas/cajas_new.php';
        $param = array("vendedor" => $vendedor);
        $newBoton = '';
    } else { //listar
        ////si es admin puede ver todos los registros
        $dv = new ObjectDB();
        $dv->setSql(FactoryDao::getUsersVendors());
        $vendors = $dv->matrixDb();
        $dv->close();

        if (Security::getUserProfileID() == 99)
            $db->getTableAllRecords("id,nombre,saldo,usuario_id");
        else
            $db->getTableAllRecords("id,nombre,saldo,usuario_id", "vendedor_id = " . Security::getUserID());


        $db->freeAndClose();
        $vista = 'ventas/cajas_list.php';
        $param = array("datos" => $db,"vendors"=>$vendors);
        ////poder crear cajas
        $newBoton = (Security::getUserProfileID() == 99) ? 'ventas/cajas/new' : '';
    }


    $data['backButton'] = 1;
    $data['siteTitle'] = 'Cajas';
    $data['newButton'] = $newBoton;
    $data['body'][] = View::do_fetch(VIEW_PATH . $vista, $param);
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}

