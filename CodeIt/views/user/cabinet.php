<?php include ROOT . '/views/layouts/header.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <h1>Страница пользователя</h1>
            
           	<ul>
                <li>Ваше имя: <?php echo $user['name']?></li>
                <li>Ваш E-mail: <?php echo $user['email']?></li>
            </ul>
            
        </div>
    </div>
</section>

<?php include ROOT . '/views/layouts/footer.php'; ?>