<!DOCTYPE html>
<?php
require_once './libs/csv-crud.php';
require_once './libs/breadcrumb.php';
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
<html lang="en" xmlns="http://www.w3.org/1999/html">
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
    <link href="css/bootstrap-submenu.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">

    <link href="css/theme.css" rel="stylesheet">
    <link href="css/footer.css" rel="stylesheet">
</head><!--/head-->
<body>
    <?php require_once 'menu.php' ?>
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
        <form id="CountryList" name="CountryList">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Country Information</h3>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-sm-1" align="right">#</th>
                            <th class="col-sm-1"><label>ID</label></th>
                            <th class="col-sm-9"><label>Name</label></th>
                            <th class="col-sm-1" colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; foreach ($data as $value) { ?>
                        <tr>
                            <td align="left"><label><input type="checkbox" id="delCheck[]" name="delCheck[]" value="<?php echo $value["CountryID"] ?>"/>&nbsp;<?php echo($i);?></label></td>
                            <td align="left"><?php echo($value['CountryID']); ?></td>
                            <td align="left"><?php echo($value['CountryName']); ?></td>
                            <td align="right">
                                <button type="button" class="btn table-btn" onclick="show_edit('<?php echo( $value["CountryID"] ) ?>')">Edit</button>
                            </td>
                            <td align="right">
                                <button type="button" class="btn table-btn" onclick="delete_data('<?php echo( $value["CountryID"] ) ?>')">Delete</button>
                            </td>
                        </tr>
                    <?php $i += 1; } ?>
                    </tbody>
                </table>
                <div class="panel-footer">
                    <label class="btn btn-primary col-sm-1"><input id="SelectAll" type="checkbox" />&nbsp;All</label>
                    <button type="button" class="btn btn-primary col-sm-1" onclick="show_entry();">New</button>
                    <button type="button" class="btn btn-primary col-sm-1" onclick="delete_all();">Delete</button>
                </div>
            </div>
            <input type="hidden" id="hidDelete" name="hidDelete">
            <input type="hidden" id="hidCode" name="hidCode">
        </form>
    </div>


    <?php require_once 'footer.php' ?>
    <!-- Bootstrap core JavaScript ================================================== -->
    <script src="./js/jquery-1.11.3.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/bootstrap-submenu.min.js"></script>
    <script src="./js/theme.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="vendor/html5shiv/html5shiv.min.js"></script>
    <script src="vendor/respond/respond.min.js"></script>
    <![endif]-->

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
    <!-- Placed at the end of the document so the pages load faster -->

</body>
</html>



