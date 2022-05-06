<?php
class Article{
  private $id; //articleテーブルのカラムと同じパラメータを持つ
  private $title;
  private $body;
  private $created_at;
  private $updated_at;

  public function save(){  //saveメソッドは呼び出されるとQueryArticleクラスのインスタンスを作成
    $queryArticle = new QueryArticle();
    $queryArticle->setArticle($this);  //setArticleメソッドでArticleクラスのインスタンスである自分自身をセット
    $queryArticle->save();  //保存
  }

  public function delete(){
    $queryArticle = new QueryArticle();
    $queryArticle->setArticle($this);
    $queryArticle->delete();
  }

  public function getId(){
    return $this->id;
  }

  public function getTitle(){
    return $this->title;
  }

  public function getBody(){
    return $this->body;
  }

  public function getCreatedAt(){
    return $this->created_at;
  }

  public function getUpdatedAt(){
    return $this->updated_at;
  }

  public function setId($id){
    $this->id = $id;
  }

  public function setTitle($title){
    $this->title = $title;
  }

  public function setBody($body){
    $this->body = $body;
  }

  public function setCreatedAt($created_at){
    $this->created_at = $created_at;
  }

  public function setUpdatedAt($updated_at){
    $this->updated_at = $updated_at;
  }
}
