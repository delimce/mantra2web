<?php

function _empresas_crud($borrar = false) {

    Security::isSessionAdmin(99);

    $form = new ObjectDB();
    $id = Form::getVar("ide", $_POST); ///indica que se va a editar o borrar

    if (empty($id)) { ///insertar reg
        $_POST["r9creada"] = date("Y-m-d:H:i:s");
        $form->dataInsert("r", "9", "tbl_cuenta", $_POST);
    } else if (!$borrar) { ///editar reg 
        $form->dataUpdate("r", "9", "tbl_cuenta", $_POST, "id = $id ");
        echo 'Cambios efectuados con exito';
    } else { ///eliminar reg
    }
    
    $form->close();
}