<?php
  include 'lib/secure.php';
  include 'lib/connect.php';
  include 'lib/queryReview.php';
  include 'lib/review.php';

  if (!empty($_GET['id'])){    //GETメソッドでidがあればQueryReviewクラスのインスタンスを作成し、Reviewをテーブルからidをキーに検索
    $queryReview = new QueryReview();
    $review = $queryReview->find($_GET['id']);
    if ($review){
      $review->delete();
    }
  }
  header('Location: view.php');
  ?>