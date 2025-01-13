<!DOCTYPE html>
<html lang="br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin - Chá de Rifa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], select {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .remove-button {
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Painel Admin - Chá de Rifa</h1>

        <h2>Adicionar Participante</h2>
        <form action="admin.php" method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>
            <label for="numero">Número:</label>
            <select id="numero" name="numero" required>
                <?php
                include 'conexao.php';

                $result = $conn->query("SELECT numero FROM numeros WHERE vendido = FALSE");
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['numero'] . '">' . $row['numero'] . '</option>';
                    }
                } else {
                    echo '<option value="">Todos os números foram vendidos</option>';
                }
                $conn->close();
                ?>
            </select>
            <input type="submit" value="Adicionar">
        </form>

        <h2>Participantes</h2>
        <table>
            <tr>
                <th>Nome</th>
                <th>Número</th>
                <th>Ação</th>
            </tr>
            <?php
            include 'conexao.php';

            // Adicionar participante
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['numero'])) {
                $nome = $conn->real_escape_string($_POST['nome']);
                $numero = intval($_POST['numero']);
                $conn->query("INSERT INTO participantes (nome, numero) VALUES ('$nome', $numero)");
                $conn->query("UPDATE numeros SET vendido = TRUE WHERE numero = $numero");
            }

            // Remover participante
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {
                $remove_id = intval($_POST['remove_id']);
                $numero = $conn->query("SELECT numero FROM participantes WHERE id = $remove_id")->fetch_assoc()['numero'];
                $conn->query("DELETE FROM participantes WHERE id = $remove_id");
                $conn->query("UPDATE numeros SET vendido = FALSE WHERE numero = $numero");
            }

            // Listar participantes
            $result = $conn->query("SELECT id, nome, numero FROM participantes");
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row['nome'] . '</td>';
                    echo '<td>' . $row['numero'] . '</td>';
                    echo '<td><form action="admin.php" method="post" style="display:inline;"><input type="hidden" name="remove_id" value="' . $row['id'] . '"><input type="submit" value="Remover" class="remove-button"></form></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="3">Nenhum participante registrado.</td></tr>';
            }

            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
