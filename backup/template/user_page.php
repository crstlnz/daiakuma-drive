<body>
    <div class="bg-dark vh-100 text-light">
    <?php if (isset($authUrl)){
        include_once "nav_logged_out.php";
    }else {
        include_once "nav_logged_in.php";
    }
    ?>
    <?php if (isset($authUrl)){
        include_once "nav_logged_out.php";
    }else { ?>
        <div class="content container font-weight-bold">
           <div class="text-center mb-3">Copy File to your Drive</div> 
        <form action="/index.php" method="post">
        <input name="url" autocomplete="off" type="text" class="urlInput form-control" id="url" placeholder="Enter url">
        </form>
        </div> <?php
    }
    ?>
    </div>
</body>
