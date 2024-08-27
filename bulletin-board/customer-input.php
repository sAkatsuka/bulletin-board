<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'nav.php'; ?>

<?php

$name = $login = $password = '';
if (isset($_SESSION['customer'])) {
    $name = $_SESSION['customer']['name'];
    $login = $_SESSION['customer']['login'];
    $password = $_SESSION['customer']['password'];
}

echo '<form action="customer-output.php" method="post">';
echo '<table class="custom">';
echo '<tr><td>お名前</td><td>';
echo '<input type="text" name="name" value="', $name, '">';
echo '</td></tr>';
echo '<tr><td>ログイン名</td><td>';
echo '<input type="text" name="login" value="', $login, '">';
echo '</td></tr>';
echo '<tr><td>パスワード</td><td>';
echo '<input type="password" name="password" value="', $password, '">';
echo '</td></tr>';
echo '</table>';
echo '<p class="center"><input type="submit" value="確定"></p>';
echo '</form>';

?>

<?php require 'footer.php'; ?>
