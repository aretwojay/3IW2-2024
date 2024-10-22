<?php
    include 'UserValidator.class.php';
    include 'User.class.php';
    //Le code pour s'inscrire
    print_r($_SESSION);

    if (!empty($_POST)) {
        $validator = new UserValidator($_POST);
        $errors = $validator->validate();

        $_SESSION['errors'] = $errors;
        if (empty($errors)) {
            $user = new User(
                $_POST['firstname'],
                $_POST['lastname'],
                $_POST['email'],
                $_POST['password']
            );
            $createdUser = $user->register();
            print_r($createdUser);
            //if ($createdUser) {
            //    header('Location: ./index.php');
            //}
            //else {
            //    $_SESSION['errors'] = ['Erreur lors de l\'inscription'];
            //}
        }
    }
?>  

<h1>S'inscrire</h1>

<?php
    include 'nav.php';
?>

<?php
    if (isset($_SESSION['errors'])) {
        echo '<div style="background-color: red">
            <ul>';
                foreach ($_SESSION['errors'] as $error) {
                    echo '<li>' . $error . '</li>';
                }
            echo '</ul>
        </div>';
    }
?>
<form method="POST" action="./register.php">
    <input type="text" name="firstname" placeholder="Votre prénom"><br>
    <input type="text" name="lastname" placeholder="Votre nom"><br>
    <input type="email" name="email" placeholder="Votre email"><br>
    <input type="password" name="password" placeholder="Votre mot de passe"><br>
    <input type="password" name="passwordConfirm" placeholder="Confirmation"><br>
    <input type="submit" value="S'inscrire">
</form>