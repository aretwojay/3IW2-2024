<nav>
    <?php 
        if (isset($_SESSION['user'])) {
            echo '<ul>
                <li>
                    <a href="/logout">Déconnexion</a>
                </li>
            </ul>';
        } else {
            echo '<ul>
                <li>
                    <a href="/sinscrire">Inscription</a>
                </li>
                <li>
                    <a href="/login">Connexion</a>
                </li>    
            </ul>';
        }
    ?>
</nav>