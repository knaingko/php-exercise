<!DOCTYPE html>

<?php
    require_once './libs/csv_to_array.php';
    require_once './libs/io.php';
    $ID =  ''; $Name= ''; $data = array();
    $Action = '';
    
    if(!empty($_POST))
    {
        $Action = $_POST['hidAction'];
        $ID =  $_POST['CountryID'];
        $Name = $_POST['CountryName'];
        if($Action == 'NewRecord'){
            $_savedata = array('CountryID'=>$ID, 'CountryName'=>$Name);
            FileWriter('./data/country.csv', $_savedata );
        }
    }
    //Show List
    $data = csv_to_array('./data/country.csv');
?>

<html lang="en">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>ANGEL</title>
   <link rel="stylesheet" href="css/bootstrap.min.css"  />
   <link rel="stylesheet" href="css/font-awesome.min.css" />
   <link rel="stylesheet" type="text/css" href="css/animate.min.css">
   <link rel="stylesheet" href="css/font.css" />
   <link rel="stylesheet" href="css/style.css" />
   <link rel="stylesheet" href="css/form.css" />
   <script src="js/jquery.min.js"></script>
   <script src="js/bootstrap.min.js"></script> 
   <script type="text/javascript" lang="javascript">

   function butSave_OnClick(){
      with(document.CountryForm){

         hidAction.value = 'NewRecord';
         action = 'country-info.php';
         method = 'post';
         submit();
      }
   }

   </script>
</head>
   <body>
      <div class="header">
         <div class="container"> <a class="navbar-brand" href="index.php"><i class="fa fa-camera-retro"></i>&nbsp;ANGEL</a>
            <div class="menu"> <a class="toggleMenu" href="#"><img src="images/nav_icon.png" alt="" /> </a>
               <ul class="nav" id="nav">
                  <li class="current"><a href="index.php">Home</a></li>
                  <li><a href="portfolio.php">PORTFOLIO</a></li>
                  <li><a href="gallery.php">GALLERY</a></li>                         
               </ul><div class="clear"></div>
              <script type="text/javascript" src="js/responsive-nav.js"></script> 
            </div>
         </div><hr />
      </div>
      <div class="container">
         <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 form_table  animated zoomIn">
            <h2>Country Information</h2>
               <form role="form" id="CountryForm" name="CountryForm">
                  <table class="table table-borderless">
                     <tr>
                        <td>Country ID:</td>
                        <td><input type="text" class="form-control input-sm" name="CountryID" id="" value="" placeholder="Enter country id" required /></td>
                     </tr>
                     <tr>
                        <td>Country Name:</td>
                        <td><input type="text" class="form-control input-sm" name="CountryName" id="" value="" placeholder="Enter country name" required /></td>
                     </tr>                    
                     <tr>
                        <td></td>
                        <td><button type="button" class="save" onclick="butSave_OnClick()">Save</button>
                           <button type="reset" class="save">Cancel</button> </td>
                     </tr>
                  </table>
                  <input name="hidAction" type="hidden" />
                  <input name="hidCode" type="hidden" />
               </form>
            </div>
         </div><hr />
      </div>
      <div class="container">
         <div class="row"> 
            <div class="col-xs-12 col-sm-8 col-md-8 form_table">  
               <input type="button" name="delete" id="" class="save delete" value="Delete" />          
               <table class="table table-bordered">
                  <tr class="">
                     <th></th>
                     <th>Country ID</th>
                     <th>Country Name</th>  
                     <th></th>                    
                  </tr>
                  <?php

                  foreach ($data as $value) {
                     
                     echo '<tr>';
                     echo '<td class="check" ><input type="checkbox" name="checkbox" /></td>';
                     echo '<td>' . $value['CountryID'] . '</td>';
                     echo '<td>' . $value['CountryName'] .'</td>';
                     echo '<td><button>Edit</button>&nbsp;<button>Delete</button></td>';
                     echo '</tr>';

                  }

                  ?>
               </table>
               <input type="button" name="delete" id="" class="save delete" value="Delete">
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
   </body>
</html>
