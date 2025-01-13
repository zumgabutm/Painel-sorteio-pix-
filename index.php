<!DOCTYPE html>
<html lang="br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chá de Rifa_Sorteio Liquidificador 20/09/2024</title>
    <style>
        body {
            background-image: url('https://i.pinimg.com/originals/42/64/a4/4264a4ba598c17ef23685260a13bd849.gif');
            background-size: cover;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            color: white;
        }
        .container {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
        }
        .numbers {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(50px, 1fr));
            gap: 10px;
        }
        .number {
            background: linear-gradient(45deg, #ff9a9e, #fad0c4);
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
        }
        .number:hover {
            background: linear-gradient(45deg, #fad0c4, #ff9a9e);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎟️ Chá de Rifa 🍀 Sorteio de  Liquidificador |20/09/2024</h1>
        <h2>!Escolha um número</h2>
        <div class="numbers">
            <?php
            $conn = new mysqli("localhost", "root", "", "cha_de_rifa");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $result = $conn->query("SELECT numero FROM numeros WHERE vendido = FALSE");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="number" onclick="chooseNumber(' . $row['numero'] . ')">' . $row['numero'] . '</div>';
                }
            } else {
                echo '<p>Todos os números foram vendidos!</p>';
            }

            $conn->close();
            ?>
        </div>
    </div>

    <script>
        function chooseNumber(number) {
            const name = prompt("Por favor, digite seu nome:");
            if (name) {
                window.location.href = `purchase.php?number=${number}&name=${name}`;
            }
        }
    </script>
</body>
</html>
