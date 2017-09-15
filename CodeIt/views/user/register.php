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
                        <h2>Регистрация на сайте</h2>
                        <form action="#" method="post">

                            <label>
                                <p>E-mail</p>
                                <input type="email" name="email"  value="<?php echo $email; ?>"/>
                            </label>
                            <label>
                                <p>Логин</p>
                                <input type="text" name="login"  value="<?php echo $login; ?>"/>
                            </label>
                            <label>
                                <p>Ваше Имя</p>
                                <input type="text" name="name"  value="<?php echo $name; ?>"/>
                            </label>
                            <label>
                                <p>Пароль</p>
                                <input type="password" name="password1"  value=""/>
                            </label>
                            <label>
                                <p>Повторите Пароль</p>
                                <input type="password" name="password2"  value=""/>
                            </label>
                            <label>
                                <p>Дата рождения</p>
                                <input type="date" min="1910-01-01" max="2020-01-01" name="birthday"  value="<?php echo $birthday; ?>"/>
                            </label>
                            <label>
                                <p>Страна</p>
                                <select name="country" value="<?php echo $country; ?>"/>
                                    <?php foreach ($countries as $selectedCountry) :?>
                                    <option value="<?php echo $selectedCountry['name_ru'];?>"><?php echo $selectedCountry['name_ru'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </label>
                            <input type="submit" name="submit" class="btn btn-default" value="Регистрация" />
                            <p class="agree"><input type="checkbox" name="agree" value="agree">Я принимаю условия соглашения</p>
                        </form>
                    </div><!--/sign up form-->
                
            </div>
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>