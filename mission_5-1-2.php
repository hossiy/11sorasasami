<!DOCTYPE>
<html jang="ja">
    <head><meta charset="UTF-8">
    <tytle>mission_5-1</tytle>
    </head>
<body>

<?php 
if(!empty($_POST["comment"]))
if(!empty($_POST["name"]))
{$comment = $_POST["comment"];
 $name = $_POST["name"];
 $pass = $_POST["pass"];
 $postedAt = date("Y年m月d日 H:i:s");
}
//データベースに接続
$dsn = 'DD';
$user='number';
$password='password';
$pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
//データベース内にテーブルを作成
$sql = "CREATE TABLE IF NOT EXISTS tb10" 
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"//自動的に追加
."name char(20),"//20文字までに設定
."pass char(20),"
."date char(20),"
."comment TEXT"//コメント機能
.");";
$stmt=$pdo->query($sql);
?>
<!--消去機能-->
<?php
if(!empty($_POST['deletenumber']) && !empty($_POST['deletepassword'])){
 $delete = $_POST['deletenumber'];
 $deletepassword = $_POST['deletepassword'];
   $sql = 'SELECT * FROM tb10';
   $result = $pdo -> query($sql);
   foreach($result as $row){
       if($row['id'] == $delete && $row['pass'] == $deletepassword){ 
           $id = $delete;
           $sql = 'delete from tb10 where id=:id';
           $stmt = $pdo -> prepare($sql);
           $stmt -> bindParam(':id',$id,PDO::PARAM_INT);
           $stmt -> execute();
          }else if($row['id'] == $delete && $row['pass'] !== $deletepassword){
              echo "wrong password";
          }
          }
       }
if(!empty($_POST['edit'])&&!empty($_POST['editpass'])){
    $edit = $_POST['edit'];
    $editpass = $_POST['editpass'];
    $sql = 'SELECT * FROM tb10';
    $result = $pdo -> query($sql);
    foreach($result as $row){
        if($row['id'] == $edit){
            $editnumber = $row['id'];
            $editname = $row['name'];
            $editcomment = $row['comment'];
            $editpassword = $row['pass'];
        }
    }
}
//編集機能
if (!empty($_POST['number']) && !empty($_POST['name']) && !empty($_POST['comment']) && !empty($_POST['pass']))
   {$name = $_POST['name'];
    $number = $_POST['number'];
    $comment = $_POST['comment'];
    $pass = $_POST['pass'];
    $postedAt = date("Y年m月d日 H:i:s");
      $sql = 'SELECT * FROM tb10';
      $result = $pdo -> query($sql);
         foreach ($result as $row){
           if($row['id'] == $number)
              {$id = $number; //変更する投稿番号
              $name = $_POST['name'];
              $comment = $_POST['comment']; 
                   $sql = 'UPDATE tb10 SET name=:name,comment=:comment, date=:date, pass=:pass WHERE id=:id';
                   $stmt = $pdo->prepare($sql);
                   $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                   $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                   $stmt->bindValue(':date', $postedAt, PDO::PARAM_STR);
                   $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
                   $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                   $stmt->execute();
              }              
          }                      
  }else{(!empty($_POST['name']));
    if(!empty($_POST['comment']) && !empty($_POST['pass']))
        {$postedAt = date("Y年m月d日 H:i:s");
        $stmt = $pdo->query($sql);
        $sql = $pdo -> prepare("INSERT INTO tb10 (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindValue(':date', $postedAt, PDO::PARAM_STR);
        $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
        $sql -> execute(); 
      }
      };
?>
<!-- create form-->
<form action=""method="post">
<label>【投稿フォーム】</label><br>
            <input type="text" name="name" placeholder="名前"
            value="<?php if(!empty($_POST['edit']) && !empty($_POST['editpass']) && $editpassword==$editpas){echo $editname;}?>">
            <br>
            <input type="text" name="comment" placeholder="コメント"
            value="<?php if(!empty($_POST['edit']) && !empty($_POST['editpass']) && $editpassword==$editpass){echo $editcomment;}?>">
            <br>
            <input hidden ="text"name="number"placeholder="投稿番号"
            value="<?php if(!empty($_POST['edit']) && !empty($_POST['editpass']) && $editpassword==$editpass){echo $editnumber;}?>">
            <br>
            <input type="text" name="pass" placeholder="パスワード">
            <br>
            <input type="submit" name="submit" value="送信">
            <br>
        </form>
        <br>
        <form action=""method="post">
            <label>【消去フォーム】</label><br>
            <input type="text" name="deletenumber" placeholder="消去"><br>
            <input type="text" name="deletepassword" placeholder="パスワード"><br>
            <input type="submit" name="delete" value="消去"><br>
        </form>
        <br>
        <form action=""method="post">
            <label>【編集番号指定フォーム】</label><br>
            <input type="text" name="edit" placeholder="編集番号指定"><br>
            <input type="text" name="editpassword" placeholder="パスワード"><br>
            <input type="submit" value="編集"><br>
        </form>
<?php
$sql = 'SELECT * FROM tb10';
$stmt = $pdo -> query($sql);
$results = $stmt -> fetchAll();
foreach($results as $row){
    echo (int)$row['id'].',';
    echo $row['name'].',';
    echo $row['comment'].'<br>';
    echo $row['date'].'<br>';
    echo "<hr>";
}
?>