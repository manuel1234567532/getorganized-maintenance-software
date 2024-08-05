<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>404 | Seite nicht gefunden</title>

 <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/websiteSettings/icon.ico') }}" />
    <style>
        body {
            background-color: #3498db; /* Blau */
            color: #fff; /* Weiß */
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            font-size: 6em;
            margin: 0;
        }

        p {
            font-size: 1.5em;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

        .error-code {
            font-size: 4em;
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #2980b9; /* Dunkleres Blau */
            color: #fff;
            font-size: 1.2em;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #55a4e8; /* Helleres Blau im Hover-Effekt */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <p>Oops! Die Seite konnte nicht gefunden werden.</p>
        <button class="button" onclick="window.location.href='/';">Zurück zur Hauptseite</button>
    </div>
</body>
</html>
