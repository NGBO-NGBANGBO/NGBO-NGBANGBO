<?php
include("../setting.php");
session_start();
if(!isset($_SESSION['CIN']))
{
	
}
else{
    $CIN=$_SESSION['CIN'];
    $a=mysqli_query($set,"SELECT * FROM utilisateur WHERE CIN='$CIN'");
    $b=mysqli_fetch_array($a);
    $name=$b['name'];
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Books">
    <meta name="author" content="Shivangi Gupta">
    <title>Gestion de Bibliothèque</title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/my.css" rel="stylesheet">

    <style>
   
    #books {margin-bottom:50px;}

     @media only screen and (width: 767px) { body{margin-top:150px;}}
        #books .row{margin-top:20px;margin-bottom:10px;font-weight:800;}
        @media only screen and (max-width: 760px) { #books .row{margin-top:10px;}}
        .btn-lg{font-size:30px;}
    </style>

</head>
<body>

    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" style="height:80px;">
      <div class="container-fluid">
        
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a  href= "../kb/empr.php" ><img  src="img/applogo.jpeg"  style="width: 185px;height:78px;position:absolute;top:0px;left:0px;border-radios: 20px;"></a> 
        </div>

        
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
              <?php
                  if(isset($_SESSION['CIN']))
                    {
                      echo'
                    <li> <a href="../changePassword.php" class="btn btn-lg"> Modifier mot de passe </a> </li>; 
                    <li> <a href="../logout.php" class="btn btn-lg"> Se déconecter </a> </li>
                         ';
                    }
               ?>
          </ul>
        </div>
      </div>
    </nav>

    <div id="top" >
    <div id="searchbox" class="container-fluid" style="height:70%;width:112%;margin-top:1.5%;margin-left:-6%;margin-right:-6%;">
          <div>
              <form role="search" method="POST" action="Result.php">
                  <input type="text" class="form-control" name="keyword" style="width:80%;margin:20px 10% 20px 10%;" placeholder="Rechercher un livre , auteur ou categorie">
              </form>
          </div>
      </div>

    <?php
    include "dbconnect.php";
    if(isset($_GET['value']))
        {  
           $_SESSION['category']=$_GET['value'];
        }
    $category=$_SESSION['category'];
    if(isset($_POST['sort']))
    {
        if($_POST['sort']=="price")
                {   $query = "SELECT * FROM books WHERE genre='$category' ";
				
                    $result = mysqli_query ($con,$query)or die(mysqli_error($con));
                    ?>
                       <script type="text/javascript">
                          document.getElementById('select').Selected=$_POST['sort'];
                       </script>
                    <?php
                }
        else
        if($_POST['sort']=="priceh")
                {   $query = "SELECT * FROM books WHERE genre='$category' ";
						
                    $result = mysqli_query ($con,$query)or die(mysqli_error($con));
                }
        else
        if($_POST['sort']=="discount")
                {   $query = "SELECT * FROM books WHERE genre='$category'";
							
                    $result = mysqli_query ($con,$query)or die(mysqli_error($con));
                }
        else
        if($_POST['sort']=="discountl")
                {   $query = "SELECT * FROM books WHERE genre='$category'";
				
                    $result = mysqli_query ($con,$query)or die(mysqli_error($con));
                }
    } 
    else   
            {   $query = "SELECT * FROM books WHERE genre='$category'";
			
                $result = mysqli_query ($con,$query)or die(mysqli_error($con));
            } 
    $i=0;
    echo '<div class="container-fluid" id="books">
        <div class="row">
          <div class="col-xs-12 text-center" id="heading">
                 <h2 style="color:rgb(228, 55, 25);text-transform:uppercase;margin-bottom:0px;"> '. $category .'  </h2>
           </div>
        </div>      
        <div class="container fluid">
             <div class="row">
                  <div class="col-sm-5 col-sm-offset-6 col-md-5 col-md-offset-7 col-lg-4 col-lg-offset-8">
                       <form action="';echo $_SERVER['PHP_SELF'];echo'" method="post" class="pull-right">
                           <label for="sort">Sort by &nbsp: &nbsp</label>
                            <select name="sort" id="select" onchange="form.submit()">
                                <option value="default" name="default"  selected="selected">Select</option>
                                <option value="price" name="price">Low To High Price </option>
                                <option value="priceh" name="priceh">Highest To Lowest Price </option>
                                <option value="discountl" name="discountl">Low To High Discount </option>
                                <option value="discount" name="discount">Highest To Lowest Discount</option>
                            </select>
                       </form>
                  </div>
              </div>
        </div>';

        if(mysqli_num_rows($result) > 0) 
        {   
            while($row = mysqli_fetch_assoc($result)) 
            {
            $path="../pic/" .$row['image']."";
            $description="block3.php?ID=".$row["id"];
            if($i%4==0)
            echo '<div class="row">';
            echo'
               <a href="'.$description.'">
                <div class="col-sm-6 col-md-3 col-lg-3 text-center">
                    <div class="book-block" style="border :3px solid #DEEAEE;">
                        <img class="book block-center img-responsive" src="'.$path.'">
                        <hr>
                         ' . $row["name"] . '<br>
                        ' . $row["author"] .'  &nbsp
                        <span style="text-decoration:line-through;color:#828282;"> ' . $row["isbn"] .' </span>
                        <span class="label label-warning">'. $row["qte"] .'%</span>
                    </div>
                </div>
                
               </a> ';
            $i++;
            if($i%4==0)
            echo '</div>';
            }
        }
    echo '</div>';
    ?>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   
    <script src="js/bootstrap.min.js"></script>
</body>
</html>	
