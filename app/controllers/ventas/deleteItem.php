<?php

function _deleteItem() {

    $idProd = Form::getvar("producto", $_POST);

////***********valido que existe el elemento para borrarlo
    if (@in_array($idProd, $_SESSION['PEDIDO_PRODID'])) { ////si no ha sido añadido el producto
        $pos = array_search($idProd, $_SESSION['PEDIDO_PRODID']);

        $_SESSION['PEDIDO_PRODID'] = Vector::delete_from($_SESSION['PEDIDO_PRODID'], $_SESSION['PEDIDO_PRODID'][$pos]);
        $_SESSION['PEDIDO_PRODNOMBRE'] = Vector::delete_from($_SESSION['PEDIDO_PRODNOMBRE'], $_SESSION['PEDIDO_PRODNOMBRE'][$pos]);
        $_SESSION['PEDIDO_PRODCANT'] = Vector::delete_from($_SESSION['PEDIDO_PRODCANT'], $_SESSION['PEDIDO_PRODCANT'][$pos]);
        $_SESSION['PEDIDO_PRODPRECIO'] = Vector::delete_from($_SESSION['PEDIDO_PRODPRECIO'], $_SESSION['PEDIDO_PRODPRECIO'][$pos]);
    }

    if (isset($_SESSION['PEDIDO_PRODID'])) {
        foreach ($_SESSION['PEDIDO_PRODID'] as $i => $value) {

            echo '<li>
            <b>Producto:</b> <span style="color:blue">' . $_SESSION['PEDIDO_PRODNOMBRE'][$i] . '</span>
            <fieldset style="font-size: 12px">
            <b>cantidad:</b> ' . $_SESSION['PEDIDO_PRODCANT'][$i] . ' <b>Precio</b> Bs ' . $_SESSION['PEDIDO_PRODPRECIO'][$i] . '                                         
            </fieldset>
            </li>';
        }
    }
}