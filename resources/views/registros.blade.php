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
        .button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
        }
        .button:hover {
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
        <form action="{{ route('enviar_email') }}" method="post" id="emailForm">
            @csrf
            <input type="hidden" name="galao_id" value="{{ $registros->first()->galao_id }}">
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all" onclick="toggleCheckboxes(this)"></th>
                        <th>Data e Hora</th>
                        <th>Volume do Galão (L)</th>
                        <th>Garrafas Utilizadas</th>
                        <th>Sobra (L)</th>
                        <th>Exportar CSV</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registros as $registro)
                    <tr>
                        <td><input type="checkbox" name="registros_selecionados[]" value="{{ $registro->id }}"></td>
                        <td>{{ $registro->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i:s') }}</td>
                        <td>{{ $registro->volume }}L</td>
                        <td>[{{ implode('L, ', json_decode($registro->garrafas_utilizadas)) }}L]</td>
                        <td>{{ $registro->sobra }}L</td>
                        <td>
                            <button type="button" class="button" onclick="exportarCSV({{ $registro->id }})">Exportar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="display-email">
                <input type="email" id="email" name="email" placeholder="Digite o e-mail" required>
                <button type="button" class="button submit-button" onclick="enviarEmail()">Enviar</button>
            </div>
        </form>
        <a href="{{ route('encher_galao.index') }}">Voltar</a>
    </div>
    <script>
        function enviarEmail() {
            var checkboxes = document.querySelectorAll('input[type=checkbox][name="registros_selecionados[]"]:checked');
            if (checkboxes.length === 0) {
                alert('Selecione pelo menos um registro para enviar por e-mail.');
                return false;
            }
            if (document.getElementById('email').value === '') {
                alert('Digite o e-mail para enviar os registros.');
                return false;
            }
            var emailForm = document.getElementById('emailForm');
            emailForm.submit();
        }

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

        function toggleCheckboxes(checkbox) {
            var checkboxes = document.querySelectorAll('input[type=checkbox][name="registros_selecionados[]"]');
            checkboxes.forEach(function(item) {
                item.checked = checkbox.checked;
            });
        }
    </script>
</body>
</html>
