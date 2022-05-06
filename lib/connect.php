<?php
class connect{
  //クラス定数。これらの定数をコンストラクタで使う。
  const DB_NAME = "blog";
  const HOST = "localhost:8080";
  const USER = "user";
  const PASS = "pass";

  //プロパティ。クラス自身と継承したクラスで参照するためprotected
  //Data Base Handleの略。DBに接続したのちそのDBを操作するための情報を代入。
  //操作できる状態、車でいうハンドルを入れておく。
  protected $dbh;   


  //コンストラクタはこのクラスからインスタンスが作成された時に自動的に実行されるメソッド。
  public function __construct(){
    
    //DSN。どのホストのどのDBに接続するのかを示す。
    $dsn = "mysql:unix_socket=/tmp/mysql.sock;dbname=blog;charset=UTF8";
    //tryで接続を試みる
    try {
      // 正しく接続できたらクラス変数$dbhにPDOインスタンスを格納。
      //プロパティにアクセスするときは$this->dbhのように、$thisをつける
      $this->dbh = new PDO($dsn, self::USER, self::PASS);
    //例外をcatchで受けとる
    } catch(Exception $e){
      // Exceptionが発生したら表示して終了。DBに接続できなかったら例外(Exceptionを発生させる)
      exit($e->getMessage());
    }

    // DBのエラーを表示するモードを設定
    //setAttributeはDBに関する属性を設定できる。
    //第一引数が「設定する属性（DBのエラーを表示するモード）」、第二引数が「セットする値（エラー時にwarningを発生させる）」を示す
    $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  }


  //publicなのでインスタンスから呼び出すことができる
  //第一引数→SQL、第二引数→割り当てるパラメータ
  public function query($sql, $param = null){
    // SQLを元にプリペアドステートメントを作成し、SQL文を実行する準備をする
    $stmt = $this->dbh->prepare($sql);
    // executeメソッドでパラメータを割り当ててSQLを実行し、結果セットを返す
    $stmt->execute($param);
    return $stmt;
  }
}
?>

