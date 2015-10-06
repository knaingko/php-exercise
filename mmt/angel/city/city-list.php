<!DOCTYPE html>

<?php
require_once '.././libs/csv-crud.php';
require_once '.././libs/breadcrumb.php';
$Id = $Name = $Action = ''; $data = array();

if(!empty($_POST)){
    if($_POST['hidDelete'] == 'single'){
        $Id = $_POST['hidCode'];
        DeleteDataByKey('.././data/city.csv','CityID',$Id);
    }
    if($_POST['hidDelete'] == 'multi') {
        $data = $_POST['delCheck'];
        foreach($data as $value)
        {
            DeleteDataByKey('.././data/city.csv','CityID',$value);
        }
    }
}

$data = GetAllData('.././data/city.csv')
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
              <li><a href="../country/country-list.php">Country List</a></li>
              <li><a href="../country/country-entry.php">Country Entry</a></li>
              <li><a href="../country/country-edit.php">Country Edit</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" > City <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="city-list.php">City List</a></li>
              <li><a href="city-entry.php">City Entry</a></li>
              <li><a href="city-edit.php">City Edit</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" > Location <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="../location/location-list.php">Location List</a></li>
              <li><a href="../location/location-entry.php">Location Entry</a></li>
              <li><a href="../location/location-edit.php">Location Edit</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</div>

<section id="breadcrumb" class="container">

  <?php
  echo (display_breadcrumb(
      array(
          array("label"=>"Entry Data","url"=>"#","active"=>"false"),
          array("label"=>"Country Information","url"=>"city-list.php","active"=>"true")
      ))
  );
  ?>
</section>

<div class="container">
   <div class="row"> 
        <div class="col-xs-offset-1 col-sm-10 col-md-10 form_table"> 
            <h2 class="info-h2">City Information</h2>
            <div id="myDIV">
            <form id="CityList" name="CityList" class="new-form">
                <table class="table table-bordered">
                    <tr class="">
                       <th>#</th>
                       <th>City ID</th>
                       <th>City Name</th>  
                       <th>Action</th>                    
                    </tr>
                    <?php $i = 1; foreach ($data as $value) { ?>
                       
                      <tr>
                        <td class="check" ><label><input type="checkbox" id="delCheck[]" name="delCheck[]" value="<?php echo $value["CityID"] ?>"/>&nbsp;<?php echo($i);?></label></td>
                        <td><?php echo($value['CityID']); ?></td>
                        <td><?php echo($value['CityName']); ?></td>
                        <td class="check"><button type="button" class="btn edit" onclick="show_edit('<?php echo( $value["CityID"] ) ?>')">Edit</button></td>
                      </tr>

                    <?php $i += 1; } ?>

                </table>
                <div class="delete">
                    <label class="btn save"><input id="SelectAll" type="checkbox" />&nbsp;All</label>
                    <button type="button" class="btn save" onclick="show_entry();">New</button>
                    <button type="button" class="btn save" onclick="delete_all();">Delete</button>
                </div>
                <input type="hidden" id="hidDelete" name="hidDelete">
                <input type="hidden" id="hidCode" name="hidCode">
            </form></div>
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
<script lang="javascript" type="text/javascript">
        <!--
        function delete_all()
        {
            with(document.CityList)
            {
                hidCode.value = '';
                hidDelete.value = 'multi';
                action = 'city-list.php';
                method="post";
                submit();
            }
        }

        function delete_data(IdCode)
        {
            with(document.CityList)
            {
                hidCode.value = IdCode;
                hidDelete.value = 'single';
                action = 'city-list.php';
                method="post";
                submit();
            }
        }

        function show_edit(id)
        {
            window.open('city-edit.php?id='+ id,'_self');
        }

        function show_entry()
        {
            window.open('city-entry.php','_self');
        }

        //Select All Checkbox
        $('#SelectAll').click(function(event) {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });
    //-->
</script>
<!-- Placed at the end of the document so the pages load faster -->

</body>
</html>