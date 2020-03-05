<?php
$start = (int)$_POST['start'];
/* Подключение к серверу MySQL */
$link = mysqli_connect(
    'localhost',  /* Хост, к которому мы подключаемся */
    'root',       /* Имя пользователя */
    '',   /* Используемый пароль */
    'belsotbit');     /* База данных для запросов по умолчанию */

if (!$link) {
    printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
    exit;
}
$loadfile = 'excel/'.$_POST['excel_name'].'.xls'; // получаем имя загруженного файла
require_once $_SERVER['DOCUMENT_ROOT']."/Classes/PHPExcel/IOFactory.php"; // подключаем класс для доступа к файлу
$objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT']."/".$loadfile);
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) // цикл обходит страницы файла
{
    $highestRow = $start+(int)$_POST['count_row']; // получаем количество строк

    for ($row = $start; $row <= $highestRow; ++ $row) // обходим все строки
    {
        $cell1 = $worksheet->getCellByColumnAndRow((int)$_POST['product_id'], $row); //артикул
        $cell2 = $worksheet->getCellByColumnAndRow((int)$_POST['title'], $row); //наименование
        $cell3 = $worksheet->getCellByColumnAndRow((int)$_POST['count'], $row); //количество
        $cell4 = $worksheet->getCellByColumnAndRow((int)$_POST['price'], $row); //цена
         $sql = "INSERT INTO `products` (`product_id`,`title`,`price`,`count`) VALUES
        ('$cell1','$cell2','$cell3','$cell4')";
        $query = mysqli_query($link,$sql) or die('Ошибка');
    }
}


/* Закрываем соединение */
mysqli_close($link);