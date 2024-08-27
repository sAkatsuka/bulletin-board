<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'nav.php'; ?>

<?php
unset($_SESSION['customer']);

$pdo = new PDO('mysql:host=localhost; dbname=board; charset=utf8',
                'root', '');
$sql = $pdo -> prepare('SELECT * FROM customer WHERE login=? AND password=?');
$sql -> execute ([$_REQUEST['login'], $_REQUEST['password']]);

$row = $sql-> fetch (PDO::FETCH_ASSOC);

// ログインの処理
if ($row) {
    $_SESSION['customer'] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'login' => $row['login'],
        'password' => $row['password']
    ];
    echo '<p class="log">いらっしゃいませ、', $_SESSION['customer']['name'], 'さん。</p>';
} else {
    echo '<p class="log">ログイン名またはパスワードが違います。</p>';
}
?>

<?php require 'footer.php'; ?>
