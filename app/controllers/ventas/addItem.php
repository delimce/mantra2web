<?php

function _addItem() {


    Security::hasPermissionTo(4); //id del modulo de ventas

    $idProd = Form::getvar("producto", $_POST);
    $cantProd = Form::getvar("cantidad", $_POST);

/////////sino me vienen id de productos
    if (empty($idProd)) {

        printOrder();
        die();
    }



    /////si vienen productos

    initOrder();

    $db = new ObjectDB(Security::getSessionVar("DATASOURCE"));


    $clienteId = empty($_SESSION['PEDIDO_CLIENTEID']) ? 0 : $_SESSION['PEDIDO_CLIENTEID'];

    $db->setSql(FactoryDao::getProdDataOrden($clienteId, $idProd));
    $db->getResultFields();

    ////***********llenando vectores
    if (!in_array($idProd, $_SESSION['PEDIDO_PRODID'])) { ////si no ha sido añadido el producto
        array_push($_SESSION['PEDIDO_PRODID'], $idProd);
        array_push($_SESSION['PEDIDO_PRODNOMBRE'], $db->getField("nombre"));
        array_push($_SESSION['PEDIDO_PRODCANT'], $cantProd);
        array_push($_SESSION['PEDIDO_PRODPRECIO'], $db->getField("precio"));
    } else { ///sumo la cantidad
        $pos = array_search($idProd, $_SESSION['PEDIDO_PRODID']);
        $_SESSION['PEDIDO_PRODCANT'][$pos] = $cantProd;
    }

    $db->close();
    
    
    
    printOrder();
}

function printOrder() {

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

function initOrder() {
    if (!isset($_SESSION['PEDIDO_PRODID'])) {

        $_SESSION['PEDIDO_PRODID'] = array();
        $_SESSION['PEDIDO_PRODNOMBRE'] = array();
        $_SESSION['PEDIDO_PRODCANT'] = array();
        $_SESSION['PEDIDO_PRODPRECIO'] = array();
    }
}

?>
