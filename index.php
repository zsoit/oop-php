<?php
    define("TYTUL_APLIKACJI", "Piłka nożna APP");

    function Main()
    {
        include_once './class/Aplikacja.php';
        $Zadanie = new Pilkanozna\Aplikacja;
        $Zadanie->KontrolerStrony();
    }
?>
<html lang="pl">
<head><?php include_once './components/head.php'; ?></head>
<body>
    <?php include_once './components/header.php'; ?>

    <main>
        <?php Main(); ?>
    </main>

    <?php include_once './components/footer.php'; ?>
</body>
</html>




