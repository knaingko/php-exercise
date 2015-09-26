<!DOCTYPE html>
<?php
require_once './libs/csv-crud.php';
$Id = $Name = $Action = ''; $data = array();

if(!empty($_POST)){
    $Id = $_POST['hidCode'];
    DeleteDataByKey('./data/country.csv','CountryID',$Id);
}

$data = GetAllData('./data/country.csv')
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
    <script lang="javascript" type="text/javascript">
    <!--
        function delete_data(IdCode)
        {
            with(document.CountryList)
            {
                hidCode.value = IdCode;
                action = 'CountryList.php';
                method="post";
                submit();
            }
        }
        function show_edit(id)
        {
            window.open('CountryEdit.php?id='+ id,'_self');
        }
        function show_entry()
        {
            window.open('CountryEntry.php','_self');
        }
    //-->
    </script>
</head><!--/head-->
<body>
    <?php require_once 'menu.php' ?>
    <section id="title" class="emerald">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Country List</h1>
                    <p>This page show all Country Information. You can add new country, edit and delete it.</p>
                </div>
                <div class="col-sm-6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="#">Back Office</a></li>
                        <li class="active">Country List</li>
                    </ul>
                </div>
            </div>
        </div>
    </section><!--/#title-->

    <section id="country-list" class="container">
        <form class="row" role="form" id="CountryList" name="CountryList">
            <table class="table">
                <thead>
                <tr>
                    <th class="col-lg-1"><label><input type="checkbox">&nbsp;&nbsp;All</label></th>
                    <th class="col-lg-1"><label>ID</label></th>
                    <th class="col-lg-9"><label>Name</label></th>
                    <th class="col-lg-1" colspan="2"></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $value) { ?>
                    <tr>
                        <td align="left"><input type="checkbox" /></td>
                        <td align="left"><?php echo($value['CountryID']); ?></td>
                        <td align="left"><?php echo($value['CountryName']); ?></td>
                        <td align="right">
                            <button type="button" class="btn btn-info" onclick="show_edit('<?php echo( $value["CountryID"] ) ?>')">&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>
                        </td>
                        <td align="right">
                            <button type="button" class="btn btn-info" onclick="delete_data('<?php echo( $value["CountryID"] ) ?>')">&nbsp;Delete&nbsp;</button>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="4" align="right"><button type="button" class="btn btn-primary" onclick="show_entry();">&nbsp;&nbsp;New&nbsp;&nbsp;</button></td>
                        <td align="right"><button type="button" class="btn btn-primary">&nbsp;Delete&nbsp;</button></td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" id="hidCode" name="hidCode">
        </form>
    </section>
    <?php require_once 'footer-navigator.php' ?>
    <?php require_once 'footer.php' ?>

<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.prettyPhoto.js"></script>
<script src="js/main.js"></script>
</body>
</html>



