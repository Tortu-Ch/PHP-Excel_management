<?php
ob_start();
require 'CsvManager.php';
$CsvMng = new CsvManager();
$website_title		=	'MarkedHub.com';
$name				=	'';
$email				=	'';
$errors				=	array();
$success			=	'';
$data = $CsvMng->fileRead('csv.csv','r');

if(isset($_POST['submit']))
{
    $temp = $data;
    if(isset($_POST['RowsName']) && !empty($_POST['RowsName']))
    {
        $temp[0][] = $_POST['RowsName'];
        $success= $CsvMng->fileUpdate('csv.csv', $temp);
        $data = $CsvMng->fileRead('csv.csv','r');
    }

    else if(isset($_POST['ColumnsName']) && (!isset($_POST['ColumnsValue'])))
    {
        if(!empty($_POST['ColumnsName']))$temp[][0] = $_POST['ColumnsName'];
        $success= $CsvMng->fileUpdate('csv.csv', $temp);
        $data = $CsvMng->fileRead('csv.csv','r');
    }

    else if(isset($_POST['ColumnsValue']) && (!isset($_POST['ColumnsName'])))
    {
        if($_POST['row']!='0' && $_POST['row']!='Rows' && $_POST['column']!=='Columns')
        {
            $i = 0;
            $j = 0;
            foreach ($data as $column)
            {
                if($column[0] == $_POST['column'])break;
                else
                {
                    $i++;
                    continue;
                }
            }

            foreach ($data[0] as $row)
            {
                $row_temp = str_replace('_' , ' ' , $row);
                if($row_temp == $_POST['row'])break;
                else{
                    $j++;
                    continue;
                }
            }
            $temp[$i][$j] = $_POST['ColumnsValue'];
            $success= $CsvMng->fileUpdate('csv.csv', $temp);
            $data = $CsvMng->fileRead('csv.csv','r');
        }
    }

    else if(isset($_POST['ColumnsValue']) && isset($_POST['ColumnsName']) && !empty($_POST['ColumnsName']))
    {
        $j=0;
        $add_data = array();
        $add_data[0] = $_POST['ColumnsName'];
        foreach ($data[0] as $row)
        {
            if($j>0)$add_data[$j] = '';
            $row_temp = str_replace('_' , ' ' , $row);
            if($row_temp == $_POST['row'] && $j) {
                $add_data[$j] = $_POST['ColumnsValue'];
                break;
            }
            else{
                $j++;
                continue;
            }
        }
        $temp[] = $add_data;
        $success= $CsvMng->fileUpdate('csv.csv', $temp);
        $data = $CsvMng->fileRead('csv.csv','r');
    }
    else
    {

    }
    $_POST = array();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">
<title>
<?=$website_title?>
</title>
<!-- Bootstrap core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- Custom fonts for this template -->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
<link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
<!-- Custom styles for this template -->
<link href="css/landing-page.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<!-- Navigation -->
<nav class="navbar navbar-light bg-light static-top">
  <div class="container"> <a class="navbar-brand" href="index.php">
    <?=$website_title?>
    </a>
    <!-- <a class="btn btn-primary" href="#">Sign In</a> -->
  </div>
</nav>
<!-- Icons Grid -->
<section class="features-icons text-center" style="background:#FFF">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-12">
        <h2 class="text-center">Upload Latest CSV
        </h2>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-2"></div>
      <div class="col-12 col-md-8">
        <?php
	  if(count($errors)>0)
	  {
	  	foreach($errors as $key=>$value)
		{
	  ?>
        <div class="alert alert-danger" role="alert">
          <?=$value?>
        </div>
        <?php
	  	}
	  }
	  if(isset($success) && $success<>'')
	  {
	  	?>
		<div class="alert alert-success " role="alert" id = 'alert'>
          <?=$success?>
        </div>
		<?php
	  }
	  ?>
        <form name="form1" method="post" action="ucsv-new.php" enctype="multipart/form-data">
		    <div class="form-group">
            <label for="exampleInputEmail1" class="text-left">Rows</label>
			
            <select name="row" class="form-control required" id="row" placeholder="Enter Name">
				<option value="0">Select Option</option>
			<?php
            $count = 0;
            if($data)
            {
                $row_count = 0;
                foreach ($data[0] as $row)
                {
                    if($row_count == 0) {
                        $row_count++;
                        continue;
                    }
                    $row = str_replace('_' , ' ' , $row);
                    echo "<option value='$row'>$row</option>";
                }
            }
			?>
			<option value="Rows"><?php echo 'OTHER ROW';?></option>
			</select>
            </div>
		    <div class="form-group newRow">
            <label for="exampleInputEmail1" class="text-left">Columns</label>
            <select name="column" id = "column" class="form-control required" id="column" placeholder="Enter Name">
			<option value="0">Select Option</option>
			<?php
			$count = 0;
			if($data)
            {
                $column_count = 0;
                foreach ($data as $column)
                {
                    if($column_count == 0)
                    {
                        $column_count++;
                        continue;
                    }
                    echo "<option value='$column[0]'>$column[0]</option>";
                }
            }
			?>
			<option value='Columns' ><?php echo 'OTHER COLUMN';?></option>
			</select>
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
      <div class="col-12 col-md-2"></div>
    </div>
  </div>
</section>
<!-- Footer -->
<footer class="footer bg-light ">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
        <?php /*?>        <ul class="list-inline mb-2">
          <li class="list-inline-item"> <a href="#">About</a> </li>
          <li class="list-inline-item">&sdot;</li>
          <li class="list-inline-item"> <a href="#">Contact</a> </li>
          <li class="list-inline-item">&sdot;</li>
          <li class="list-inline-item"> <a href="#">Terms of Use</a> </li>
          <li class="list-inline-item">&sdot;</li>
          <li class="list-inline-item"> <a href="#">Privacy Policy</a> </li>
        </ul><?php */?>
        <p class="text-muted small mb-4 mb-lg-0">&copy; MarkedHub.com 2019. All Rights Reserved.</p>
      </div>
      <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
        <?php /*?><ul class="list-inline mb-0">
          <li class="list-inline-item mr-3"> <a href="#"> <i class="fab fa-facebook fa-2x fa-fw"></i> </a> </li>
          <li class="list-inline-item mr-3"> <a href="#"> <i class="fab fa-twitter-square fa-2x fa-fw"></i> </a> </li>
          <li class="list-inline-item"> <a href="#"> <i class="fab fa-instagram fa-2x fa-fw"></i> </a> </li>
        </ul><?php */?>
      </div>
    </div>
  </div>
</footer>
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
$(document).on('change', 'select', function(){
    $('#alert').remove();
	$('.onlyC').remove();

	$val = $(this).val();
	$n = $(this).attr('name');

	if($val == 'Columns' || $val =='Rows'){
	    $r =  $('.onlyR').length;
		$name = $val+'Name';
		$value = $val+'Value';

        if($('#row').val() =='Rows' || $('#row').val() =='0') {

        }
        else{
            $('<div class="form-group onlyC"><label for="exampleInputEmail1" class="text-left">'+$value+'</label><input type="text" required class="form-control" name="ColumnsValue"></div>').insertAfter('.newRow');
        }

		if($r ==0 && $val =='Rows'){
            $('#column').val(0);
			$('<div class="form-group onlyR"><label for="exampleInputEmail1" class="text-left">'+$name+'</label><input type="text" required class="form-control" name='+$name+'></div>').insertAfter('.newRow');
		}
		else{
            $('#row').val(0);
			$('<div class="form-group onlyC"><label for="exampleInputEmail1" class="text-left">'+$name+'</label><input type="text" required class="form-control" name="ColumnsName"></div>').insertAfter('.newRow');
		}
	}
	else{
		$('.onlyR').remove();
		if($val !='Select Option' && $val !='0' && $n !='row'  ){
			$('<div class="form-group onlyC"><label for="exampleInputEmail1" class="text-left">'+$val+'</label><input type="text" required class="form-control" name="ColumnsValue"></div>').insertAfter('.newRow');
		}
	}
});
</script>
</body>
</html>

