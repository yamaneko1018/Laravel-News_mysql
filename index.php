<?php
  include 'lib/connect.php';
  include 'lib/queryArticle.php';
  include 'lib/article.php';

  $queryArticle = new QueryArticle();
  $articles = $queryArticle->findAll();
?>


<!doctype html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog</title>

    <link href="./css/index.css" rel="stylesheet">

  </head>
  <body>


<main>

  <?php if ($articles): ?>
  <?php foreach ($articles as $article): ?>
      <article class="blog-post">
        <h2 class="blog-post-title">
          <a href="view.php?id=<?php echo $article->getId() ?>">
            <?php echo $article->getTitle() ?>
          </a>
        </h2>
        <p class="blog-post-meta"><?php echo $article->getCreatedAt() ?></p>
        <?php echo nl2br($article->getBody()) ?>
      </article>
  <?php endforeach ?>
<?php else: ?>
      <div class="alert alert-success">
        <p>記事はありません。</p>
      </div>
<?php endif ?>


</main>

  </body>
</html>
