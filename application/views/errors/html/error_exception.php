<!-- <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>

</html> -->

<html class="bg-dark">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daiakuma Drive</title>
    <link rel="stylesheet" href="https://drive.daiakuma.me//vendor/bootstrap/css/bootstrap.min.css">
    <link href='https://drive.daiakuma.me/assets/style.css' rel='stylesheet' type='text/css' />
    <meta name="title" content="Daiakuma Drive">
    <meta name="description" content="Mengatasi limit Google Drive dengan mudah.">
    <meta name="keywords" content="Daiakuma Drive">
    <meta name="robots" content="noindex, nofollow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body class="text-center bg-dark">



    <div class="cover-container d-flex h-100 mx-auto flex-column">
        <header class="masthead mb-auto">
            <div class="inner">
            <h3 class="masthead-brand"><a href="/">Daiakuma Drive</a></h3>
                <nav class="nav nav-masthead justify-content-center">
                    <a class="nav-link" href="https://drive.daiakuma.me">Home</a>
                </nav>
            </div>
        </header>

        <main role="main" class="inner cover">
            <a href="https://drive.daiakuma.me">
                <img src="https://drive.daiakuma.me/assets/img/suzuhirose.png" alt="">
            </a>
            <br><br>
            <h3 class="cover-heading">Sorry, an unexpected error occurred</h3>
            <h6 class="errorTombol" style="cursor: pointer;">Click for the Error Information.</h6>
            <div class="error" style="display:none;border:1px solid #ffffff;padding-left:20px;margin:0 0 10px 0;">

                <h4>An uncaught Exception was encountered</h4>

                <p>Type: <?php echo get_class($exception); ?></p>
                <p>Message: <?php echo $message; ?></p>
                <p>Filename: <?php echo $exception->getFile(); ?></p>
                <p>Line Number: <?php echo $exception->getLine(); ?></p>

                <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

                <p>Backtrace:</p>
                <?php foreach ($exception->getTrace() as $error): ?>

                <?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

                <p style="margin-left:10px">
                    File: <?php echo $error['file']; ?><br />
                    Line: <?php echo $error['line']; ?><br />
                    Function: <?php echo $error['function']; ?>
                </p>
                <?php endif ?>

                <?php endforeach ?>

                <?php endif ?>

            </div>
            <p class="lead">
                <!-- <div class='filelink'><span class='filename'>".$namaFidawdaefaefekafkokfaekfoakoakwfokawflkalfmklaekflaekfglaekgleakgleakgleakgleakvelakgleakglaekgleakglaekglaekglaegkleakgleakles."</span><a class='urlfiles' href='".$downloadUrl."'>Download</a></a></div> -->
            </p>
        </main>


        <footer class="mastfoot mt-auto">
            <div class="inner">
                <p>Daiakuma Drive powered by <a href="#">Segiempat PTK</a></p>
            </div>
        </footer>
    </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    opened = false;
    $(".errorTombol").on("click", function() {
        if (!opened) {
            opened = true;
            $(this).text("Click to hide.")
            $(".error").css("display", "block");
            $('html, body').animate({
                scrollTop: $(".error").offset().top
            }, 200);
        } else {
            opened = false;
            $(this).text("Click for the Error Information.");
            $(".error").css("display", "none");

        }
    })
});
</script>

</html>