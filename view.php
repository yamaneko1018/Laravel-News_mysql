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
    // titleとbodyがPOSTメソッドで送信されたとき
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
    } else {
      $body_alert = "タイトルを入力してください。";
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
</body>
</html>
