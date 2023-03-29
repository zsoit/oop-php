<?php
function Main()
{
    include_once './class/Aplikacja.php';
    $Zadanie = new Pilkanozna\Aplikacja;
    $Zadanie->KontrolerStrony();
}

?>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piłka nożna - app</title>
    <link rel="stylesheet" href="src/style.css">
</head>
<body>
    <?php include_once './components/header.php'; ?>

    <main>
        <?php Main(); ?>
    </main>

    <?php include_once './components/footer.php'; ?>
</body>
</html>

