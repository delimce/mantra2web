<?php

function _cliente($ope = false, $id = false) {

    Security::hasPermissionTo(1); //id de clientes

    $db2 = new ObjectDB(Security::getSessionVar("DATASOURCE"));

    $form = new Form();

    $db2->setTable("tbl_cliente");

    if ($ope == "edit") { ///editar
        $db2->setFields("*", "id = $id");
        $datos = $db2->vectorDb();
        $dgrupo = $datos["grupo_id"];
        $ddia = $datos["dia_id"];
        $dvende = $datos["vendedor"];
        $dbanco = $datos["banco_id"];
        $dforma = $datos["forma_id"];
        $dzona = $datos["zona_id"];
        $dtarifa = $datos["tarifa"];
        $db2->close();
        $vista = 'clientes/cliente_edit.php';
        $newBoton = '';
    } else if ($ope == "new") { ///crear
        $vista = 'clientes/cliente_new.php';
        $newBoton = '';
        $datos = '';
    } else { //listar
        $db2->setSql(FactoryDao::getClientList());
        $db2->executeQuery();
        $db2->freeAndClose();
        $datos = $db2;
        $vista = 'clientes/cliente_list.php';
        $newBoton = 'clientes/cliente/new';
    }


    
    /*
     * para los combos
     */
    $db = new ObjectDB(Security::getSessionVar("DATASOURCE"));

    ////combo de grupos
    $db->setTable("tbl_grupo_cliente");
    $db->getTableAllRecords("id,nombre", "activo = 1");
    $grupo = $form->dbComboMobile("r0grupo_id", $db, "nombre", "id", false, $dgrupo);

    ////combo de dias
    $db->setTable("tbl_semana");
    $db->getTableAllRecords("id,dia");
    $dia = $form->dbComboMobile("r0dia_id", $db, "dia", "id", false, $ddia);

    ////combo de bancos
    $db->setTable("tbl_banco");
    $db->getTableAllRecords("id,nombre"); 
    $banco = $form->dbComboMobile("r0banco_id", $db, "nombre", "id", "seleccione",$dbanco);

    ////combo de formas
    $db->setTable("tbl_forma");
    $db->getTableAllRecords("id,nombre"); 
    $forma = $form->dbComboMobile("r0forma_id", $db, "nombre", "id", "seleccione",$dforma);

    ////combo de zonas
    $db->setTable("tbl_zona");
    $db->getTableAllRecords("id,nombre"); 
    $zonas = $form->dbComboMobile("r0zona_id", $db, "nombre", "id", "seleccione",$dzona);
    
    
    
    $db3 = new ObjectDB();
        ////combo de vendedores
    $db3->setTable("tbl_usuario");
    $db3->setSql(FactoryDao::getUsersVendors());
    $db3->executeQuery();
    $vendedor = $form->dbComboMobile("vendedor", $db3, "nombre", "id", false, $dvende);

    ///combo de trarifas
    $tarifa1 = array("A", "B", "C");
    $tarifa2 = array("A", "B", "C");
    $tarifas = $form->arrayComboMobile("r0tarifa", $tarifa1, $tarifa2, false, $dtarifa);


    $param = array("datos" => $datos, "grupo" => $grupo, "dia" => $dia, "vendedor" => $vendedor, "banco" => $banco, "forma" => $forma, "tarifa" => $tarifas, "zona" => $zonas);

    
    $data['backButton'] = 1;
    $data['siteTitle'] = 'Clientes';
    $data['newButton'] = $newBoton;
    $data['body'][] = View::do_fetch(VIEW_PATH . $vista, $param);
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}

