<?php

function controlador () 
{
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if ($_SESSION['usuario']) {
            $contenido = mostrarFormularioPedido();
        } else {
            if(isset($_GET['usuario'])){
                $_SESSION['usuario'] = $_GET['usuario'];
                $contenido = mostrarFormularioPedido();
            } else {
                $contenido = mostrarFormularioNombre();
            }
        }
    } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['enviar'] == 'Anotar') {
    
            $fruta = $_POST['fruta'];
            $cantidad = (int) $_POST['cantidad']; 
            $_SESSION['pedido'][$fruta] += $cantidad;
            $contenido = mostrarPedido() . mostrarFormularioPedido();
        } else {
            $contenido = mostrarPedido() . mostarFormularioNuevoCliente();

        }
    }
    imprimirPantalla($contenido);
}

function mostrarFormularioNombre (): string
{
    $salida ='<form method="GET">';
    $salida .= '<label>Nombre de usuario <input type="text" name="usuario" size="30"></label>';
    $salida .= ' <input type="submit" value="Enviar">';
    $salida .= '</form>';

    return $salida;
}

function mostrarFormularioPedido (): string
{
    $salida = "Realice su compra " . $_SESSION['usuario'] . "<br><br>";
    $salida .=  "<form method='POST'>";
    $salida .= "<select name='fruta'>";
    $salida .= "<option value='platano'>Plátano</option>";
    $salida .= "<option value='naranja'>Naranja</option>";
    $salida .= "<option value='limon'>Limón</option>";
    $salida .= "<option value='manzana'>Manzana</option>";
    $salida .= "</select>";
    $salida .= " <input type='number' name='cantidad' value='cantidad' min='1' max='20'>";
    $salida .= " <input type='submit' name='enviar' value='Anotar'>";
    $salida .= " <input type='submit' name='enviar' value='Terminar'>";
    $salida .= "</form>";

    return $salida;
}


function mostrarPedido (): string
{
    $salida = '<div>';
    $salida .= '<ul>';
       
    foreach ($_SESSION['pedido'] as $fruta => $cantidad) {
        $salida .= '<li>' . $fruta . ' ' . $cantidad . '</li>';
    }
    $salida .= '</ul>';
    $salida .= '</div>';
   
    return $salida;
}

function mostarFormularioNuevoCliente (): string
{
    $salida = "<p>Muchas gracias por su pedido</p>";
    $salida .= "<input type='button' name='nuevo_cliente' value='NUEVO CLIENTE' onclick='location.href=\"" . $_SERVER['PHP_SELF'] . "\"' >";
    return $salida;
}

function imprimirPantalla(string $contenido)
{
    $salida = '<!DOCTYPE html>';
    $salida .= '<html lang="en">';
    $salida .= '<head>';
    $salida .= '<meta charset="UTF-8">';
    $salida .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
    $salida .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $salida .= '<title>La frutería sXXI</title>';
    $salida .= '</head>';
    $salida .= '<body>';
    $salida .= '<h1>Bienvenido a la frutería del siglo XXI</h1>';
    $salida .= $contenido;
    $salida .= '</body>';
    $salida .= '</html>';

    echo $salida;
}

controlador();

?>
