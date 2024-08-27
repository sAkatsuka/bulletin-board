<?php 
session_start();
require 'header.php';
require 'nav.php';

$pdo = new PDO(
    "mysql:dbname=board;host=localhost", "root", "",
    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'")
);

// 投稿内容の文字の表示数制限
function shortenContent($content, $limit = 10) {
    if (mb_strlen($content, 'UTF-8') > $limit) {
        return mb_substr($content, 0, $limit, 'UTF-8') . '...';
    } else {
        return $content;
    }
}

// ログイン確認
if (isset($_SESSION['customer'])) {
    $customerId = $_SESSION['customer']['id'];
    
    $sql = $pdo->prepare('SELECT * FROM post WHERE customerId=?');
    $sql->execute([$customerId]);

    $rows = $sql->fetchAll(PDO::FETCH_ASSOC);

// 投稿がある場合はその内容をそれぞれ表示
    if (count($rows) > 0) {
        foreach($rows as $row) {
            $shortenedContent = htmlspecialchars(shortenContent($row['contents'], 10));
            echo '<div class="p-dele">';
            echo '<p class="log">投稿内容：<span class="contents">', $shortenedContent, '</span></p>';

            echo '<form action="delete-output.php" method="post" style="display:inline;" onsubmit="return confirmDelete();">';
            echo '<input type="hidden" name="post_id" value="', htmlspecialchars($row['id']), '">';
            echo '<p class="log"><button type="submit">削除</button></p>';
            echo '</form><br>';
            echo '</div>';
        }
        echo '<p class="retop"><a href="#">トップに戻る</a></p>';
// 投稿がない時の処理
    } else {
        echo '<p class="log">投稿がありません。</p>';
    }
// ログインしていない時の処理
} else {
    echo '<P class="log">削除する為にはログインしてください。</p>';
}

require 'footer.php';
?>

<!-- 削除ボタンを押したときの処理としてダイアログを表示-->
<script>
function confirmDelete() {
    return confirm("本当に削除しますか？"); //YESなら削除、NOなら削除処理をしない。
}
</script>
