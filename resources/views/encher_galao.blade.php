<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encher Galão</title>
</head>
<body>
    <h1>Encher Galão</h1>
    @if (session('resultado'))
        <h2>Resultado:</h2>
        <p>Garrafas utilizadas: [{{ implode('L, ', session('resultado')['garrafas']) }}L]</p>
        <p>Sobra: {{ session('resultado')['sobra'] }}L</p>
    @endif
    <form action="{{ route('encher_galao.store') }}" method="post">
        @csrf
        <label for="volume_galao">Insira o volume do galão:</label><br>
        <input type="number" id="volume_galao" name="volume_galao" step="0.1" required><br><br>
        <label for="quantidade_garrafas">Quantidade de garrafas:</label><br>
        <input type="number" id="quantidade_garrafas" name="quantidade_garrafas" required><br><br>
        <div id="garrafas">
            
        </div>
        <button type="button" onclick="adicionarGarrafa()">Adicionar Garrafa</button><br><br>
        <button type="submit">Enviar</button>
    </form>

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
                input.name = 'garrafas[]';
                input.required = true;
                divGarrafas.appendChild(input);

                divGarrafas.appendChild(document.createElement('br'));
                divGarrafas.appendChild(document.createElement('br'));
            }
        }
    </script>
</body>
</html>
