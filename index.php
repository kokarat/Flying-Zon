<?php
/***** Config *******/
$keyword = "Canon+EOS";
$site_title = "Cheap price $keyword";
$siteName = "Deals Store";
$trakingID = "kokarat.me-20";
/*** END Config ***/

require 'simple_html_dom.php';
$tmpPage = trim($_GET[page]);
$tmpUrl = 'http://www.amazon.com/s/ref=nb_sb_noss?url=search-alias%3Daps&field-keywords='.$keyword ;
if($tmpPage <> ""){
	$tmpUrl = $tmpUrl . '&page=' . $tmpPage  ;
}

$html = file_get_html($tmpUrl);
?>

<!DOCTYPE html>
<html>
<head>
<title><?=$siteName." | ".$site_title;?></title>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<link rel="stylesheet" href="assets/css/bootstrap-responsive.css" />
<link rel="stylesheet" href="assets/css/bootstrap.css" />
<link rel="stylesheet" href="assets/css/app.css" />
</head>
<body>

	<header>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid nav-container">
					<nav role="navigation">
						<a href="#" title="<?=$siteName;?>" id="logo" class="brand"><?=$keyword?> <?=$siteName;?></a>
						<a data-target=".nav-collapse" data-toggle="collapse"
							class="btn btn-navbar"> <span class="icon-bar"></span> <span
							class="icon-bar"></span> <span class="icon-bar"></span>
						</a>
					</nav>

					<form action="http://www.amazon.com/exec/obidos/external-search"
						method="get" target="_blank" class="navbar-search pull-right">
						<input type="hidden" name="tag" value="<?=$trakingID?>"> <input
							type="text" value="" name="keyword" placeholder="Search"
							class="search-query">
					</form>
				</div>

			</div>
		</div>
	</header>
    
	<div class="container-fluid">
		<div id="main">
			<div class="row-fluid">
				<div class="well well-large">Are you looking for <i><?=$keyword?></i> ? Good news we found offers for <b><?=$keyword?></b> they are limit time offer don't miss click links check the price now.</div>
			   
			   <?php 
			   $product_title = $html->find('.newaps');
			   //print_r($product_title);
			   foreach ($product_title as $title){
			   	 $ititle[] = strip_tags($title);
			   }
			   //print_r($ititle);
			 
			   foreach($html->find('.productImage') as $imges) {
      				$img[] = $imges->src;
			    }
			    
			   //ASIN
				preg_match_all('#(prod" name=")(.*?)(">)#',$html,$ASIN);
				foreach ($ASIN[2] as $ASIN_result){
					$iasin[] = $ASIN_result;
				}
				
			  //Price 
				preg_match_all('#(<span class="bld lrg red">)(.*?)(</span>)#',$html,$prices);
				foreach ($prices[2] as $price){
					$iprice[] = $price;
				}
			    for ($i = 0; $i <= 15; $i++) {
			    	 echo "<div class='row-fluid'>";
      				 echo "<div class='span2'><a href='http://www.amazon.com/dp/$iasin[$i]/?tag=$trakingID' target='_blank'><img src='$img[$i]' alt='$keyword' class='pull-right'/></a></div>";	
      				 echo "<div class='span10'>$ititle[$i]<div><b class='red'>$iprice[$i]</b><br/><small class='green'>Eligible for FREE Super Saver Shipping</small><br/><a href='http://www.amazon.com/dp/$iasin[$i]/?tag=$trakingID' target='_blank'><button class='btn' type='button'><i class='icon-share-alt'></i> Read more...</button></a></div>";
      				 echo "<hr/></div>";
      				 echo "</div>";
			   
			     }
			   ?>
			   
			   </div>
			</div>
		</div>

        <div id="page-bottom"  style="margin:10px auto;  text-align:center;">		
               
                <?php
                       $get_page = $html->getElementById("pagn");                       	
                       $chkPagnPrev = strpos($get_page,"pagnPrevLink");	
                       $chkPagnNext = strpos($get_page,"pagnNextLink");			
					   
                       foreach($html->find(".pagnCur") as $curr){
                            $tmpPageCurl = strip_tags($curr);
                       }
                    
					
                        if($chkPagnPrev == ""){
                            echo "<span class=\"prevDisabled\">&lsaquo; Previous</span>";
							echo "&nbsp;&nbsp;|&nbsp;&nbsp;Page : " . $tmpPageCurl  . "&nbsp;&nbsp;";	
                        }else{
                            $tmpPagePrev = $tmpPageCurl - 1;			
                            echo "<span class=\"prevEnabled\"><a href='index.php?page=" . $tmpPagePrev . " '>&lsaquo; Previous</a></span>";
							echo "&nbsp;&nbsp;|&nbsp;&nbspPage :&nbsp;";
								
								if($tmpPageCurl > 3){
									echo "&nbsp;<span class=\"pagnLink\"><a href='index.php?page=1'>1</a></span>&nbsp;&nbsp;...&nbsp;&nbsp;";
								}

							echo "&nbsp;<span class=\"pagnLink\"><a href='index.php?page=" . $tmpPagePrev . " '>" . $tmpPagePrev . "</a></span>&nbsp;&nbsp;&nbsp;";	
							echo $tmpPageCurl  . "&nbsp;&nbsp;";	
                        }					
						
                        if($chkPagnNext == ""){
                            echo "<span class=\"nextDisabled\">Next &rsaquo;</span>";
                        }else{
                            $tmpPageNext = $tmpPageCurl + 1;
							echo "&nbsp;<span class=\"pagnLink\"><a href='index.php?page=" . $tmpPageNext . " '>" . $tmpPageNext . "</a></span>&nbsp;";
							echo "&nbsp;&nbsp;...&nbsp;&nbsp;|&nbsp;";
                            echo "<span class=\"nextEnabled\"><a href='index.php?page=" . $tmpPageNext . " '>Next &rsaquo;</a></span>";
                        }			
                    
                ?>
            
        </div>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="well well-large">&copy; <?=$siteName?>
				<ul>
					<li>This site is a participant in the Amazon Services LLC Associates Program, an affiliate advertising program designed to provide a means for sites to earn advertising fees by advertising and linking to Amazon.com</li>
					<li>Amazon and the Amazon logo are trademarks of Amazon.com, Inc. or its affiliates.</li>
					<li>CERTAIN CONTENT THAT APPEARS ON THIS PAGE COMES FROM AMAZON SERVICES LLC. THIS CONTENT IS PROVIDED "AS IS" AND IS SUBJECT TO CHANGE OR REMOVAL AT ANY TIME.</li>
					<li>Product prices and availability are accurate as of the date/time indicated and are subject to change . Any price and availability information displayed on amazon.com at the time of purchase will apply to the purchase of this product.</li>
				</ul>
				</div>
		</div>
	</div>
    
</body>
</html>


<?php
/// ===================================================================
/// ======================= FUNCTION REPLACE TAG ============================
/// ===================================================================
function chkPage($value){
	return $value;
}	
?>