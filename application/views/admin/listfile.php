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
<script src="<?=base_url()?>/assets/fontawesome.js" crossorigin="anonymous"></script>
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
                <!-- <a href="<?= $authUrl;?>" class="nav-link">Login</a> -->

                <?php endif ?>

            </nav>

        </div>

    </header>


    <div class="gridContainer">
                <a href='/admin' class="item">
                Admin Page
                </a>
                <div class="item active">
                List File
                </div>
                <a href="/logs" class="item">
                Download Logs
                </a>
                <a href='/loginlogs' class="item">
                Login Logs</a>
    </div>
    <div class="tablelogs">
        <table id="logs" class="logs">
            <tr class="tabellistfile">
                <th>No</th>
                <th>Id</th>
                <th>Name</th>
                <th>Original Link</th>
                <th>Last Checked</th>
                <th>Date</th>
                <th>Action</th>
                <!-- <th>Date</th> -->
            </tr>


            <?php 
            $index = 0;
            foreach ($logs as $log) { $index = $index+1;?>
            <tr index=<?=$index;?> class="tabellistfile">
                <td><?=$index?></td>
                <td><?=$log->linkId?></td>
                <td><?=$log->fileName?></td>
                <td><a href="https://drive.google.com/file/d/<?=$log->fileId?>/view" target="_blank">Open</a></td>
                <td><div class="<?php 
                if(isset($log->isLive)){
                    if($log->isLive==0){
                        echo "offline";
                    }else{
                        echo "online";
                    }
                 }
                ?> liveCheck tooltips">
                <?php  
                if(isset($log->isLive)){
                    if($log->isLive==0){
                        echo "Offline";
                    }else{
                        echo "Online";
                    }
                }else{
                    echo "None";
                }?>
                    <?php
                    if(isset($log->lastChecked)){
                        // date_default_timezone_set("Asia/Jakarta");
                        
                        $datetime = new DateTime($log->lastChecked);
                        $jakartaTime = new DateTimeZone('Asia/Jakarta');
                        $datetime->setTimezone($jakartaTime);
                        setlocale(LC_TIME, 'id_ID');
                        echo '<span class="tooltiptext">'.strftime("%A %d %B %Y %H:%M:%S",strtotime($datetime->format("Y-m-d H:m:s"))).'</span>';
                    }
                    ?>
                    </div>
                </td>
                <?php 
      
                 $tz = new DateTimeZone('Asia/Jakarta');
                    $date = new DateTime($log->date);
                    $date->setTimezone($tz);
                 ?>
                <td><?=getDateString($date);?></a></td>
                <td><a class="space" href="<?=base_url().$log->linkId?>" target="_blank"><i class="fas fa-link"></i></a> <i linkid="<?=base_url().$log->linkId?>" class="ipointer copydong fas fa-copy"></i><i delete="<?=$log->linkId?>" class="deletelistfile ipointer fas fa-trash-alt"></i></td>
                <!-- <th>
                 
                </th> -->
            </tr>
            <?php
                    
                    ?>
            <tr class="hiddentable" index-hidden=<?=$index;?>>
                <td colspan="5">
                    <div class="divtd">
                        <span><?=$log->email;?></span><br>
                        <span><?=getDateString($date);?></span>
                    </div>
                </td>
            </tr>
         
            <?php }

            ?>


        </table>

        <div class="toast">
            <div class="toast-body"></div>
        </div>

        <script src="assets/jquery.min.js"></script>

        <script>
            function copyToClipboard(text) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(text).select();
                document.execCommand("copy");
                $temp.remove();
            }
            // $('.toast').toast({
            //     delay: 3000
            // });

            $('.copydong').on("click",e=>{
                // console.log($(e.currentTarget).attr("linkid"))
                // console.log(e);
                copyToClipboard($(e.currentTarget).attr("linkid"));
                $('.toast').toast({
                    delay: 3000
                });
                $('.toast .toast-body').html("Link di copy!");
                $('.toast').toast('show');
            })

            $(".deletelistfile").on("click",e=>{
                var deletegak = confirm("Benaran ke mo delete?");

                if(deletegak){
                    window.location = "/listfile?delete="+$(e.currentTarget).attr("delete");
                }
            });
        // window.onload = () => {
        //     $('tr').on('click', function(e) {
        //         // console.log()
        //         var index = $(this).attr("index");
        //         if ($("[index-hidden=" + index + "]").hasClass("hiddentable")) {
        //             $("[index-hidden=" + index + "]").removeClass("hiddentable")

        //         } else {
        //             $("[index-hidden=" + index + "]").addClass("hiddentable")

        //         }
        //         // alert($("div[index=" + index + "]")[0].outerHTML)
        //         // $(this).append($("div[index=" + index + "]")[0].outerHTML);
        //     });
        // }
        </script>
        <script>

        </script>
    </div>



    <!-- <footer class="mastfoot mt-auto">

    <div class="inner">

      <p>Daiakuma Drive powered by <a href="#">Segiempat PTK</a></p>

    </div>

  </footer>

</div> -->