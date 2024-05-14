<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Galão</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        .display-clear{
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: row;
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
        form {
            display: inline-block;
            width: 100%;
        }
        input[type="email"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: calc(100% - 20px);
            display: inline-block;
            vertical-align: top;
        }
        .submit-button {
            display: inline-block;
            width: auto;
            padding: 10px;
            margin-left: 10px; 
        }
        a{
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
        }
        a:hover{
            text-decoration: underline;
        }
        .display-email{
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        .alert {
            padding: 20px;
            background-color: #f44336;
            color: white;
            margin-bottom: 15px;
        }
        .success {
            background-color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registros</h1>
        @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
        @elseif(session('error'))
        <div class="alert">
            {{ session('error') }}
        </div>
        @endif
        <form action="{{ route('limpar_registros') }}" method="get">
            @csrf
            <table>
                <thead>
                    <tr>
                        <th>Data e Hora</th>
                        <th>Volume do Galão (L)</th>
                        <th>Garrafas Utilizadas</th>
                        <th>Sobra (L)</th>
                        <th>Exportar CSV</th>
                        <th>Excluir Registro</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registros as $registro)
                    <tr>
                        <td>{{ $registro->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i:s') }}</td>
                        <td>{{ $registro->volume }}L</td>
                        <td>[{{ implode('L, ', json_decode($registro->garrafas_utilizadas)) }}L]</td>
                        <td>{{ $registro->sobra }}L</td>
                        <td>
                            <button type="button" class="button" onclick="exportarCSV({{ $registro->id }})">Exportar</button>
                        </td>
                        <td>
                            <button type="button" class="button" onclick="limparRegistro({{ $registro->id }})">Excluir</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
                <a href="{{ route('encher_galao.index') }}">Voltar</a>
        </form>
    </div>
    <script>
        function exportarCSV(id) {
            var form = document.createElement("form");
            form.setAttribute("method", "post");
            form.setAttribute("action", "{{ route('exportar_csv') }}");

            var csrfToken = document.createElement("input");
            csrfToken.setAttribute("type", "hidden");
            csrfToken.setAttribute("name", "_token");
            csrfToken.setAttribute("value", "{{ csrf_token() }}");
            form.appendChild(csrfToken);

            var input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("name", "galao_id");
            input.setAttribute("value", id);
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }

        function limparRegistro(id) {
            if (confirm('Tem certeza de que deseja limpar este registro?')) {
                window.location.href = "{{ url('/limpar-registro/') }}" + '/' + id;
            }
        }
    </script>
</body>
</html>
