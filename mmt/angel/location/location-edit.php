<!DOCTYPE html>
<?php
    require_once '.././libs/csv-crud.php';
    require_once '.././libs/header.php';
    require_once '.././libs/breadcrumb.php';
    $Id = $Name = $Action = ''; $data = array();


    if(!empty($_GET))
    {
        $Id = $_GET['id'];
        $data = GetDataByKey('.././data/location.csv','LocationID',$Id);
        $Name = $data['LocationName'];
    }
    if(!empty($_POST))
    {
        $Id =  $_POST['location_id'];
        $Name = $_POST['location_name'];
        $data = array('LocationID'=>$Id, 'LocationName'=>$Name);

        if(UpdateDataByKey('.././data/Location.csv','LocationID',$Id,$data)){
            redirect('Location-list.php');
        }
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
          <li><a href="../gallery.php">Gallery</a></li>
          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" > Country <span class="caret"></span></a>
              <ul class="dropdown-menu">
                  <li><a href="country-list.php">Country List</a></li>
                  <li><a href="country-entry.php">Country Entry</a></li>
                  <li><a href="country-edit.php">Country Edit</a></li>
              </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" > Country <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="../country/country-list.php">Country List</a></li>
              <li><a href="../country/country-entry.php">Country Entry</a></li>
              <li><a href="../country/country-edit.php">Country Edit</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" > City <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="../city/city-list.php">City List</a></li>
              <li><a href="../city/city-entry.php">City Entry</a></li>
              <li><a href="../city/city-edit.php">City Edit</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>
<section id="breadcrumb" class="container">
    <?php
    echo(display_breadcrumb(
        array(
            array("label"=>"Back Office","url"=>"#","active"=>"false"),
            array("label"=>"Location Information","url"=>"location-list.php","active"=>"false"),
            array("label"=>"Location Edit","url"=>"location-edit.php","active"=>"true")
        )
    ));
    ?>
</section>


<div class="container">
  <div class="row">
    <div class="col-xs-offset-2 col-sm-8 col-md-8 form_table  animated zoomIn">
      <h2>Location Edit Form</h2>
        <form role="form" id="LocationForm" name="LocationForm">
          <table class="table table-borderless">
            <tr>
              <td>Location ID:</td>
              <td><input type="text" class="form-control input-sm" name="location_id" id="location_id" value="<?php echo($Id);?>" placeholder="Enter location id" required /></td>
            </tr>
            <tr>
              <td>Location Name:</td>
              <td><input type="text" class="form-control input-sm" name="location_name" id="location_name" value="<?php echo($Name);?>" placeholder="Enter location name" required /></td>
            </tr>                    
            <tr>
              <td>Month:</td>
              <td>
                <select name="month" class="form-control form-select" id="sel1">
                  <?php

                    $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

                    foreach ($months as $value) {
                        echo "<option value=\"" . $value . "\">" . $value . "</option>";
                    }

                  ?>
                </select> 
              </td>
            </tr> 
            <tr>
              <td>Country:</td>
              <td>
                <select name="country" class="form-control form-select" id="sel1">
                  <?php

                    echo "<option></option>";

                  ?>
                </select> 
              </td>
            </tr> 
            <tr>
              <td>City:</td>
              <td>
                <select name="city" class="form-control form-select" id="sel1">
                  <?php

                    echo "<option></option>";                  

                  ?>
                </select> 
              </td>
            </tr> 
            <tr>
              <td></td>
              <td><button type="button" class="save" onclick="SaveData();">Save</button>
                  <button type="button" class="save" onclick="window.open('location-list.php','_self');">Cancel</button>
              </td>
            </tr>                
          </table>
        </form>
      </div>
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
        with(document.LocationForm)
        {
            action = 'location-edit.php';
            method = 'post';
            submit();
        }
    }
    //-->
</script>

</body>
</html>