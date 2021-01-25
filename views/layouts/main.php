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

    <style>
        /* Temporary */
        p.error {
            color: red;
        }
    </style>
</head>
<body>
    <nav>
        <div id="left">
            <a href="/">Home</a>
        </div>
        <div id="right">

            <?php
            $user = Session::getUser();
            if ($user === null): ?>
                <a href="/login" class="login">Log in</a>
                <a href="/register" class="register">Register account</a>
            <?php else: ?>
                <div><?= "$user->firstname $user->lastname ($user->email)" ?></div>
                <div>
                    <form action="/logout" method="post">
                        <button type="submit" name="logout">
                            Log out
                        </button>
                    </form>
                </div>
             <?php endif; ?>
        </div>
    </nav>
    <?php
    $successFlash = Session::getFlash("success");
    if ($successFlash): ?>
        <div class="flash success">
            <?= $successFlash ?>
        </div>
     <?php endif; ?>
    <main>
        {{content}}
    </main>
</body>
</html>