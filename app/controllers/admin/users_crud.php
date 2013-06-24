<?php

function _users_crud($borrar = false) {

    Security::isSessionAdmin(99);

    $db = new ObjectDB();
    $id = Form::getVar("ide", $_POST); ///indica que se va a editar o borrar

    if (empty($id)) { ///insertar reg
        $db = new ObjectDB();

        $db->begin_transacction();

        ////creando el ususario
        $_POST["r0password"] = md5($_POST["clave"]);
        $db->dataInsert("r", "0", "tbl_usuario", $_POST);
        $user = $db->getLastId();
        $cuenta = Security::getCuentaID();


        ///otorgando permisos sobre modulos
        $db->setTable("tbl_modulo");
        $db->setFields("id");

        $modulos = $db->getArrayDb();

        $db->setTable("tbl_permiso");


        foreach ($modulos as $value) {

            if (!empty($_POST["mod_" . $value])) { ///si fue seleccionado el modulo
                $db->setField("usuario_id", $user);
                $db->setField("cuenta_id", $cuenta);
                $db->setField("modulo_id", $value);
                $db->insertInTo(false);
            }
        }

        ///


        $db->commit_transacction();
    } else if (!$borrar) { ///editar reg 
        $db->begin_transacction();


        /////cambiando clave si aplica
        $db->setTable("tbl_usuario");
        $db->getTableFields("password", "id = " . $id);
        $clave2 = Form::getvar("clave", $_POST);
        if ($db->getField("password") != $clave2)
            $_POST['r0password'] = md5($clave2);
        /////////////

        $db->dataUpdate("r", "0", "tbl_usuario", $_POST, "id = $id ");

        $user = $id;
        $cuenta = Security::getCuentaID();

        ///otorgando permisos sobre modulos
        $db->setTable("tbl_modulo");
        $db->setFields("id");

        $modulos = $db->getArrayDb();

        $db->setTable("tbl_permiso");


        ///borrando antiguos permisos
        $db->deleteWhere("usuario_id = $user and cuenta_id = $cuenta");

        foreach ($modulos as $value) {

            if (!empty($_POST["mod_" . $value])) { ///si fue seleccionado el modulo
                $db->setField("usuario_id", $user);
                $db->setField("cuenta_id", $cuenta);
                $db->setField("modulo_id", $value);
                $db->insertInTo(false);
            }
        }

        ///


        $db->commit_transacction();

        echo 'Cambios efectuados con exito';
    } else { ///eliminar reg
    }
}
