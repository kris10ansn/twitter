<?php

use app\src\Session;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hello, World!</title>
    <link rel="stylesheet" href="/styles/global.css">
    <link rel="stylesheet" href="/styles/layouts/main.css">
</head>
<body>
    <nav>
        <a href="/">Home</a>
        <a href="/login">Log in</a>
        <a href="/register">Register account</a>
    </nav>
    <div class="flash success">
        <?= Session::getFlash("success") ?>
    </div>
    <main>
        {{content}}
    </main>
</body>
</html>