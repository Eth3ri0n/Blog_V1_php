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
                        <input type="text" name="title" id="title">
                        <!-- <p class="text-error"></p> -->
                    </div>
                    <div class="form-control">
                        <label for="image">Image</label>
                        <input type="text" name="image" id="image">
                        <!-- <p class="text-error"></p> -->
                    </div>
                    <div class="form-control">
                        <label for="category">Category</label>
                        <select name="category" id="category">
                            <option value="technology">Technology</option>
                            <option value="nature">Nature</option>
                            <option value="politic">Politic</option>
                        </select> <!-- <p class="text-error"></p> -->
                    </div>
                    <div class="form-control">
                        <label for="content">Content</label>
                        <textarea name="content" id="content"></textarea>
                        <!-- <p class="text-error"></p> -->
                    </div>
                    <div class="form-actions">
                        <a href="/" class="btn btn-secondary" type="button">Cancel</a>
                        <button class="btn btn-primary" type="button">Save</button>
                    </div>
                </form>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>
</body>

</html>