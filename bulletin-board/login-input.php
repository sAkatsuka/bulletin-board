<?php require 'header.php'; ?>
<?php require 'nav.php'; ?>

<form action="login-output.php" method="post">
    <p class="center">ログイン名<input type="text" name="login"></p>
    <p class="center">パスワード<input type="password" name="password"></p>
    <p class="center"><button type="submit">ログイン</button></p>
</form>

<?php require 'footer.php'; ?>
