<?php


function getBulan($int){
    switch ($int) {
        case "01":
           return "Januari";
        break;
        case "02":
            return "Februari";
         break;
         case "03":
            return "Maret";
         break;
         case "04":
            return "April";
         break;
         case "05":
            return "Mei";
         break;
         case "06":
            return "Juni";
         break;
         case "07":
            return "Juli";
         break;
         case "08":
            return "Agustus";
         break;
         case "09":
            return "September";
         break;
         case "10":
            return "Oktober";
         break;
         case "11":
            return "November";
         break;
         case "12":
            return "Desember";
         break;
         default:
         return "Error";
         
    }
}

function getDateString($date){
    return $date->format("d")." ".getBulan($date->format("m"))." ".$date->format("Y");
}

function round_ups ( $value, $precision ) { 

    $pow = pow ( 10, $precision ); 

    return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow; 

} 

// function getSize($size){
//     return $size;
// }
function getSize($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
    // $bytes /= pow(1024, $pow);
    $bytes /= (1 << (10 * $pow)); 

    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 
//    function getSize($size){

//     $besak = ceil($size/1000);

   

    

//     if ($besak >1000) {

//         $besak = $besak / 1000;

//         if ($besak >1000) {

//             $besak = $besak/1000;

//             $sizes = round_ups($besak,2)." GB";

//             return $sizes;

//         }else{

//             if ($besak>100) {

//                 $sizes = round_ups($besak,0)." MB";

//                 return $sizes;

//             }else{

//                 $sizes = round_ups($besak,2)." MB";

//                 return $sizes;

//             }

//         }

//     }else{

//         $sizes = round_ups($besak,2)." KB";

//         return $sizes;

//     }

// }

// var_dump($logs);
// foreach ($logs as $log) {
//     echo $log->date.'<br>';
// }
?>
<head>
<script src="<?=base_url()?>assets/fontawesome.js" crossorigin="anonymous"></script>

</head>
<div class="cover-container d-flex h-100 mx-auto flex-column">

    <header id="logs" class="">

        <div class="inner">

            <h3 class="masthead-brand"><a href="/">Daiakuma Drive</a></h3>

            <nav class="nav nav-masthead justify-content-center">

                <a class="nav-link" href="<?= base_url();?>">Home</a>

                <a class="nav-link" href="<?= base_url('features')?>">Features</a>

                <?php if(isset($username)) : ?>

                <a class="nav-link" href="<?= base_url('filemanager')?>">File Manager</a>

                <a class="nav-link active" href="#">Admin</a>


                <b class="username nav-link"><?php echo $username;?></b>

                <div class="nav-link dropdown">

                    <a class="imageDropdown dropdown-toggle" href="#" id="imageDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <img class="userimage rounded-circle" src="<?php echo $picture;?>">

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="imageDropdown">

                            <a class="imageDropdownItem text-dark" href="?logout">Logout</a>

                        </div>

                    </a>

                </div>
              
                <?php else : ?>

                <a href="<?= base_url();?>" class="nav-link">Login</a>


                <?php endif ?>

            </nav>

        </div>

    </header>


    <div class="gridContainer">
                <div class="item active">
                Admin Page
                </div>
                <a href='/listfile' class="item">
                List File
                </a>
                <a href="/logs" class="item">
                Download Logs
                </a>
                <a href="/loginlogs" class="item">
                Login Logs</a>
                </div>
    <div class="adminpage">
    <p class="lead">

<form method="post" action="<?= base_url()."admin";?>">
<br>
<h3 class="cover-heading">Create Link</h3>
    <p class="lead admin">

        <input value="<?= set_value('url');?>" autocomplete="off" type="text" name="url" id="url"
            class="form-control"
            placeholder="https://drive.google.com/file/d/1goSrBfezdD0uyzK-qyh0zplQLBG3FSOk/view">

    </p>

    <p class="lead">

        <button id="btn-upload" type="submit" class="btn btn-primary"><span class="uploadText">Upload</span>
            <div class="spinner"></div>
        </button>

    </p>


    <?php
    if($this->session->flashdata("link")): ?>
        <div class="linkDaiakuma">
            <div class="item1"><?=$this->session->flashdata("filename");?></div>
            <div class="item2 linkforcopy"><?=$this->session->flashdata("link");?></div>
            <div class="item3"><i class="copylink far fa-copy"></i></div>
        </div>
    <?php endif;
        
    ?>
  

    <!-- <div class='filelink'><span class='filename'>".$namaFidawdaefaefekafkokfaekfoakoakwfokawflkalfmklaekflaekfglaekgleakgleakgleakgleakvelakgleakglaekgleakglaekglaekglaegkleakgleakles."</span><a class='urlfiles' href='".$downloadUrl."'>Download</a></a></div> -->

</form>

</p>
<div class="toast">

<div class="toast-body">

    <?=form_error('url', '<div>', '</div>');?>
    <?php 
if($this->session->flashdata("error")){
    echo $this->session->flashdata("error");
}?>
</div>

</div>

<div class="toastnotif">
    <div class="toast-body"></div>
</div>

<script src="assets/jquery.min.js"></script>

<script>
    $(document).ready(function() {

        // $('#btn-upload').on('click', function(){

        //     $(this).attr("disabled", true);

        // })



        $('form').submit(function() {

            $('.spinner').css('display', 'inline-block');

            $(this).find('button[type=submit]').prop('disabled', true);

        });
    });

    
    </script>
<?php if(form_error('url')) : ?>

<script>
$(document).ready(function() {

    $('.toast').toast({

        delay: 3000

    });

    $('.toast').toast('show');

});
</script>

<?php endif;?>


<?php if($error) : ?>
<script>
$(document).ready(function() {

    $('.toast').toast({

        delay: 3000

    });

    $('.toast').toast('show');

});
</script>

<?php endif;?>

<script>
    function copyToClipboard(text) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(text).select();
        document.execCommand("copy");
        $temp.remove();
    }

    <?php if($this->session->flashdata("link")): ?>
        copyToClipboard($('.linkforcopy').html());
    <?php endif;?>

    $(".copylink").on("click",(e=>{
        $('.toastnotif').toast({
            delay: 3000
        });
        $('.toastnotif .toast-body').html("Link di copy!");
        $('.toastnotif').toast('show');
        
        copyToClipboard($('.linkforcopy').html());
        
    }));
</script>

</div>



    <!-- <footer class="mastfoot mt-auto">

    <div class="inner">

      <p>Daiakuma Drive powered by <a href="#">Segiempat PTK</a></p>

    </div>

  </footer>

</div> -->