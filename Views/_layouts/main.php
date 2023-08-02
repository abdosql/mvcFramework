<?php use app\core\View;

$session = \app\core\Application::$app->session?>
<!doctype html>
<html lang="en">
<?php
    $user = \app\core\Application::$app;
    /** @var $this View */
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php $this->getTitle(); ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <?php if ($user->isGuest()){?>
                        <li class="nav-item">
                            <a class="nav-link" href="/Login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/Register">Register</a>
                        </li>
                    <?php }else{?>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/Logout">Logout</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/Profile">Profile</a>
                        </li>
                    <?php }?>
                </ul>
                <div class="d-flex">
                    <?php if (!$user->isGuest()){?>
                        <?php try {
                            echo $user->User->_get("name");
                        } catch (Exception $e) {
                        } ?>
                    <?php }?>
                </div>
            </div>
        </div>
    </nav>
    <main class="container">
            <?=$session->getFlash("success") ?? ""; ?>
        {{view}}
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>