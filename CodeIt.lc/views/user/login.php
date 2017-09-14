<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <div class="col-sm-4 col-sm-offset-4 padding-right">

                <?php if (isset($errors) && is_array($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li> - <?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <div class="signup-form"><!--sign up form-->
                    <h2>Вход на сайт</h2>
                    <form action="#" method="post">
                        <label>
                            <p>E-mail or Login</p>
                            <input type="text" name="login" value=""/>
                        </label>
                        <label>
                            <p>Password</p>
                            <input type="password" name="password"  value=""/>
                        </label>
                        <p><input type="submit" name="submit" class="btn btn-default" value="Вход" /></p>
                    </form>
                    <p><a href="/user/register">Регистрация</a></p>
                </div><!--/sign up form-->

            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>