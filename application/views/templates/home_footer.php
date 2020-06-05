
    <footer class="mastfoot mt-auto">
        <div class="inner">
        <div class="lang">
        <?php if ($this->config->item('language') == "indonesian") :?>
            <a>Indonesia</a>
            |
            <a href="?lang=en">English</a>
        <?php elseif ($this->config->item('language') == "english") :?>
            <a>English</a>
            |
            <a href="?lang=id">Indonesian</a>
        <?php endif?>
  
</div>
            <a href="<?= base_url('terms');?>"><?= lang('terms');?></a>&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?= base_url('privacy');?>"><?= lang('privacyPolicy');?></a>
          <p>Daiakuma Drive powered by <a href="#">Segiempat PTK</a></p>
        </div>
      </footer>
    </div>

    <script src="assets/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>

</body>
</html>