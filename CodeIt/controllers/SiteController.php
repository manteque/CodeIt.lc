<?php
/**
 * Контроллер SiteController
 */
class SiteController
{
    /**
     * Action для главной страницы
     */
    public function actionIndex()
    {
        header("Location: ../".PART."/user/login");
    }
}