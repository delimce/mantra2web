<?php

function _zonas_crud($borrar = false) {

    Security::hasPermissionTo(1); //id de clientes

    $form = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $id = Form::getVar("ide", $_POST); ///indica que se va a editar o borrar

    if (empty($id)) { ///insertar reg
        $form->dataInsert("r", "9", "tbl_zona", $_POST);
    } else if (!$borrar) { ///editar reg 
        $form->dataUpdate("r", "9", "tbl_zona", $_POST, "id = $id ");
        echo 'Cambios efectuados con exito';
    } else { ///eliminar reg
    }


    $form->close();
}