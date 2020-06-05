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
                <a href='/listfile' class="item">
                List File
                </a>
                <div class="item active">
                Download Logs
                </div>
                <a href='/loginlogs' class="item">
                Login Logs</a>
    </div>
    <div class="showadmin">Show Admin <input type="checkbox" name="showadmin" value="show"<?php if(isset($_REQUEST['showadmin'])) : echo "checked"; endif;?>></div>
    <div class="tablelogs">
        <table id="logs" class="logs">
            <tr>
                <th>No</th>
                <th>Picture</th>
                <th>Name</th>
                <th>File</th>
                <th>Size</th>
                <th>Action</th>
                <!-- <th>Date</th> -->
            </tr>


            <?php 
            $index = 0;
            foreach ($logs as $log) { $index = $index+1;?>
            <tr index=<?=$index;?> class="data datalogs">
            <!-- <div class="data hiddendata">wew</div> -->
                <td><?=$index?></td>
                <td><img class="imgLogs" src="<?=$log->picture?>"></td>
                <td><?=$log->name?></td>
                <td><?=$log->file?></td>
                <td><?=getSize($log->size)?></td>
                <td><a href="<?=$log->link?>">Open</a></td>
                <!-- <th>
                    <?php 
                //  $tz = new DateTimeZone('Asia/Jakarta');
                //  $date = new DateTime($log->date);
                //  $date->setTimezone($tz);
                //  echo $date->format('Y-m-d H:i:s');
                 ?>
                </th> -->
            </tr>
           
            <?php
                    // $tz = new DateTimeZone('Asia/Jakarta');
                    // $date = new DateTime($log->date);
                    // $date->setTimezone($tz);

                    $datetime = new DateTime($log->date);
                    $jakartaTime = new DateTimeZone('Asia/Jakarta');
                    $datetime->setTimezone($jakartaTime);
                    setlocale(LC_TIME, 'id_ID');

                    ?>
            <tr class="hiddendata" index-hidden=<?=$index;?>>
                <td colspan="6">
                    <div class="divtd">
                    
                        <span><?=$log->email;?></span><br>
                        <span><?=strftime("%A %d %B %Y %H:%M:%S",strtotime($datetime->format("Y-m-d H:m:s")));?></span>
                    </div>
                </td>
            </tr>
            <!-- <tr class="hiddentr">
                <td></td>
                <td></td>
                <td><?=$log->email?></td>
                <td>
                    <?php
                    // $tz = new DateTimeZone('Asia/Jakarta');
                    // $date = new DateTime($log->date);
                    // $date->setTimezone($tz);
                    // echo $date->format('Y');
                    ?>
                </td>
                <td></td>
            </tr> -->
            <!-- <tbody>
                <td class="fulltd">wew</td>
            </tbody> -->
            <?php }

            ?>


        </table>

        <script>
        window.onload = () => {
            // $('tr').on('click', function(e) {
            //     // console.log()
            //     var index = $(this).attr("index");
            //     if ($("[index-hidden=" + index + "]").hasClass("hiddentable")) {
            //         $("[index-hidden=" + index + "]").removeClass("hiddentable")

            //     } else {
            //         $("[index-hidden=" + index + "]").addClass("hiddentable")

            //     }
            //     // alert($("div[index=" + index + "]")[0].outerHTML)
            //     // $(this).append($("div[index=" + index + "]")[0].outerHTML);
            // });
            
            $(':checkbox').change(function() {
                // console.log()
                if(this.checked){
                    window.location.href = "/loginlogs?showadmin";
                }else{
                    window.location.href = "/loginlogs";
                }
            }); 
        }

      
        </script>
    </div>



    <!-- <footer class="mastfoot mt-auto">

    <div class="inner">

      <p>Daiakuma Drive powered by <a href="#">Segiempat PTK</a></p>

    </div>

  </footer>

</div> -->