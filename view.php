<?php
  include 'lib/connect.php';
  include 'lib/queryArticle.php';
  include 'lib/article.php';
  include 'lib/queryReview.php';
  include 'lib/review.php';

  $body = "";
  $body_alert = "";

  if (!empty($_GET['id'])){
    $id = intval($_GET['id']);

    $queryArticle = new QueryArticle();
    $article = $queryArticle->find($id);  //指定記事IDの記事を取得
  } else {
    $article = null;
  }


  if (!empty($_POST['comment'])){
    // commentがPOSTメソッドで送信されたとき
    $comment = $_POST['comment'];

    $review = new Review();  //Reviewクラスのインスタンスを作成。値は何も入っていない状態。
    $review->setBody($comment);  //コメントをセット
    $review->save(); //saveメソッドで保存

    header('Location: view.php');
  } else if(!empty($_POST)){
    // POSTメソッドで送信されたが、commentが足りないとき
    // 存在するほうは変数へ、ない場合空文字にしてフォームのvalueに設定する
    if (!empty($_POST['comment'])){
      $comment = $_POST['comment'];
      if(50 <= mb_strlen($title));
      $body_alert = "50字以内で入力してください。";
    } else {
      $body_alert = "コメントを入力してください。";
    }
  }
  $queryReview = new QueryReview();
  $reviews = $queryReview->findAll();
  ?>


<!doctype html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel News</title>
  </head>
  <body>
  <h1 class="theme"><a href="http://localhost:8080/blog/post.php" style="text-decoration:none;">Laravel News</a></h1>
  <main>
    <?php if ($article): ?>
      <?php var_dump($_POST) ?>
      <article class="blog-post">
        <h2 class="blog-post-title"><?php echo $article->getTitle() ?></h2>
        <?php echo nl2br($article->getBody()) ?>
      </article>
    <?php endif ?>
  </main>
    <section>
      <form action="view.php" method="post">
      <?php echo !empty($body_alert)? '<div class="alert alert-danger">'.$body_alert.'</div>': '' ?>
      <textarea name="comment" rows="10"><?php echo $body; ?></textarea>  </div>
      <div>
        <button type="submit" class="btn-submit">コメントする</button>
      </div>
      </form>
    </section>
    <section>
    <?php if ($reviews): ?>
  <?php foreach ($reviews as $review): ?>
      <article>
        <?php echo nl2br($review->getBody()) ?>
        <a href="delete.php?id=<?php echo $review->getId() ?>">削除</a>
      </article>
  <?php endforeach ?>
<?php else: ?>
      <div>
        <p>コメントはありません。</p>
      </div>
<?php endif ?>



    </section>
</body>
</html>
