<?php
$filename = __DIR__ . '/data/articles.json';
$articles = [];
$categories = [];

if (file_exists($filename)) {
    $articles = json_decode(file_get_contents($filename), true) ?? [];

    $cattmp = array_map(fn ($article) => $article['category'], $articles);
    $categories = array_reduce($cattmp, function ($accumulator, $cat) {
        if (isset($accumulator[$cat])) {
            $accumulator[$cat]++;
        } else {
            $accumulator[$cat] = 1;
        }
        return $accumulator;
    }, []);

    $article_Per_Categories = array_reduce($articles, function ($accumulator, $article) {
        if (isset($accumulator[$article['category']])) {
            $accumulator[$article['category']] = [...$accumulator[$article['category']], $article];
        } else {
            $accumulator[$article['category']] = [$article];
        }
        return $accumulator;
    }, []);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'includes/head.php' ?>
    <title>Blog | V1</title>
    <link rel="stylesheet" href="/public/css/index.css">
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="category-container">
                <?php foreach ($categories as $category => $number) : ?>
                    <h2><?= $category ?></h2>
                    <div class="articles-container">
                        <?php foreach ($article_Per_Categories[$category] as $article) : ?>
                            <div class="article block">
                                <h3><?= $article['title'] ?></h3>
                                <div class="overflow">
                                    <div class="img-container" style="background-image:url(<?= $article['image'] ?>)">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
</body>

</html>