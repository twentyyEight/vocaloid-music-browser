<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <style>
        body {
            background-color: #282828;
            height: 97vh;
            color: white;
            font-family: "Geologica", sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        img {
            height: 35%;
            margin-bottom: 10px;
        }

        h1,
        p {
            padding: 0;
            margin: 0;
        }
    </style>
</head>

<body>
    <img src="images/error.png" alt="miku error">
    <h1>
        @yield('message')
    </h1>

    <p>Código del error: @yield('code')</p>
</body>

</html>