<?php 
session_start();
require 'header.php';
require 'nav.php';

$pdo = new PDO(
    "mysql:dbname=board;host=localhost", "root", "",
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'")
);

// post_idが存在しユーザーがログインしているかを確認
if (isset($_POST['post_id']) && isset($_SESSION['customer'])) {
    $postId = $_POST['post_id'];
    $customerId = $_SESSION['customer']['id'];

// 投稿がログインしているユーザーのものであることを確認
    $sql = $pdo->prepare('DELETE FROM post WHERE id=? AND customerId=?');
    $sql->execute([$postId, $customerId]);

// 削除の処理
    if ($sql->rowCount() > 0) {
        echo '<p class="log">投稿を削除しました。</p>';
    } else {
        echo '<p class="log">削除に失敗しました。</p>';
    }
} else {
    echo '<p class="log">削除する為にはログインしてください。</p>';
}

echo '<form action="delete-input.php" method="get">';
echo '<p class="log"><button type="submit">戻る</button></p>';
echo '</form>';

require 'footer.php';
?>
