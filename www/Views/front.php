<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title??"Titre de page" ?></title>
    <meta name="description" content="<?= $description??"ceci est la description de ma page" ?>">
</head>
<body>
    <h1><?= $title??"Titre de page" ?></h1>
    <?php 
        include '../Views/Layout/nav.php';
        include "../Views/".$this->v; 
        include '../Views/Common/errors.php'
    ?>
</body>
</html>