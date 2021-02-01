<?php /** @var object[] $trending */ ?>

<link rel="stylesheet" href="styles/layouts/main.css">

<div id="content">
    <main>
        {{content}}
    </main>
    <aside>
        <div id="trending" class="card">
            <h1>Trending</h1>
            <hr>
            <?php foreach ($trending as $hashtag): ?>
                <a href="hashtag/<?= $hashtag->name ?>">
                    <div class="hashtag">
                        #<?= $hashtag->name ?>
                        <p class="small"><?= $hashtag->posts ?> posts, <?= $hashtag->likes ?> likes</p>
                    </div>
                </a>
            <?php endforeach; ?>
            <?php if (count($trending) === 0): ?>
                <p>Try posting a <a>#hasthag</a> to get on trending!</p>
            <?php endif; ?>
        </div>
    </aside>
</div>