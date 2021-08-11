<a class="menu-toggle rounded" href="#">
    <i class="fa fa-bars"></i>
</a>

<nav class="navbar navbar-light navbar-expand" id="sidebar-wrapper" style="background: rgb(29, 128, 159);">
    <div class="container">
        <button data-bs-toggle="collapse" class="navbar-toggler d-none" data-bs-target="#"></button>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav sidebar-nav" id="sidebar-nav">
                <li class="nav-item sidebar-brand">
                    <a class="nav-link active js-scroll-trigger" href="index.php">online note board</a>
                </li>
                <li class="nav-item sidebar-nav-item">
                    <a class="nav-link js-scroll-trigger" href="index.php">Home</a>
                </li>
                <li class="nav-item sidebar-nav-item">
                    <a class="nav-link js-scroll-trigger" href="account.php">Account</a>
                </li>
                <?php
                if(!$_SESSION['student']){
                    echo '<li class="nav-item sidebar-nav-item"><a class="nav-link js-scroll-trigger" href="upload.php">New Announcement</a></li>';
                }
                if(isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == true){
                    echo '<li class="nav-item sidebar-nav-item"><a class="nav-link js-scroll-trigger" href="logout.php">Logout</a></li>';
                }else{
                    echo'<li class="nav-item sidebar-nav-item"><a class="nav-link js-scroll-trigger" href="login.php">Login</a></li>';
                }
                
                ?>
               
            </ul>
        </div>
    </div>
</nav>