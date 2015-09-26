<!DOCTYPE html>
<?php
    require_once './libs/csv-crud.php';
    require_once './libs/header.php';
    $Id = $Name = ''; $data = array();

    if(!empty($_POST))
    {
        $ID =  $_POST['country_id'];
        $Name = $_POST['country_name'];
        $_savedata = array('CountryID'=>$ID, 'CountryName'=>$Name);
        InsertData('./data/country.csv', $_savedata );
        redirect('CountryList.php');
    }
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>PHP Tutorial</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->
<body>
<?php require_once 'menu.php' ?>
<section id="title" class="emerald">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1>Country Entry</h1>
                <p>New Country Information here</p>
            </div>
            <div class="col-sm-6">
                <ul class="breadcrumb pull-right">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">Back Office</a></li>
                    <li class="active">Country Entry</li>
                </ul>
            </div>
        </div>
    </div>
</section><!--/#title-->

<section id="country-entry" class="container">
    <div  class="panel panel-default">
        <div class="panel-body">
            <form role="form" name="country-form" action="CountryEntry.php" method="post">
                <h4>Country Entry Form</h4>
                <fieldset class="entry-form">
                    <div class="form-group col-sm-3">
                        <input type="text" id="country_id" name="country_id" placeholder="Country ID" class="form-control">
                    </div>
                    <div class="form-group col-lg-5">
                        <input type="text" id="country_name" name="country_name" placeholder="Country Name" class="form-control">
                    </div>
                    <div class="form-group" align="left">
                        <button type="submit" class="btn btn-success btn-dm">&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;</button>
                        <button type="button" class="btn btn-success btn-dm" onclick="window.open('CountryList.php','_self');">&nbsp;Cancel&nbsp;</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</section><!--/#registration-->

<?php require_once 'footer-navigator.php' ?>
<?php require_once 'footer.php' ?>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.prettyPhoto.js"></script>
<script src="js/main.js"></script>
</body>
</html>



