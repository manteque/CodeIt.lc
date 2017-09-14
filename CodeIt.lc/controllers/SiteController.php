<?php
/**
 * Контроллер CartController
 */
class SiteController
{
    /**
     * Action для главной страницы
     */
    public function actionIndex()
    {
        header("Location: user/login");
        return true;
    }
}