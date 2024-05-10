<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Galão</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        h2{
            text-align: center;
        }
        p{
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
        }
        input[type="number"] {
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            margin-top: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        a{
            padding: 10px;
            margin-top: 10px;
            color: #007bff;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }
        a:hover{
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Teste Galão</h1>
        <form action="{{ route('encher_galao.store') }}" method="post" onsubmit="return validarFormulario()">
            @csrf
            <label for="volume_galao">Insira o volume do galão:</label>
            <input type="number" id="volume_galao" name="volume_galao" step="0.1" min="0" required>
            <label for="quantidade_garrafas">Quantidade de garrafas:</label>
            <input type="number" id="quantidade_garrafas" name="quantidade_garrafas" min="1" required>
            <div id="garrafas">
                
            </div>
            @if (isset($resultado))
            <h2>Resultado:</h2>
            <p>Garrafas utilizadas: [{{ implode('L, ', $resultado['garrafas']) }}L]</p>
            <p>Sobra: {{ $resultado['sobra'] }}L</p>
            @endif
            <button type="button" onclick="adicionarGarrafa()">Adicionar Garrafa</button>
            <button type="submit">Enviar</button>
            <a href="{{ route('encher_galao.registros') }}" class="button">Ver Registros</a>
        </form>
    </div>

    <script>
        function adicionarGarrafa() {
            var quantidadeGarrafas = document.getElementById('quantidade_garrafas').value;
            var divGarrafas = document.getElementById('garrafas');
            divGarrafas.innerHTML = '';

            for (var i = 1; i <= quantidadeGarrafas; i++) {
                var label = document.createElement('label');
                label.textContent = 'Volume da Garrafa ' + i + ':';
                divGarrafas.appendChild(label);

                var input = document.createElement('input');
                input.type = 'number';
                input.step = '0.1';
                input.min = '0'; 
                input.name = 'garrafas[]';
                input.required = true;
                divGarrafas.appendChild(input);

                divGarrafas.appendChild(document.createElement('br'));
                divGarrafas.appendChild(document.createElement('br'));
            }
        }

        function validarFormulario() {
            var quantidadeGarrafas = document.getElementById('quantidade_garrafas').value;
            var garrafasInseridas = document.querySelectorAll('input[name="garrafas[]"]').length;

            if (garrafasInseridas < quantidadeGarrafas) {
                alert("Por favor, adicione o volume de todas as garrafas antes de enviar o formulário.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
