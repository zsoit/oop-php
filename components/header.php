<header>
    <div class="alert alert__nazwa">
        <a href="index.php">
        <img
            src="https://cdn.pixabay.com/photo/2012/04/05/01/46/soccer-25762_1280.png"
            alt="Przykładowe logo"
            width="40px"
        >
        </a>
        <a href="index.php"><?php echo TYTUL_APLIKACJI; ?></a>
    </div>

    <div class="menu alert">

        <div class="menu__item">
            <a class="fakeBtn" href="index.php">
                <i class="fa-solid fa-house"></i>
                <span>Strona Główna</span>
            </a>
        </div>

        <div class="menu__item">
            <a class="fakeBtn" href="index.php?co=formularz_dodaj">
                <i class="fa-solid fa-user-plus"></i>
                <span>Dodaj</span>
            </a>
        </div>
        <div class="menu__item menu__item--search">
            <form action="index.php?co=szukaj" method="POST">
                <input class="fakeBtn"  type="text" name="slowo" placeholder="Imie lub nazwisko" required>
                <button class="fakeBtn" >
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span>Szukaj</span>
                </button>
                </form>
        </div>
    </div>
</header>