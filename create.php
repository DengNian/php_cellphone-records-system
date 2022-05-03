<?php
// Include employeeDAO file
require_once('./dao/iphoneDAO.php');
require_once('./model/validation.php');

 
// Define variables and initialize with empty values
$name = $releaseData = $price = $image = "";
$name_err = $releaseDate_err = $price_err = $image_err = "";
$target_dir = "images/";//for images
$target_file="";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s\d]+$/")))){
        $name_err = "Please enter a valid name."; //name must be character space and number
    } else{
        $name = $input_name;
    }
	
	// Validate release Date
    $input_releaseDate = trim($_POST["releaseDate"]);
    if(empty($input_releaseDate)){
        $releaseDate_err = "Please enter the Release Date.";  
    } else {
		$first_release_date='2007-1-9';
		if(dateBDate($first_release_date,$input_releaseDate)){
			$releaseDate_err = "Please enter the right Date.";  
		}else{
			$releaseDate = $input_releaseDate;
		}
		
        
    }
    
    // Validate price (not null and must between: $0-$10000)
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter an valid price.";     
    } else{
		$max_price=10000;
		$actual_price = (float)$input_price;
		if( (bccomp($actual_price, $max_price,2)== 1 ) || (bccomp($actual_price,'0',2)== -1 )){
			$price_err = "Please enter an valid price.between $0-$10000";  
		}else{
			$price = $input_price;
		}
        
    }
	
	
    //$input_image= trim($_POST["image"]);
	if(isset($_FILES["upload"]) && !empty($_FILES["upload"]["tmp_name"])) {
		$image=$_FILES["upload"]["name"];	
		$target_file = $target_dir . basename($_FILES["upload"]["name"]);
	
	// Check if image file is a actual image or fake image
	
	  $check = getimagesize($_FILES["upload"]["tmp_name"]); //if success will return an array,otherwise return false
	  if($check !== false) {
		  // Check if file already exists
		if (file_exists($target_file)) {
			$image_err=$image . " already exists";
		}
	  }else{
		$image_err="Not an Image, please choose a right one!" ; 
	  }
	} 
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($releaseDate_err) && empty($price_err) && empty($image_err)){
		//move image to directory images
		move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file);
		
		
        $iphoneDAO = new iphoneDAO();    
        $iphone = new iphone(0, $name, $releaseDate, $price, $image);
        $addResult = $iphoneDAO->addIphone($iphone);
        echo '<br><h6 style="text-align:center">' . $addResult . '</h6>';   
        header( "refresh:2; url=index.php" ); 
        // Close connection
        $iphoneDAO->getMysqli()->close();
        }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	 <script src="js/script.js"></script>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add new iphone records to the database.</p>
					
					<!--the following form action, will send the submitted form data to the page itself ($_SERVER["PHP_SELF"]), instead of jumping to a different page.-->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Release Date</label>
                            <input type="date" name="releaseDate" class="form-control <?php echo (!empty($releaseDate_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $releaseDate; ?>">
                            <span class="invalid-feedback"><?php echo $releaseDate_err;?></span>
                        </div>
						
						<div class="form-group">
                            <label>Price</label>
							 <div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="price">$</span>
								</div>
								<input type="text" id="price" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
								<span class="invalid-feedback"><?php echo $price_err;?></span>
							</div>
                        </div>
						
                        <div class="form-group">                     						
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Image</h5>
								</div>
								<div class="modal-body">
									<img id="frame" src="" class="img-fluid" />
									<div>
										<input class="form-control <?php echo (!empty($image_err)) ? 'is-invalid' : ''; ?>" type="file" accept="image/*" id="formFile" onchange="preview()" name="upload" value="img">
										<span class="invalid-feedback"><?php echo $image_err;?></span>
										<button type="button" class="btn btn-danger float-right" onclick="clearImage()">No Image</button>
									</div>		
								</div>
							</div>						
							
							
							
														
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>					
					
                </div>
            </div>        
        </div>
        <?include 'footer.php';?>
    </div>
</body>
</html>