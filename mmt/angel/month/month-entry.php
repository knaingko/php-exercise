<!DOCTYPE html>
<?php
    require_once '.././libs/csv-crud.php';
    require_once '.././libs/breadcrumb.php';
    require_once '.././libs/header.php';
    $Id = $Name = ''; $data = array();

    if(!empty($_POST))
    {
        $ID =  $_POST['month_id'];
        $Name = $_POST['month_name'];
        $_savedata = array('MonthID'=>$ID, 'MonthName'=>$Name);
        InsertData('.././data/month.csv', $_savedata );
        redirect('month-list.php');
    }
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="mmt">

  <title>ANGEL</title>
  <link rel="stylesheet" href="../css/bootstrap.min.css"  />
  <link rel="stylesheet" href="../css/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="../css/animate.min.css">
  <link rel="stylesheet" href="../css/font.css" />
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="stylesheet" href="../css/form.css" />
  <link rel="stylesheet" href="../css/theme.css" />
</head>
<body>   
<div class="header">
  <nav class="navbar-inverse" role="navigation"style="background:#fff;" >
    <div class="container ">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu-collapes">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../index.php"><i class="fa fa-camera-retro"></i>&nbsp;ANGEL</a>
        </div>
        <div class="collapse navbar-collapse" id="menu-collapes">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../index.php">Home</a></li>
                <li><a href="../portfolio.php" >Portfolio</a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" > Back Office <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="month-list.php">Month List</a></li>
                        <li><a href="month-entry.php">Month Entry</a></li>
                        <li><a href="month-edit.php">Month Edit</a></li>
                    </ul>
                </li>
                <li><a href="../gallery.php">Gallery</a></li>
            </ul>
        </div>
    </div>
  </nav>
</div>

<section id="breadcrumb" class="container">
    <?php
    echo(display_breadcrumb(
        array(
            array("label"=>"Data Entry","url"=>"#","active"=>"false"),
            array("label"=>"Month Information","url"=>"month-list.php","active"=>"false"),
            array("label"=>"Month Entry","url"=>"month-entry.php","active"=>"true")
        )
    ));
    ?>
</section>

<div class="container">
  <div class="row para">  
    <div class="col-xs-offset-2 col-sm-8 col-md-8 animated zoomIn form_table">
    <h2 class="info-h2">Month Information:</h2>
      <form role="form" id="MonthForm" name="MonthForm">
        <table class="table table-borderless">
          <tr>
            <td>Month ID:</td>
            <td><input type="text" class="form-control input-sm" name="month_id" id="month_id" value="" placeholder="Enter month id" required /></td>
          </tr>
          <tr>
            <td>Month Name:</td>
            <td><input type="text" class="form-control input-sm" name="month_name" id="month_name" value="" placeholder="Enter month name" required /></td>
          </tr>                   
          <tr>
          <td></td>
            <td><button type="button" class="btn save" onclick="SaveData()">Save</button>&nbsp;
            <button type="button" class="btn save" onclick="window.open('month-list.php','_self');">Cancel</button>
            </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>

<div class="footer">
        <div class="footer_bottom">
          <div class="container">
            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-6 res">
                <h3 style="color:#fff;">CONTACT US</h3>
                <p style="color:#fff;line-height: 30px;"><span style="font-weight:normal;">ANGEL </span><br />
                <i class="fa fa-location-arrow"></i>&nbsp;N0.49,Hlaing Township,Thann Lann,Yangon<br />
                <i class="fa fa-phone"></i>&nbsp;+95 09791193583<br />
                <i class="fa fa-envelope-o"></i>&nbsp;angel@gmail.com
                </p>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 res">
                <div class="follow-us social"> 
                        <a class="fa fa-facebook social-icon" href="#"></a> <a class="fa fa-twitter social-icon" href="#"></a>
                        <a class="fa fa-linkedin social-icon" href="#"></a> <a class="fa fa-google-plus social-icon" href="#"></a>
                        <a class="fa fa-credit-card social-icon" href="#"></a>
                </div>
                <form class="form-inline">
                  <div class="form-group form res">
                    <label for="exampleInputEmail3" class="email">Email address:</label><br />
                    <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email" style="width:100%;"><br />
                    <input class="btn btn-default submit" type="submit" value="Sign Up">
                  </div>
                </form>
              </div>
            </div>               
          </div>
        </div>
        <div class="copyright">
          <div class="copy">
            <p>Copyright &copy; 2015 Company Name. Design by <a href="http://www.takumi-internet.com" rel="nofollow">TAKUMI Internet</a></p>
          </div>
        </div>
    </div>

<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script> 
<script src=".././js/theme.js"></script>
<script language="JavaScript" type="text/javascript">
    <!--
    function SaveData()
    {
        with(document.MonthForm)
        {
            action = 'month-entry.php';
            method = 'post';
            submit();
        }
    }
    //-->
</script>

</body>
</html>