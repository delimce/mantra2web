<?php

function _grupos_crud($borrar = false) {

    Security::hasPermissionTo(2); //id de clientes

    $form = new ObjectDB(Security::getSessionVar("DATASOURCE"));
    $id = Form::getVar("ide", $_POST); ///indica que se va a editar o borrar

    if (empty($id)) { ///insertar reg
        $form->dataInsert("r", "0", "tbl_grupo_producto", $_POST);
    } else if (!$borrar) { ///editar reg 
        $form->dataUpdate("r", "0", "tbl_grupo_producto", $_POST, "id = $id ");
        echo 'Cambios efectuados con exito';
    } else { ///eliminar reg
    }


    $form->close();
}