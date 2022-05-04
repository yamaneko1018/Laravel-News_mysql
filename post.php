<?php
  include 'lib/connect.php'; //DBに接続するために読みこむ
  include 'lib/queryArticle.php';
  include 'lib/article.php';

  $title = "";        // タイトル
  $body = "";         // 本文
  $title_alert = "";  // タイトルのエラー文言
  $body_alert = "";   // 本文のエラー文言

  if (!empty($_POST['title']) && !empty($_POST['body'])){
    // titleとbodyがPOSTメソッドで送信されたとき
    $title = $_POST['title'];
    $body = $_POST['body'];

    if(30 <= mb_strlen($title)){
      $title_alert = "30字以内で入力してください。";
    }else{
      $article = new Article();  //Articleクラスのインスタンスを作成。値は何も入っていない状態。
      $article->setTitle($title);  //タイトルをセット
      $article->setBody($body);  //本文をセット
      $article->save(); //saveメソッドで保存
      header('Location: post.php');
    }


    //$article = new Article();  //Articleクラスのインスタンスを作成。値は何も入っていない状態。
    //$article->setTitle($title);  //タイトルをセット
    //$article->setBody($body);  //本文をセット
    //$article->save(); //saveメソッドで保存

  } elseif(!empty($_POST)){
    // POSTメソッドで送信されたが、titleかbodyが足りないとき
    // 存在するほうは変数へ、ない場合空文字にしてフォームのvalueに設定する
    if (empty($_POST['title'])){
      $title_alert = "タイトルを入力してください。";
    }

    if (!empty($_POST['body'])){
      $body = $_POST['body'];
    } else {
      $body_alert = "本文を入力してください。";
    }
  }
  $queryArticle = new QueryArticle();
  $articles = $queryArticle->findAll();
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

  <h2 class="share">さぁ、最新のニュースをシェアしましょう</h2>

<form action="post.php" method="post" onSubmit="return checkSubmit()">
  <div>
    <label for="title">タイトル</label>
    <?php echo !empty($title_alert)? '<div class="alert alert-danger">'.$title_alert.'</div>': '' ?>
    <input type="text" name="title" value="<?php echo $title; ?>" class="form-control">  </div>
  <div>
    <label for="message">記事</label>
    <?php echo !empty($body_alert)? '<div class="alert alert-danger">'.$body_alert.'</div>': '' ?>
    <textarea name="body" rows="10"><?php echo $body; ?></textarea>  </div>
  <div>
    <button type="submit" class="btn-submit">投稿</button>
  </div>
</form>
<script type="text/javascript">
  function checkSubmit() {
  return confirm("投稿してよろしいですか？");
  }
</script>

<main>
<?php if ($articles): ?>
  <?php foreach ($articles as $article): ?>
      <article>
        <h2>
            <?php echo $article->getTitle() ?>
        </h2>
        <?php
        $limit = 60;
        $text = $article->getBody();
        ?>
        <?php if(mb_strlen($text) > $limit): ?>
          <?php $part_text = mb_substr($text,0,$limit); ?>
            <p><?=$part_text. '・・・';?></p>
          <?php else: ?>
            <p><?=$text?></p>
        <?php endif; ?>

        <a href="view.php?id=<?php echo $article->getId() ?>">
            <?php echo "記事本文・コメントを見る" ?>
        </a>
      </article>
  <?php endforeach ?>
<?php else: ?>
      <div>
        <p>記事はありません。</p>
      </div>
<?php endif ?>
</main>
  </body>
</html>
