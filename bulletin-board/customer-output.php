<?php session_start() ?>

<?php require 'header.php'; ?>
<?php require 'nav.php'; ?>

<?php

$pdo = new PDO(
    "mysql:dbname=board;host=localhost", "root", "",
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'"));

// ユーザ情報の確認
if (isset($_SESSION['customer'])) {
    $id=$_SESSION['customer']['id'];
    $sql=$pdo->prepare('SELECT * FROM customer WHERE id!=? and login=?');
    $sql->execute([$id,$_REQUEST['login']]);
// ログインがない場合ログイン名を確認
} else {
    $sql=$pdo->prepare('SELECT * FROM customer WHERE login=?');
    $sql->execute([$_REQUEST['login']]);
}

if (empty($sql->fetchALL())) {  //ログイン名に重複がない事を確認
// ログインしているときの処理
    if (isset($_SESSION['customer'])) {
        $sql=$pdo->prepare('UPDATE customer SET name=?,
        login=?, password=? WHERE id=?');
        $sql->execute([
            $_REQUEST['name'], $_REQUEST['login'], $_REQUEST['password'],$id
        ]);
        $_SESSION['customer']=[
            'id'=>$id, 'name'=>$_REQUEST['name'], 'login'=>$_REQUEST['login'],
            'password'=>$_REQUEST['password']
        ];
        echo '<p class="log">情報を更新しました。</p>';
// ログインしていない時の処理
    } else {
        $sql=$pdo->prepare('INSERT INTO customer VALUES(NULL, ?, ?, ?)');
        $sql->execute([
            $_REQUEST['name'], $_REQUEST['login'], $_REQUEST['password']
        ]);
        echo '<p class="log">情報を登録しました。</p>';
    } 
// ログイン名が重複しているときの処理
} else {
    echo '<p class="log">ログイン名が既に使用されています。変更してください。</p>';
}

?>

<?php require 'footer.php'; ?>
