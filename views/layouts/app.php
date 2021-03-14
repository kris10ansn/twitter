<?php

use app\src\Session;

$title = $title ?? "Twitter";

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <base href="<?= constant("APP_URL_ROOT") ?>/">

    <title><?= $title ?></title>
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/layouts/app.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    <nav>
        <div id="left">
            <a href=".">Home</a>
            <a href="explore">Explore</a>
            <a href="users">Users</a>
        </div>
        <div id="right">

            <?php
            $user = Session::getUser();
            if ($user === null): ?>
                <a href="login" class="login">Log in</a>
                <a href="register" class="register">Register account</a>
            <?php else: ?>
                <a class="user" href="profile">
                    <?= "$user->firstname $user->lastname ($user->email)" ?>
                </a>
                <!-- Wrapper en div rundt siden det ble litt tull med styling av form -->
                <div class="button">
                    <form action="logout" method="post">
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
    <div id="content">
        {{content}}
    </div>
</body>
</html>