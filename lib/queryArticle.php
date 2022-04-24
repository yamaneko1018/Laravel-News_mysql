<?php
class QueryArticle extends connect{  //connectクラスを親として継承
  private $article; //プライベートなパラメータ

  public function __construct(){
    parent::__construct();  //インスタンスが生成されると親のコンストラクトを実行
  }

  public function setArticle(Article $article){ //Artcleクラスの変数しか受け取りたくない
    $this->article = $article;  //articleに値($article)をセット。Articleクラスのインスタンスを受け取ったら自身のパラメータとして保持
  }

  public function save(){
    if ($this->article->getId()){
      // 保持している$articleにIDがあるときは上書き
    } else {
      // IDがなければ新規作成
      $title = $this->article->getTitle();
      $body = $this->article->getBody();
      $stmt = $this->dbh->prepare("INSERT INTO articles (title, body, created_at, updated_at)
                VALUES (:title, :body, NOW(), NOW())");
      $stmt->bindParam(':title', $title, PDO::PARAM_STR);  //bindParamメソッドでプリペアドステートメントに値を割り当てている
      $stmt->bindParam(':body', $body, PDO::PARAM_STR);  //第１引数のプレースホルダーに、第二引数の変数、第３引数のデータ型指定（文字列）。第二引数は変数でなければいけない
      $stmt->execute();

    }   
  }

  public function delete(){
    if ($this->article->getId()){
      $id = $this->article->getId();
      $stmt = $this->dbh->prepare("UPDATE articles SET is_delete=1 WHERE id=:id");
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
    }   
  }

  public function find($id){
    $stmt = $this->dbh->prepare("SELECT * FROM articles WHERE id=:id AND is_delete=0");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);  //:idを$idで置き換え、数値なのでPDO::PARAM_INTとして扱うよう指定
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);    //結果セットを全て配列として受け取る
    $article = null;    //もし指定したレコードが存在しない場合nullが戻り値になるよう、あらかじめ$articleにnullを代入
    if ($result){     //取得した内容は$articleに代入
      $article = new Article();
      $article->setId($result['id']);
      $article->setTitle($result['title']);
      $article->setBody($result['body']);
      $article->setCreatedAt($result['created_at']);
      $article->setUpdatedAt($result['updated_at']);
    }
    return $article;
  }


  public function findAll(){  //findAllはarticlesテーブルから全権取得し、配列に入れて返す
    $stmt = $this->dbh->prepare("SELECT * FROM articles WHERE is_delete=0 ORDER BY created_at DESC");  //SQL
    $stmt->execute();                                       //SQL実行
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);           //結果セットを全て配列として受け取る
    $articles = array();                                    //戻り値$articleはarray()とすることで空の配列を作成
    foreach ($results as $result){                          //結果セット（配列）をArticleクラスのインスタンスにして配列にする
      $article = new Article();
      $article->setId($result['id']);
      $article->setTitle($result['title']);
      $article->setBody($result['body']);
      $article->setCreatedAt($result['created_at']);
      $article->setUpdatedAt($result['updated_at']);
      $articles[] = $article;
    }
    return $articles;               //findAll()メソッドの戻り値はArticleがたくさん入った配列$articlesになる
  }
}
