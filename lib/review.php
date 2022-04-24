<?php
class Review{
  private $id; //Reviewテーブルと同じパラメータを持つ
  private $title;
  private $body;
  private $category_id;
  private $created_at;
  private $updated_at;

  public function save(){  //saveメソッドは呼び出されるとQueryReviewクラスのインスタンスを作成
    $queryReview = new QueryReview();
    $queryReview->setReview($this);  //setReviewメソッドでReviewクラスのインスタンスである自分自身をセット
    $queryReview->save();  //保存
  }

  public function delete(){
    $queryReview = new QueryReview();
    $queryReview->setReview($this);
    $queryReview->delete();
  }

  public function getId(){
    return $this->id;
  }


  public function getBody(){
    return $this->body;
  }

  public function getCategoryId(){
    return $this->category_id;
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


  public function setBody($body){
    $this->body = $body;
  }

  public function setCategoryId($category_id){
    $this->category_id = $category_id;
  }

  public function setCreatedAt($created_at){
    $this->created_at = $created_at;
  }

  public function setUpdatedAt($updated_at){
    $this->updated_at = $updated_at;
  }
}
