<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros - Encher Galão</title>
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
            margin-top: 20px;
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
            display: inline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registros - Encher Galão</h1>
        <table>
            <thead>
                <tr>
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
                    <td>{{ $registro->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $registro->volume }}L</td>
                    <td>[{{ implode('L, ', $registro->garrafas->pluck('volume')->toArray()) }}L]</td>
                    <td>{{ $registro->volume - $registro->garrafas->sum('volume') }}L</td>
                    <td>
                        <form action="{{ route('exportar_csv') }}" method="post">
                            @csrf
                            <input type="hidden" name="galao_id" value="{{ $registro->id }}">
                            <button type="submit" class="button">Exportar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('encher_galao.index') }}" class="button">Voltar</a>
    </div>
</body>
</html>
