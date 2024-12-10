<?php
    if (isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];
        $_SESSION['errors'] = [];
        echo '<div style="background-color: red">
            <ul>';
                foreach ($errors as $error) {
                    echo '<li>' . $error . '</li>';
                }
            echo '</ul>
        </div>';
    }
?>