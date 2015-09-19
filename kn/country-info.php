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
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./javascript/jquery-1.11.3.min.js"></script>
    <script src="./javascript/bootstrap.min.js"></script>
    <script lang="javascript" type="text/javascript">
    <!--
        function butSave_OnClick(){
            with(document.CountryForm)
            {
                hidAction.value = 'NewRecord';
                action = 'country-info.php';
                method = 'post';
                submit();
            }
        }
    //-->
    </script>
</head>
<body>

    <div class="container">
        <h2>Country Information</h2>
        <form role="form" id="CountryForm" name="CountryForm">
            <div class="form-group col-lg-2">
                <label for="CountryID">ID:</label>
                <input name="CountryID" type="text" class="form-control input-sm " placeholder="Enter Country ID">
            </div>
            <div class="form-group col-lg-10">
                <label for="CountryName">Country Name:</label>
                <input name="CountryName" type="text" class="form-control input-sm" placeholder="Enter Country Name">
            </div>
            <div class="form-group col-lg-12">  
                <button type="button" class="btn btn-default" onclick="butSave_OnClick()">Save</button>
                <button type="reset" class="btn btn-default">Cancel</button>
            </div>
            <input name="hidAction" type="hidden" />
            <input name="hidCode" type="hidden" />

        </form>
    </div>

    <hr/>
    
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th class="col-lg-2">Country ID</th>
                <th class="col-lg-7">Country Name</th>
                <th class="col-lg-2"></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $value) {
                    echo '<tr>';
                    echo '<td>'. $value['CountryID'] .'</td>';
                    echo '<td>'. $value['CountryName'] .'</td>';
                    echo '<td><button>Edit</button>&nbsp;<button>Delete</button></td>';
                    echo '</tr>';
                } ?>
            </tbody>
        </table>
    </div>
</body> 
</html>

