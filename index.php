<?php

    /*    Техническое задание
    - Сделать интерфейс для загрузки изображений по ссылке на страницу из интернета, с указанием размера картинок и полем для ввода произвольного текста, которые будут загружаться с указанной страницы, картинки ниже этих размеров грузится не должны.

    - найденные картинки уменьшаем по высоте до размера 200px и по ширине обрезаем на 200px до квадрата и ставим на картинку текст.

    - форма должна обрабатываться через AJAX с последующим выводом этих картинок на экран, без перезагрузки страницы, из каталога, при перезагрузке страницы так же  уже сохраненные картинки должны выводится.
    */
    error_reporting(0);

    use Controller\Controller;
    use View\View;
    use Model\App;

    require './vendor/autoload.php';
    // a little bit MVC
    $model = new App();
    $controller = new Controller($model);
    $view = new View($controller, $model);
    if (isset($_POST['action']) && !empty($_POST['action'])) {
        $controller->{$_POST['action']}($_POST);
        echo $view->asJSON();
        return;
    }
    echo $view->allHTML();