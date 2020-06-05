<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand font-weight-bold" href="#">Daiakuma Drive</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link font-weight-bold" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link font-weight-bold" href="#">Uploader</a>
      </li>
    </ul>
    <div class="userprofile form-inline my-2 my-lg-0">
        
        <ul class="navbar-nav mr-auto">
        <li class="detaildiv mr-2">
         <div class="username text-right text-light text-truncate font-weight-bold"><?php echo $userInfo->name;?></div>
         <!-- <div class="mail text-right "><?php echo $userInfo->email;?></div> -->
        </li>
        <li class="nav-item dropdown">
        <a class="imageDropdown nav-link dropdown-toggle" href="#" id="imageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class="userimage rounded-circle" src="<?php echo $userInfo->picture;?>">
        </a>
      
        <div class="dropdown-menu dropdown-menu-right"  aria-labelledby="imageDropdown">
            <a class="imageDropdownItem text-dark" href="?logout">Logout</a>
        </div>
        </li>
        </ul>
        
    </div>
  </div>
</nav>