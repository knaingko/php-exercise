<!DOCTYPE html>
<?php
    require_once './libs/csv-crud.php';
    require_once './libs/breadcrumb.php';
    
    $Id = $Name = ''; $data = array();

    if(!empty($_POST))
    {
        $ID =  $_POST['country_id'];
        $Name = $_POST['country_name'];
        $_savedata = array('CountryID'=>$ID, 'CountryName'=>$Name);
        InsertData('./data/country.csv', $_savedata );
        redirect('country-list.php');
    }
?>
<html lang="en">
<head>
    <!-- The below 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Kyaw Naing">

    <!-- Theme Matter -->
    <title>Tutorial</title>

    <!-- Vendor Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <link href="css/theme.css" rel="stylesheet">
    <link href="css/footer.css" rel="stylesheet">
</head>
<?php require_once 'header.php'; ?><!--/head-->
<body>

<section id="breadcrumb" class="container">
    <?php
    echo(display_breadcrumb(
        array(
            array("label"=>"Back Office","url"=>"#","active"=>"false"),
            array("label"=>"Country Information","url"=>"country-list.php","active"=>"false"),
            array("label"=>"Country Entry","url"=>"country-entry.php","active"=>"true")
        )
    ));
    ?>
</section>


<section id="country-entry" class="container" style="height:793px;">
    <div  class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Country Entry Form</h3>
        </div>
        <div class="panel-body" align="center">
            <form id="CountryForm" name="CountryForm" role="form" class="form-horizontal">
                <div class="form-group">
                    <div class="input-group col-sm-3 form-inline">
                        <label for="country_id" class="input-group-addon">ID</label>
                        <input type="text" id="country_id" name="country_id" placeholder="Country ID" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group col-sm-3">
                        <label for="country_name" class="input-group-addon">Name</label>
                        <input type="text" id="country_name" name="country_name" placeholder="Country Name" class="form-control">
                    </div>
                </div>
                <br/>
            </form>
        </div>
        <div class="panel-footer" align="center">
            <button type="button" class="btn btn-primary action-btn" onclick="SaveData();">Save</button>&nbsp;
            <button type="button" class="btn btn-primary action-btn" onclick="window.open('country-list.php','_self');">Cancel</button>
        </div>
    </div>
</section><!--/#registration-->

<?php require_once 'footer.php' ?>
<!-- Bootstrap core JavaScript ================================================== -->
<script src="./js/jquery-1.11.3.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<script src="./js/theme.js"></script>
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="vendor/html5shiv/html5shiv.min.js"></script>
<script src="vendor/respond/respond.min.js"></script>
<![endif]-->

<script language="JavaScript" type="text/javascript">
    <!--
    function SaveData()
    {
        with(document.CountryForm)
        {
            action = 'country-entry.php';
            method = 'post';
            submit();
        }
    }
    //-->
</script>

<!-- Placed at the end of the document so the pages load faster -->

</body>
</html>



