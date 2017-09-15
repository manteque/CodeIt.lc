<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Главная</title>
        <link href="../template/css/bootstrap.min.css" rel="stylesheet">
        <link href="../template/css/font-awesome.min.css" rel="stylesheet">
        <link href="../template/css/main.css" rel="stylesheet">    

        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <![endif]-->       

    </head><!--/head-->

    <body>
        <header id="header"><!--header-->
            
            <div class="header-middle"><!--header-middle-->
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4">
                            
                        </div>
                        <div class="col-sm-8">
                        
                                <ul class="nav navbar-nav">
                                    
                                    <?php if (User::isGuest()): ?>                                        
                                        <li><a href="../user/login"><i class="fa fa-lock"></i> Вход</a></li>
                                    <?php else: ?>
                                        <li><a href="../user/cabinet"><i class="fa fa-user"></i> Аккаунт</a></li>
                                        <li><a href="../user/logout"><i class="fa fa-unlock"></i> Выход</a></li>
                                    <?php endif; ?>
                                </ul>
                          
                        </div>
                    </div>
                </div>
            </div><!--/header-middle-->

        </header><!--/header-->