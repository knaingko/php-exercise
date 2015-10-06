<!DOCTYPE html>
    <?php
    require_once './libs/csv-crud.php';
    require_once './libs/breadcrumb.php';
    require_once 'header.php';
    $Id = $Name = $Action = ''; $data = array();

    if(!empty($_POST)){
        if($_POST['hidDelete'] == 'single'){
            $Id = $_POST['hidCode'];
            DeleteDataByKey('./data/country.csv','CountryID',$Id);
        }
        if($_POST['hidDelete'] == 'multi') {
            $data = $_POST['delCheck'];
            foreach($data as $value)
            {
                DeleteDataByKey('./data/country.csv','CountryID',$value);
            }
        }
    }

    $data = GetAllData('./data/country.csv')
    ?>
<html lang="en">
<head>
	<title>Country Information</title>
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
</head>
<body>
<hr />
<section id="breadcrumb" class="container">
    <?php
    echo (display_breadcrumb(
        array(
            array("label"=>"Back Office","url"=>"#","active"=>"false"),
            array("label"=>"Country Information","url"=>"country-list.php","active"=>"true")
        ))
    );
    ?>
</section>

<div class="container">
    <div class="row"> 
    <h2>Country Information</h2>
        <div class="col-xs-12 col-sm-8 col-md-8 form_table">  
        <button type="button" class="save delete" onclick="delete_all();">Delete</button>        
            <table class="table table-bordered">
                <tr class="">
                 <th></th>
                 <th>Country ID</th>
                 <th>Country Name</th>  
                 <th></th>                    
                </tr>
                <?php $i = 1; foreach ($data as $value) { ?>
                 
                 <tr>
                    <td class="check" ><input type="checkbox" id="delCheck[]" name="delCheck[]" value="<?php echo $value["CountryID"] ?>"/>&nbsp;<?php echo($i);?></td>
                    <td><?php echo($value['CountryID']); ?></td>
                    <td><?php echo($value['CountryName']); ?></td>
                    <td><button type="button" class="btn table-btn" onclick="show_edit('<?php echo( $value["CountryID"] ) ?>')">Edit</button>&nbsp;
                    <button type="button" class="btn table-btn" onclick="delete_data('<?php echo( $value["CountryID"] ) ?>')">Delete</button>
                    </td>
                 </tr>
                 <?php $i += 1; } ?>
            </table>
            <input id="SelectAll" type="checkbox" />&nbsp;All</label>
            <button type="button" class="save delete" onclick="show_entry();">New</button>
            <button type="button" class="save delete" onclick="delete_all();">Delete</button>
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

<script lang="javascript" type="text/javascript">
        <!--
        function delete_all()
        {
            with(document.CountryList)
            {
                hidCode.value = '';
                hidDelete.value = 'multi';
                action = 'country-list.php';
                method="post";
                submit();
            }
        }

        function delete_data(IdCode)
        {
            with(document.CountryList)
            {
                hidCode.value = IdCode;
                hidDelete.value = 'single';
                action = 'country-list.php';
                method="post";
                submit();
            }
        }

        function show_edit(id)
        {
            window.open('country-edit.php?id='+ id,'_self');
        }

        function show_entry()
        {
            window.open('country-entry.php','_self');
        }

        //Select All Checkbox
        $('#SelectAll').click(function(event) {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });
    //-->
    </script>

</body>
</html>