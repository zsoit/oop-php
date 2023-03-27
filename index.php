
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piłka nożna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
    include_once 'class/PilkaNozna.php';
    include_once 'class/SzablonHtml.php';

    $Zadanie = new PilkaNozna();
    $Zadanie->KontrolerStrony();
?>

</body>
</html>

