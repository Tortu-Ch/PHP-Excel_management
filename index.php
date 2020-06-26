<?php
ob_start();
require 'CsvManager.php';
$CsvMng = new CsvManager();

$website_title		=	'MarkedHub.com';

$to					=	'pedronevoeiro10@hotmail.com';

$subject			=	'Result at MarkedHub.com';

$quantity			=	array();

$name				=	'';

$email				=	'';

$errors				=	array();

$resultdias			=	0;

$resultcarrefour	=	0;

$resultextras		=	0;

$resultpdas			=	0;	

$finalresult		=	0;

if(count($_POST)>0)
{

	$quantity		=	$_REQUEST['quantity'];
	
	$name			=	trim($_REQUEST['name']);
	
	$email			=	trim($_REQUEST['email']);
	
	if(strlen($name)==0)
	{
	
		$errors[]	=	'Please enter your name';
	
	}
	if(strlen($email)==0)
	{
	
		$errors[]	=	'Please enter your email';
	
	}
	if(count($errors)==0)
	{
	
		$finalresult	=	1;
	
		$count	=0;
		if (($h = fopen("csv.csv", "r")) !== FALSE) 
		{
		  
		 	while (($data = fgetcsv($h, 1000, ",")) !== FALSE) 
		  	{	
		 		/* echo "<pre>";
					print_r($data);
					
					print_r($quantity);
					
				 echo "</pre>";*/
				if($count==0) {$count++; continue;}	
				
				$qty				=	isset($quantity[$count-1])?$quantity[$count-1]:0;
				
				$dia				=	isset($data[1])?$data[1]:0;
				
				$dia				=	(strlen($dia)!=0)?$dia:0;
				
				$carrefour			=	isset($data[2])?$data[2]:0;
				
				$carrefour			=	(strlen($carrefour)!=0)?$carrefour:0;
				
				$extra				=	isset($data[3])?$data[3]:0;
				
				$extra				=	(strlen($extra)!=0)?$extra:0;
				
				$pda				=	isset($data[4])?$data[4]:0;
				
				$pda				=	(strlen($pda)!=0)?$pda:0;
							
				$resultdias			=	$resultdias+($dia*$qty);
				
				$resultcarrefour	=	$resultcarrefour+($carrefour*$qty);
				
				$resultextras		=	$resultextras+($extra*$qty);
				
				$resultpdas			=	$resultpdas+($pda*$qty);
			
				$count++;
				
			}
			
		$content				=	file_get_contents('emailtemplate.php');
		
		$content				=	str_replace('{website_title}',$website_title,$content);
		$content				=	str_replace('{name}',$name,$content);
		$content				=	str_replace('{email}',$email,$content);
		$content				=	str_replace('{resultdias}',$resultdias,$content);
		$content				=	str_replace('{resultcarrefour}',$resultcarrefour,$content);
		$content				=	str_replace('{resultextras}',$resultextras,$content);
		$message				=	str_replace('{resultpdas}',$resultpdas,$content);
		
		
		
		$headers 				= "MIME-Version: 1.0" . "\r\n";
		
		$headers 				.= "Content-type:text/html;charset=UTF-8" . "\r\n";

		$headers 				.= 'From: <'.$email.'>' . "\r\n";

		mail($to,$subject,$message,$headers);
			
	
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
<title><?=$website_title?></title>
<img src="img/Logo_MarkedHub.png" alt="MarkedHub.com" width="300" height="50">
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
  <div class="container"> <a class="navbar-brand" href="index.php"><?=$website_title?></a>
    <!-- <a class="btn btn-primary" href="#">Sign In</a> -->
  </div>
</nav>
<!-- Icons Grid -->
<section class="features-icons text-center" style="background:#FFF">
  <div class="container">
    <div class="row">
      <div class="col-12 col-md-12">
        <h2 class="text-center"><?=($finalresult==0)?'Details':'Result'?></h2>
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
        <div class="alert alert-danger" role="alert"><?=$value?></div>
	  <?php
	  	}
	  }
	  ?>
	  <?php
	  if($finalresult==0)
	  {
	  ?>
        <form name="form1" method="post" action="index.php">
          <div class="form-group">
            <label for="exampleInputEmail1" class="text-left">Your Name</label>
            <input type="text" name="name" value="<?=$name?>" class="form-control required" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Name">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1" class="text-left">Email address</label>
            <input type="email" name="email" value="<?=$email?>"  class="form-control required" id="exampleInputPassword1" placeholder="Enter Email">
          </div>
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th scope="col" width="75%" class="text-left">Produtos</th>
                <th scope="col" class="text-center">Quantity</th>
              </tr>
            </thead>
            <tbody>
              <?php
			
				$count	=0;
				if (($h = fopen("csv.csv", "r")) !== FALSE) 
				{
				  
				  while (($data = fgetcsv($h, 1000, ",")) !== FALSE) 
				  {	
				  
				  	if($count==0) {$count++; continue;}	
				  
					?>
              <tr>
                <th scope="row" class="text-left"><?=$data['0']?></th>
                <td class="text-center"><div class="form-group">
                    <input type="number" name="quantity[]" value="<?=isset($quantity[$count-1])?$quantity[$count-1]:0?>" class="form-control" />
                  </div></td>
              </tr>
              <?php  
					  $count++;
				   
				  }
				
				  fclose($h);
				}
             ?>
            </tbody>
          </table>
		  <button type="submit" class="btn btn-primary">Submit</button>
		<?php
		}
		else
		{
            $data = $CsvMng->fileRead('csv.csv','r');
		?>
		 <table class="table">
            <thead class="thead-light">
              <tr>
         <?php
              if(count($data)>0)
              {
                  foreach ($data[0] as $head)
                  {
                      echo "<th scope='col' class='text-left'>$head</th>";
                  }
              }

         ?>
              </tr>
            </thead>
            <tbody>
            <?php
            if(count($data)>1)
            {
                $c = 0;
               foreach ($data as $body)
               {
                   if($c == 0)
                   {
                       $c++;
                       continue;
                   }
                   else{
                       echo "<tr>";
                       foreach ($body as $row)
                       {
                           echo "<td class='text-left'>$row</td>";
                       }
                       echo"</tr>";
                   }
               }
            }
            ?>


<!--			 <tr>
                <th scope="row" class="text-left"><?php //echo $resultdias?></th>
                <td class="text-left"><?php //echo $resultcarrefour?></td>
				<td class="text-left"><?php //echo $resultextras?></td>
				<td class="text-left"><?php //echo $resultpdas?></td>
			</tr>
				-->
			
			</tbody>
		</table>
		<a href="index.php">
		<button type="button" class="btn btn-primary">Back</button></a>
		<?php
		}
		?>
	
          
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
