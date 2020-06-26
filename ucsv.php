<?php
ob_start();

$website_title		=	'MarkedHub.com';


$name				=	'';

$email				=	'';

$errors				=	array();

$success			=	'';

if(count($_POST)>0)
{

	$fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
	$fileName = $_FILES['uploadedFile']['name'];
	$fileSize = $_FILES['uploadedFile']['size'];
	$fileType = $_FILES['uploadedFile']['type'];
	$fileNameCmps = explode(".", $fileName);
	$fileExtension = strtolower(end($fileNameCmps));
	
	if(strlen($fileName)==0)
	{
	
		$errors[]	=	'Please upload file.';
	
	}
	
	if(count($errors)==0)
	{
		$target_path = "";
		$target_path = $target_path . 'csv.csv';
		if(move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $target_path)) 
		{
			$success	=	'File has been successfully uploaded.';
            chmod($target_path, 0777);
		} 
		else
		{
			$errors[]	=	'Sorry, some error occured while uploading the file.';
		}
	}
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
		<div class="alert alert-success " role="alert">
          <?=$success?>
        </div>
		<?php
	  
	  }
	  ?>
        <form name="form1" method="post" action="ucsv.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="exampleInputEmail1" class="text-left">Your Name</label>
            <input type="file" name="uploadedFile" value="<?=$name?>" class="form-control required" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Name">
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
</body>
</html>
