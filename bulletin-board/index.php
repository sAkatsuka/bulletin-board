<?php 
session_start(); 
require 'header.php'; 
require 'nav.php'; 

// DB接続情報を設定
$pdo = new PDO(
    "mysql:dbname=board;host=localhost", "root", "",
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'")
);

$regist = $pdo->prepare('SELECT * FROM post');
$regist->execute();

// ユーザがログインしているかを確認
// ログインしていない時の表示処理
if (!isset($_SESSION['customer'])) {
    echo '<h1 class="center">掲示板</h1>';
    echo '<section class="center">';
    echo '<p>投稿するにはログインが必要です。</p>';
    echo '<h2>新規投稿</h2>';
    echo '<form action="send.php" method="post">';
    echo '<p>名前：<input type="text" name="name" value="" class="name"></p>';
    echo '<p>投稿内容：<textarea name="contents" value="" class="contents"></textarea></p>';
    echo '</form>';
    echo '<hr class="line">';
    echo '</section>';
// ログインしているときの表示処理
} else {
    $sql = $pdo->prepare('SELECT * FROM customer WHERE id=?');
    $sql->execute([$_SESSION['customer']['id']]);
    echo '<h1 class="center">掲示板</h1>';
    echo '<section class="center">';
    echo '<h2>新規投稿</h2>';
    echo '<form action="send.php" method="post">';
    echo '<input type="hidden" name="customer_id" value="', $_SESSION['customer']['id'], '">';
    echo '<p>名前：<input type="text" name="name" value="', $_SESSION['customer']['name'], '" class="name"></p>';
    echo '<p>投稿内容：<textarea name="contents" value="" class="contents"></textarea></p>';
    echo '<button type="submit">投稿</button>';
    echo '</form>';
    echo '<hr>';
    echo '</section>';
}
?>

<!-- 投稿内容の表示 -->
<section>
    <h2 class="center">投稿内容一覧</h2>
    <?php 
    foreach ($regist as $loop) {
        $contents = htmlspecialchars($loop['contents']);
        $shortContents = mb_strimwidth($contents, 0, 50, '...'); // 50文字でカットし末尾は...

        echo '<table class="table">';
        echo '<tr><td>No：', $loop['id'], '</td></tr>';
        echo '<tr><td>名前：', htmlspecialchars($loop['name']), '</td></tr>';
// 投稿内容の表示形式
        echo '<tr><td>投稿内容：<span class="short-content">', $shortContents, 
        '</span><span class="full-content" style="display:none;">', 
        $contents, '</span> <a href="#" class="toggle-content">続きを読む</a></td></tr>';
// ログインしていれば投稿内容と投稿者の情報を紐づける
        if (isset($loop['customer_id'])) {
            $user_stmt = $pdo->prepare('SELECT name FROM customer WHERE id=?');
            $user_stmt->execute([$loop['customer_id']]);
            $user = $user_stmt->fetch();
            echo '<tr><td>投稿者ID：', $loop['customer_id'], ' (', htmlspecialchars($user['name']), ')</td></tr>';
        }
        echo '</table>';
    }
    ?>
<p class="retop"><a href="#">トップに戻る</a></p>
</section>

<?php require 'footer.php'; ?>

<!-- 投稿表示の切り替え -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggle-content').forEach(function(element) {
        element.addEventListener('click', function(event) {
            event.preventDefault();
            const shortContent = this.previousElementSibling.previousElementSibling;
            const fullContent = this.previousElementSibling;
            if (shortContent.style.display === 'none') {
                shortContent.style.display = 'inline';
                fullContent.style.display = 'none';
                this.textContent = '続きを読む';
            } else {
                shortContent.style.display = 'none';
                fullContent.style.display = 'inline';
                this.textContent = '閉じる';
            }
        });
    });
});
</script>
