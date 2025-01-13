<?php
if (isset($_GET['number']) && isset($_GET['name'])) {
    $number = intval($_GET['number']);
    $name = $_GET['name'];

    $conn = new mysqli("localhost", "jess_jessizazum", "4OyMMFlnbn#gPCqD", "jess_jessizazum");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO participantes (nome, numero) VALUES (?, ?)");
    $stmt->bind_param("si", $name, $number);

    if ($stmt->execute()) {
        $stmt = $conn->prepare("UPDATE numeros SET vendido = TRUE WHERE numero = ?");
        $stmt->bind_param("i", $number);
        $stmt->execute();
        echo "Número $number comprado com sucesso por $name!";
    } else {
        echo "Erro ao comprar o número.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Número ou nome não fornecido.";
}
?>
