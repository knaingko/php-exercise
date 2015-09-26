<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="btn navbar-btn  navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Tutorial</a>
        </div>

        <!-- Start Collapse Navigator -->
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li  ><a href="index.php">Home</a></li>
                <li  ><a href="about-us.php">About Us</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> Back Office <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Country</a></li>
                    </ul>
                </li>
                <li><a href="contact-us.php">Contact</a></li>
            </ul>
        </div>
        <!-- End Collapse Navigator -->
    </div> <!-- End Container -->
</nav>
<?php /*if (stripos($_SERVER['REQUEST_URI'],'index.php') !== false) {echo 'class="active"';} */?>