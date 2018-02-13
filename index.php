<?php
$sitename = 'Bickers en Backers';
$family = $_GET['fam'] ?? 'bickers';
$allowed = ['bickers', 'backers'];
if (! in_array($family, $allowed)) {
    $family = 'backers';
}
$jsonFile = $family . '.json';
?>
<!doctype html>
<html lang="en">
<head>
    <title><?= $sitename ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"
          integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">

    <link href="alchemy/styles/vendor.css" rel="stylesheet" type="text/css">
    <link href="alchemy/alchemy.css" rel="stylesheet" type="text/css">

    <style>
        html,
        body {
            height: 100%;
            min-height: 600px;
            color: #333;
        }
    </style>

</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
    <a class="navbar-brand" href="#"><?= $sitename ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?= ($family === 'bickers') ? 'active' : '' ?>">
                <a class="nav-link" href="index.php?fam=bickers">Bickers</a>
            </li>
            <li class="nav-item <?= ($family === 'backers') ? 'active' : '' ?>">
                <a class="nav-link" href="index.php?fam=backers">Backers</a>
            </li>
        </ul>

    </div>
</nav>

<main role="main">

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="alchemy" id="alchemy"></div>
            </div>

            <div class="col-md-6">
                <div class="ml-2">
                    <h3 id="person" class="mt-0"><?= ucfirst($family) ?></h3>
                    <div id="message" style="margin-top: 10px;"></div>

                    <div id="personPics" class="d-flex flex-wrap mt-2">
                    </div>
                </div>
            </div>
        </div>

    </div>

</main>

<footer class="container-fluid">
    <p>&copy; Hic Sunt Leones 2018</p>
</footer>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>


<!-- We need Alchemy for displaying -->
<script src="alchemy/scripts/vendor.js"></script>
<script src="alchemy/alchemy.js"></script>

<script>
    //$(document).ready(function () {
    var jsonFile = '<?=$jsonFile?>';
    var loading = false;
    // });
</script>
<script src="js/app.js"></script>


</body>
</html>
