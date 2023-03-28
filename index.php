
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piłka nożna - app</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="alert alert__nazwa">PIŁKARZE - APP</div>

    <?php
    include_once 'class/Aplikacja.php';
    $Zadanie = new Pilkanozna\Aplikacja;
    $Zadanie->KontrolerStrony();
?>

</body>
</html>

