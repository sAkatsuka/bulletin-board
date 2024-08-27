<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'nav.php'; ?>

<?php

if (isset($_SESSION['customer'])) {
    unset ($_SESSION['customer']);
    echo '<p class="log">ログアウトしました。</p>';
} else {
    echo '<p class="log">すでにログアウトしています。</p>';
}
?>

<?php require 'footer.php'; ?>
