<?php

function _users($ope = false, $id = false) {

    Security::isSessionAdmin(99);

    $db = new ObjectDB();
    $db->setTable("tbl_usuario");

    $form = new Form();
   
    if ($ope == "edit") { ///editar
        
        $userId = $id;
        $cuentaId = Security::getCuentaID();
        $db->setSql(FactoryDao::getModuleList($userId, $cuentaId));
        $modulos = $db->matrixDb();
        
        $db->setSql(FactoryDao::getUsersList($userId));
        $db->getResultFields();
        $perfil = $db->getField("perfil_id");
        $db->close();
        
        $profiles = $form->dbComboMobile("r0perfil_id", FactoryDao::getProfiles(), "nombre", "id", false, $perfil);

        $vista = 'admin/users_edit.php';
        $param = array("datos" => $db,"modulos"=>$modulos,"perfiles" => $profiles);
        $newBoton = '';
        
        
    } else if ($ope == "new") { ///crear
        
        ///traer lista de modulos
        $db->setSql(FactoryDao::getModuleList());
        $modulos = $db->matrixDb();
        /////
        
        $profiles = $form->dbComboMobile("r0perfil_id", FactoryDao::getProfiles(), "nombre", "id", false);

        
        $vista = 'admin/users_new.php';
        $param = array("perfiles" => $profiles,"modulos"=>$modulos);
        $newBoton = '';
        
        
    } else { //listar
        $db->setSql(FactoryDao::getUsersList());
        $db->executeQuery();
        $db->freeAndClose();
        $vista = 'admin/users_list.php';
        $param = array("datos" => $db);
        $newBoton = 'admin/users/new';
    }


    $data['backButton'] = 1;
    $data['siteTitle'] = 'Usuarios';
    $data['newButton'] = $newBoton;
    $data['body'][] = View::do_fetch(VIEW_PATH . $vista, $param);
    View::do_dump(LAYOUT_PATH . 'layoutMobile.php', $data);
}