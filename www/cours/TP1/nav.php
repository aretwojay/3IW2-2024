<nav>
    <?php 
        print_r($_SESSION);
        if (isset($_SESSION['user'])) {
            echo '<ul>
                <li>Déconnexion</li>
            </ul>';
        } else {
            echo '<ul>
                <li>
                    <a href="./register.php">Inscription</a>
                </li>
                <li>
                    <a href="./login.php">Connexion</a>
                </li>    
            </ul>';
        }
    ?>
</nav>