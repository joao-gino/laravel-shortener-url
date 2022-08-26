<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chame a API</title>
</head>

<body>

    <form action="{{ route('shorten.store') }}" method="POST">
        @csrf
        <strong>Encurtar URL</strong>
        <input type="text" name="url">
        <button type="submit">Encurtar URL</button>
    </form>

    <div id="resultado">
        <p>Resultado:</p>
        <label for="">
            @if (session()->has('shortener_url'))
                <a href="{{ session()->get('shortener_url') }}">teste</a>
            @endif
        </label>
    </div>
</body>

</html>
