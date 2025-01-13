<?php
if (isset($_GET['id']) && isset($_GET['number'])) {
    $id = intval($_GET['id']);
    $number = intval($_GET['number']);

    include 'conexao.php';

    $stmt = $conn->prepare("DELETE FROM participantes WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $stmt = $conn->prepare("UPDATE numeros SET vendido = FALSE WHERE numero = ?");
        $stmt->bind_param("i", $number);
        $stmt->execute();
        echo "Participante removido e número $number disponível novamente.";
    } else {
        echo "Erro ao remover o participante.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID ou número não fornecido.";
}
?>
