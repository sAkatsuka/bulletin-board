<?php 
session_start();
require 'header.php'; 
require 'nav.php'; 

$name = $_POST["name"];
$contents = $_POST["contents"];
date_default_timezone_set('Asia/Tokyo');

$pdo = new PDO(
    "mysql:dbname=board;host=localhost", "root", "", 
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'")
);

// 送信時の処理
if (empty($_POST['name'])) {    //名前が空欄の時の処理
    echo '<p class="log">名前を入力してください。<p>';
} elseif (empty($_POST['contents'])) {  //投稿内容が空欄の時の処理
    echo '<p class="log">投稿内容を入力してください。<p>';
} else {    //投稿内容の処理
    $name = $_POST['name'];
    $contents = $_POST['contents'];
    $customer_id = $_POST['customer_id'];

    $sql = $pdo->prepare('INSERT INTO post (name, contents, customerId) VALUES (?, ?, ?)');
    $sql->execute([$name, $contents, $customer_id]);

    echo '<h1 class="center">掲示板</h1>';
    echo '<section class="center">';
    echo '<h2>投稿完了</h2>';
    echo '</section>';
    echo '<form action="index.php">';
    echo '<div class="center">';
    echo '<button type="submit">戻る</button>';
    echo '</div>';
    echo '</form>';
}
?>

<?php require 'footer.php'; ?>
