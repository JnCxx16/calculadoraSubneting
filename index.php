<?php
function validarIP($ip)
{
    // Valida la dirección IP
    $ip = filter_var($ip, FILTER_VALIDATE_IP);
    if (!$ip) {
        return false;
    }

    // Comprueba que cada octeto está en el rango permitido
    for ($i = 0; $i < 4; $i++) {
        $octeto = substr($ip, $i * 3, 3);
        if (!is_numeric($octeto) || intval($octeto) < 0 || intval($octeto) > 255) {
            return false;
        }
    }

    // Devuelve true si la dirección IP es válida
    return true;
}

function subnetting($ip, $mascara)
{
    // Validate the IP address and subnet mask
    $ip = filter_var($ip, FILTER_VALIDATE_IP);
    $mascara = filter_var($mascara, FILTER_VALIDATE_IP);

    if (!$ip || !$mascara) {
        return [];
    }

    // Convert the subnet mask to an integer
    $mascaraEntero = intval($mascara);

    // Get the network address
    $ipRed = ip2long($ip) & $mascaraEntero;

    // Calculate the broadcast address
    $ipBroadcast = ip2long($ip) | ~($mascaraEntero - 1);

    // Calculate the number of hosts per subnet
    $numeroHosts = pow(2, strlen($mascaraEntero) - 2);

    // Return the results of the calculation, or an empty array if there are any errors
    if (empty($errores)) {
        $subred = implode('', [$ip, $mascara]);
        $direccionInicial = $ipRed + 1;
        $direccionFinal = $ipBroadcast - 1;

        return [
            'subred' => $subred,
            'direccionInicial' => $direccionInicial,
            'direccionFinal' => $direccionFinal,
            'numeroHosts' => $numeroHosts,
        ];
    } else {
        return [];
    }
}





function resultado($resultados)
{

    if (empty($resultados)) {
        echo "No se pudo calcular el subnetting.";
        return;
    }

    $subred = $resultados['subred'];
    $direccionInicial = $resultados['direccionInicial'];
    $direccionFinal = $resultados['direccionFinal'];
    $numeroHosts = $resultados['numeroHosts'];

    echo "Subred: $subred\n<br>";
    echo "Dirección inicial: $direccionInicial\n<br>";
    echo "Dirección final: $direccionFinal\n<br>";
    echo "Número de hosts: $numeroHosts\n<br>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Calculadora de Subnetting</title>
</head>

<body>
    <h1>Subnetting</h1>

    <form action="index.php" method="post">
        <label for="ip">Dirección IP:</label>
        <input type="text" id="ip" name="ip" placeholder="192.168.1.1" required>
        <br>
        <label for="mascara">Máscara de subred:</label>
        <input type="text" id="mascara" name="mascara" placeholder="255.255.255.0" required>
        <br>
        <input type="submit" value="Enviar">
    </form>

    <?php
    if (empty($_POST["ip"]) || empty($_POST["mascara"])) {
        echo "Debes rellenar todos los campos.";
    }
    // Validamos la dirección IP
    if (!validarIP($_POST["ip"])) {
        echo "La dirección IP es inválida.";
        exit;
    } else {
        // Realizamos el subnetting
        $resultados = subnetting($_POST["ip"], $_POST["mascara"]);
        // Mostramos los resultados
        resultado($resultados);
    }
    ?>
</body>

</html>