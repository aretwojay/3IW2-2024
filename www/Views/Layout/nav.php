<nav>
    <ul>
        <li>
            <a href="/">Accueil</a>
        </li>
        <?php 
            if (isset($_SESSION['user'])) {
                echo '<li>
                        <a href="/logout">Déconnexion</a>
                    </li>';
            } else {
                echo '<li>
                        <a href="/sinscrire">Inscription</a>
                    </li>
                    <li>
                        <a href="/login">Connexion</a>
                    </li>';
            }
        ?>
    </ul>
</nav>