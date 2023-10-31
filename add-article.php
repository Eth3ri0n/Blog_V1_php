<?php
const ERROR_REQUIRED = "Please add somethings !";
const ERROR_TITLE_TOO_SHORT = "The title is too short !";
const ERROR_CONTENT_TOO_SHORT = "The Content of the article is too short !";
const ERROR_IMAGE_URL = "The URL is invalid";

$filename = __DIR__ . '/data/articles.json';

$errors = [
    'title' => '',
    'image' => '',
    'category' => '',
    'content' => ''
];

$articles = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (file_exists($filename)) {
        $articles = json_decode(file_get_contents($filename), true) ?? [];
    }
    $_POST = filter_input_array(INPUT_POST, [
        'title' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'image' => FILTER_SANITIZE_URL,
        'category' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'content' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'flags' => FILTER_FLAG_NO_ENCODE_QUOTES
        ]
    ]);

    $title = $_POST['title'] ?? '';
    $image = $_POST['image'] ?? '';
    $category = $_POST['category'] ?? '';
    $content = $_POST['content'] ?? '';
    if (!$title) {
        $errors['title'] = ERROR_REQUIRED;
    } elseif (mb_strlen($title) < 5) {
        $errors['title'] = ERROR_TITLE_TOO_SHORT;
    }

    if (!$image) {
        $errors['image'] = ERROR_REQUIRED;
    } elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
        $errors['image'] = ERROR_IMAGE_URL;
    }

    if (!$category) {
        $errors['category'] = ERROR_REQUIRED;
    }

    if (!$content) {
        $errors['content'] = ERROR_REQUIRED;
    } elseif (mb_strlen($content) < 50) {
        $errors['content'] = ERROR_CONTENT_TOO_SHORT;
    }

    if (empty(array_filter($errors, fn ($e) => $e !== ''))) {
        $articles = [...$articles, [
            'id' => time(),
            'title' => $title,
            'image' => $image,
            'category' => $category,
            'content' => $content
        ]];
        file_put_contents($filename, json_encode($articles));
        header('location: /');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once 'includes/head.php' ?>
    <title>Add an Article</title>
    <link rel="stylesheet" href="/public/css/add-article.css">
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="block p-20 form-container">
                <h1>Write an article</h1>
                <form action="/add-article.php" method="post">
                    <div class="form-control">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" value=<?= $title ?? '' ?>>
                        <?php if ($errors['title']) : ?>
                        <p class="text-danger">
                            <?= $errors['title'] ?>
                        </p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="image">Image</label>
                        <input type="text" name="image" id="image" value=<?= $image ?? '' ?>>
                        <?php if ($errors['image']) : ?>
                        <p class="text-danger">
                            <?= $errors['image'] ?>
                        </p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="category">Category</label>
                        <select name="category" id="category">
                            <option value="technology">Technology</option>
                            <option value="science">Science</option>
                            <option value="health">Health</option>
                            <option value="nature">Nature</option>
                            <option value="politic">Politic</option>
                            <option value="serie">Serie</option>
                            <option value="film">Film</option>
                            <option value="gaming">Gaming</option>
                        </select>
                        <?php if ($errors['category']) : ?>
                        <p class="text-danger">
                            <?= $errors['category'] ?>
                        </p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" value=<?= $content ?? '' ?>></textarea>
                        <?php if ($errors['content']) : ?> <p class="text-danger">
                            <?= $errors['content'] ?>
                        </p>
                        <?php endif; ?>
                    </div>
                    <div class="form-actions">
                        <a href="/" class="btn btn-secondary" type="button">Cancel</a>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
</body>

</html>