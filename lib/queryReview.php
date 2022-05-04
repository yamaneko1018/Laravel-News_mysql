<?php
class QueryReview extends connect{  //connectクラスを親として継承
  private $Review; //プライベートなパラメータ

  public function __construct(){
    parent::__construct();  //インスタンスが生成されると親のコンストラクトを実行
  }

  public function setReview(Review $review){ //Artcleクラスの変数しか受け取りたくない
    $this->review = $review;  //reviewに値($review)をセット。Reviewクラスのインスタンスを受け取ったら自身のパラメータとして保持
  }

  public function save(){
    if ($this->review->getId()){
      // 保持している$reviewにIDがあるときは上書き
    } else {
      // IDがなければ新規作成
      $body = $this->review->getBody();
      $article_id = $this->review->getArticleId();
      $stmt = $this->dbh->prepare("INSERT INTO reviews (body, article_id, created_at, updated_at)
                VALUES (:body, :article_id, NOW(), NOW())");
      $stmt->bindParam(':body', $body, PDO::PARAM_STR);  //第１引数のプレースホルダーに、第二引数の変数、第３引数のデータ型指定（文字列）。第二引数は変数でなければいけない
      $stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);  //第１引数のプレースホルダーに、第二引数の変数、第３引数のデータ型指定（文字列）。第二引数は変数でなければいけない
      $stmt->execute();

    }   
  }

  public function delete(){
    if ($this->review->getId()){
      $id = $this->review->getId();
      $stmt = $this->dbh->prepare("UPDATE reviews SET is_delete=1 WHERE id=:id");
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
    }   
  }

  public function find($id){
    $stmt = $this->dbh->prepare("SELECT * FROM reviews WHERE id=:id AND is_delete=0");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);  //:idを$idで置き換え、数値なのでPDO::PARAM_INTとして扱うよう指定
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);    //結果セットを全て配列として受け取る
    $review = null;    //もし指定したレコードが存在しない場合nullが戻り値になるよう、あらかじめ$reviewにnullを代入
    if ($result){     //取得した内容は$reviewに代入
      $review = new Review();
      $review->setId($result['id']);
      $review->setBody($result['body']);
      $review->setArticleId($result['article_id']);
      $review->setCreatedAt($result['created_at']);
      $review->setUpdatedAt($result['updated_at']);
    }
    return $review;
  }


  public function findAll(){  //findAllはreviewsテーブルから全権取得し、配列に入れて返す
    $stmt = $this->dbh->prepare("SELECT * FROM reviews WHERE is_delete=0 ORDER BY created_at DESC");  //SQL
    $stmt->execute();                                       //SQL実行
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);           //結果セットを全て配列として受け取る
    $reviews = array();                                    //戻り値$reviewはarray()とすることで空の配列を作成
    foreach ($results as $result){                          //結果セット（配列）をReviewクラスのインスタンスにして配列にする
      $review = new Review();
      $review->setId($result['id']);
      $review->setBody($result['body']);
      $review->setCreatedAt($result['created_at']);
      $review->setUpdatedAt($result['updated_at']);
      $reviews[] = $review;
    }
    return $reviews;               //findAll()メソッドの戻り値はReviewがたくさん入った配列$reviewsになる
  }

  public function where($article_id){  
    $stmt = $this->dbh->prepare("SELECT * FROM reviews WHERE is_delete=0 and article_id=$article_id ORDER BY created_at DESC");  //SQL
    $stmt->execute();                                       //SQL実行
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);           //結果セットを全て配列として受け取る
    $reviews = array();                                    //戻り値$reviewはarray()とすることで空の配列を作成
    foreach ($results as $result){                          //結果セット（配列）をReviewクラスのインスタンスにして配列にする
      $review = new Review();
      $review->setId($result['id']);
      $review->setBody($result['body']);
      $review->setCreatedAt($result['created_at']);
      $review->setUpdatedAt($result['updated_at']);
      $reviews[] = $review;
    }
    return $reviews;               //findAll()メソッドの戻り値はReviewがたくさん入った配列$reviewsになる
  }

}
