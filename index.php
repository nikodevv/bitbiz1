<!doctype html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>BitBiz - Grow With Us</title>
		<meta name="description" content="Unika - Responsive One Page HTML5 Template">
		<meta name="keywords" content="HTML5, Bootsrtrap, One Page, Responsive, Template, Portfolio" />
		<meta name="author" content="imransdesign.com">

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Google Fonts  -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet' type='text/css'> <!-- Body font -->
		<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'> <!-- Navbar font -->

		<!-- Libs and Plugins CSS -->
		<link rel="stylesheet" href="inc/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="inc/animations/css/animate.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css">
		<link rel="stylesheet" href="inc/font-awesome/css/font-awesome.min.css"> <!-- Font Icons -->


		<link rel="stylesheet" href="inc/owl-carousel/css/owl.carousel.css">
		<link rel="stylesheet" href="inc/owl-carousel/css/owl.theme.css">

		<!-- Theme CSS -->
        <link rel="stylesheet" href="css/reset.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/mobile.css">

		<!-- Skin CSS -->
		<link rel="stylesheet" href="css/skin/cool-gray.css">
		<link rel="icon" href="./img/bitbizlogo.png" type="image/x-icon">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

	</head>

    <body data-spy="scroll" data-target="#main-navbar">
	
	<?php
/////////////////////////////////////////////////////////////// START THE CUSTOMER ROI FORMULA \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
// Ethereum's first price. Taken on August 12th, 2015.
$ethICOdate = "2015-08-12";
$ethStartPriceUSD = 1.06; // USD. Taken from: https://coinmarketcap.com/currencies/ethereum/historical-data/?start=20130428&end=20180322
// Conversion rate USD->CAD at that date.
	$USD2CAD = 1.3135; // Taken from: https://www.exchange-rates.org/Rate/USD/CAD/8-7-2015
// Conversion Calculation
	$ethStartPriceCAD = $ethStartPriceUSD * $USD2CAD;
// Connect for the latest Canadian price.
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_URL, 'https://min-api.cryptocompare.com/data/price?fsym=ETH&tsyms=CAD');
curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/ethereum/?convert=CAD');
$result = curl_exec($ch);
curl_close($ch);
//$obj = json_decode($result);
$result = ltrim($result, '[');
$result = rtrim($result, ']');
$obj = json_decode($result);
//echo $obj;
if ($obj != "") {
	// Current ethereum price in CAD.
	$ethCurPrice = $obj->{'price_cad'};
	$ethCurPrice = number_format((float)$ethCurPrice, 2, '.', '');
	
	// Calculate the average return.
	// The next 4 lines convert the date values to time values.
		$d1 = strtotime($ethICOdate);
		$d2 = strtotime(date("Y-m-d"));
		$min_date = min($d1, $d2);
		$max_date = max($d1, $d2);
	// Create the totalMonths variable.
		$totalMonths = 0;
	// Count the njumber of months that have passed, and assign to totalMonths variable.
		while (($min_date = strtotime("+1 MONTH", $min_date)) <= $max_date) {
			$totalMonths++;
		}
		// echo "Total Months: ".$totalMonths;
	// Calculate the average monthly return. Take the current ethereum price and divide it by the starting price. Then divide by the number of months since Aug. 2015.
		$avgMonthlyReturn = ($ethCurPrice/$ethStartPriceCAD)/$totalMonths;
		$avgMonthlyReturn = number_format((float)$avgMonthlyReturn, 2, '.', '');
		$decAvg = ($avgMonthlyReturn/100)+1;
}	



/*
require_once ('./bitadmin/bitbizinc/bitbizsitedetails.php'); // MySQL connection details. Required for pages with MySQL connections.
// Get blocktime and difficulty from DB
	$query="select * from `blockdifficulty` order by `bdid` DESC limit 1";
	$result = $db->query($query);
	$row = $result->fetch_assoc();
*/	
	// $blockTime = $row['blockTime'];
	$blockTime = 14.6582653817643;
	// $difficulty = $row['difficulty'];
	$difficulty = 3155453383616100;
/*
// Get total expense cost
	$query="select SUM(expcost) from `expmonth`";
	$result = $db->query($query);
	$row = $result->fetch_assoc();
	$onerigtotal = $row['SUM(expcost)'];
	*/
	$onerigtotal = 202.5;
	
// Get latest 6h average hashrate from db
// Get blocktime and difficulty from DB
	/*
	$query="select * from `acctinfo` order by `acctinfoid` DESC limit 1";
	$result = $db->query($query);
	$row = $result->fetch_assoc();
	$numRigs = 5;
	*/
	//$ah6 = $row['ah6']/$numRigs; // Currently AH6 shows the Hash Rate for 5 rigs. After this calculation it will show it for 1 rig.
	$ah6 = 311.28;

// Calculate values per rig
	$netHashGH = ($difficulty / $blockTime) / 1000000000;
	$userRatio = $ah6 * 1000000 / ($netHashGH * 1000000000);
	$blocksPerMin = 60.0 / $blockTime;	
	
// Not sure what this line does.
	$ethereumPerMin = $blocksPerMin * 5.0;
// Ethereum Generated per rig
	$ethPerMin = $userRatio * $ethereumPerMin;
	$ethPerHour = $ethPerMin * 60;
	$ethPerDay = $ethPerHour * 24;
	//$ethPerMonth = $ethPerDay * 30;
	$ethPerMonth = 0.8;
	
// CAD per month:
	$cadPerMonth = $ethPerMonth*$ethCurPrice;
	

///////////////////////////////////////////// ALL NEW CALCULATIONS /////////////////////////////////////////////
// These numbers won't perfectly match the excel, because it takes decred into account.
// Initial investment amount (10,000 to start. This will give them 1% of the company.)
$invest = 10000;
$roi = $invest;
$bonus = 2;

if ($invest == 10000) {
	$opercentage = 1;
} else if ($invest == 20000) {
	$opercentage = 2;
} else if ($invest == 30000) {
	$opercentage = 3;
} else if ($invest == 40000) {
	$opercentage = 4;
} else if ($invest == 50000) {
	$opercentage = 5;
} else if ($invest == 60000) {
	$opercentage = 6;
} else if ($invest == 70000) {
	$opercentage = 7;
} else if ($invest == 80000) {
	$opercentage = 8;
} else if ($invest == 90000) {
	$opercentage = 9;
} else if ($invest == 100000) {
	$opercentage = 10;
}

// Ethereum Price CAD (B2)
$ethPriceCAD = $ethCurPrice;

// Coin count per month (ethereum) (B8)
$ethNumPerRig = $ethPerMonth;

// Cost Per Rig Per Month (elec and warehouse) (B5 + B6)
$expPerRig = number_format((float)$onerigtotal, 2, '.', '');

// Total coin ROI
$avgMonthlyReturn = $avgMonthlyReturn; // This is the variable from the index.php calculations.

// Net earnings per month per rig (B10)
$earnMoCADPerRig = ($ethNumPerRig * $ethPriceCAD) - $expPerRig;
$earnMoCADPerRig = number_format((float)$earnMoCADPerRig, 2, '.', '');

// Rig Price
$rigPrice = 9500;

// Init number of rigs
$totalRigCount =0; // This is to initialize the calculation. It gets displayed later in the script.

// Adding Rigs this month (B31) // Start off with 5 to represent the rigs we have.
$newRig = 5;

// Total number of rigs
$totalRigCount = $totalRigCount + $newRig;

// Net Earnings for 100% per month (B35)
$netEarnCAD = $totalRigCount * $earnMoCADPerRig;
$netEarnCAD = number_format((float)$netEarnCAD, 2, '.', '');

// Company Value 100% (B32)
$comVal100 = $netEarnCAD * 12 * 10;
$comVal100 = number_format((float)$comVal100, 2, '.', '');

// Company Value 1% (B33)
$comVal1 = $comVal100/100;
$comVal1 = number_format((float)$comVal1, 2, '.', '');

// 30% reinvestment number (B36)
$thirty = $netEarnCAD * 0.3;
$thirty = number_format((float)$thirty, 2, '.', '');

// 70% Payout number (B37)
$seventy = $netEarnCAD * 0.7;
$seventy = number_format((float)$seventy, 2, '.', '');

// Investor payout
$payout = ($seventy/100)*$opercentage;
$payout = number_format((float)$payout, 2, '.', '');

////////////////// Tier 1 investors.
// 100,000 initial investment amount. 
$invest = 100000 + $thirty;

// Net earnings per month per rig (B10)
$earnMoCADPerRig = $earnMoCADPerRig * $decAvg;
$earnMoCADPerRig = number_format((float)$earnMoCADPerRig, 2, '.', '');
$netEarnPerRigDisp = "";
$netEarnPerRigDisp .= $earnMoCADPerRig.", ";

// Rig Price
$rigPrice = 9500;

// Adding Rigs this month (B31) // Start off with 5 to represent the rigs we have.
$rigLowCount = $invest/$rigPrice; 
$newRig = floor($rigLowCount);
$rigCountDisplay = "";
$rigCountDisplay .= $newRig.", ";

// Total number of rigs
$totalRigCount = $totalRigCount + $newRig;
$rigTotalDisplay = "";
$rigTotalDisplay .= $totalRigCount.", ";

// Net Earnings for 100% per month (B35)
$netEarnCAD = $totalRigCount * $earnMoCADPerRig;
$netEarnCAD = number_format((float)$netEarnCAD, 2, '.', '');

// Company Value 100% (B32)
$comVal100 = $netEarnCAD * 12 * 10;
$comVal100 = number_format((float)$comVal100, 2, '.', '');

// Company Value 1% (B33)
$comVal1 = $comVal100/100;
$comVal1 = number_format((float)$comVal1, 2, '.', '');
$percentage = $opercentage * $bonus;

// 30% reinvestment number (B36)
$thirty = $netEarnCAD * 0.3;
$thirty = number_format((float)$thirty, 2, '.', '');

// 70% Payout number (B37)
$seventy = $netEarnCAD * 0.7;
$seventy = number_format((float)$seventy, 2, '.', '');

// Investor payout
$payout = ($seventy/100)*$percentage;
$payout = number_format((float)$payout, 2, '.', '');
$totalPayout = 0;
$totalPayout = $totalPayout + $payout;
$dividenddisp = "";
$dividenddisp .= $totalPayout .", ";
$payoutdisp = "";
$payoutdisp .= $payout .", ";

for ($i=0;$i < 3;$i++) {
	////////////////// Tier 2 investors.
	// First 5% investors.
	$invest = ($comVal1 * 5) + $thirty;

	// Net earnings per month per rig (B10)
	$earnMoCADPerRig = $earnMoCADPerRig * $decAvg;
	$earnMoCADPerRig = number_format((float)$earnMoCADPerRig, 2, '.', '');
	$netEarnPerRigDisp .= $earnMoCADPerRig.", ";

	// Rig Price
	$rigPrice = 9500;

	// Adding Rigs this month (B31) // Start off with 5 to represent the rigs we have.
	$rigLowCount = $invest/$rigPrice; 
	$newRig = floor($rigLowCount);
	$rigCountDisplay .= $newRig.", ";

	// Total number of rigs
	$totalRigCount = $totalRigCount + $newRig;
	$rigTotalDisplay .= $totalRigCount.", ";

	// Net Earnings for 100% per month (B35)
	$netEarnCAD = $totalRigCount * $earnMoCADPerRig;
	$netEarnCAD = number_format((float)$netEarnCAD, 2, '.', '');

	// Company Value 100% (B32)
	$comVal100 = $netEarnCAD * 12 * 10;
	$comVal100 = number_format((float)$comVal100, 2, '.', '');

	// Company Value 1% (B33)
	$comVal1 = $comVal100/100;
	$comVal1 = number_format((float)$comVal1, 2, '.', '');
	$percentage = $opercentage * $bonus;

	// 30% reinvestment number (B36)
	$thirty = $netEarnCAD * 0.3;
	$thirty = number_format((float)$thirty, 2, '.', '');

	// 70% Payout number (B37)
	$seventy = $netEarnCAD * 0.7;
	$seventy = number_format((float)$seventy, 2, '.', '');

	// Investor payout
	$payout = ($seventy/100)*$percentage;
	$payout = number_format((float)$payout, 2, '.', '');
	$totalPayout = $totalPayout + $payout;
	$dividenddisp .= $totalPayout .", ";
	$payoutdisp .= $payout .", ";
}

$j = 14; // Time period
for ($i=0;$i < $j;$i++) {
	if ($i == ($j-1)) {
		$endcomma = "";
	} else {
		$endcomma = ", ";
	}
	////////////////// 30% investment only.
	$invest = $thirty;

	// Net earnings per month per rig (B10)
	$earnMoCADPerRig = $earnMoCADPerRig * $decAvg;
	$earnMoCADPerRig = number_format((float)$earnMoCADPerRig, 2, '.', '');
	$netEarnPerRigDisp .= $earnMoCADPerRig.$endcomma;

	// Rig Price
	$rigPrice = 9500;
	
	// Adding Rigs this month (B31) // Start off with 5 to represent the rigs we have.
	$rigLowCount = $invest/$rigPrice; 
	$newRig = floor($rigLowCount);
	$rigCountDisplay .= $newRig.$endcomma;

	// Total number of rigs
	$totalRigCount = $totalRigCount + $newRig;
	$rigTotalDisplay .= $totalRigCount.$endcomma;

	// Net Earnings for 100% per month (B35)
	$netEarnCAD = $totalRigCount * $earnMoCADPerRig;
	$netEarnCAD = number_format((float)$netEarnCAD, 2, '.', '');

	// Company Value 100% (B32)
	$comVal100 = $netEarnCAD * 12 * 10;
	$comVal100 = number_format((float)$comVal100, 2, '.', '');

	// Company Value 1% (B33)
	$comVal1 = $comVal100/100;
	$comVal1 = number_format((float)$comVal1, 2, '.', '');
	if ($i < 8) {
		$percentage = $opercentage * $bonus;
	} else {
		$percentage = $opercentage;
	}

	// 30% reinvestment number (B36)
	$thirty = $netEarnCAD * 0.3;
	$thirty = number_format((float)$thirty, 2, '.', '');

	// 70% Payout number (B37)
	$seventy = $netEarnCAD * 0.7;
	$seventy = number_format((float)$seventy, 2, '.', '');

	// Investor payout
	$payout = ($seventy/100)*$percentage;
	$payout = number_format((float)$payout, 2, '.', '');
	$totalPayout = $totalPayout + $payout;
	$dividenddisp .= $totalPayout . $endcomma;
	$payoutdisp .= $payout .", ";
}

$j=$j+4;
?>
        <div class="page-loader"></div>  <!-- Display loading image while page loads -->
    	<div class="body">
        
            <!--========== BEGIN HEADER ==========-->
            <header id="header" class="header-main">

                <!-- Begin Navbar -->
                <nav id="main-navbar" class="navbar navbar-default navbar-fixed-top" role="navigation"> <!-- Classes: navbar-default, navbar-inverse, navbar-fixed-top, navbar-fixed-bottom, navbar-transparent. Note: If you use non-transparent navbar, set "height: 98px;" to #header -->

                  <div class="container">

                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand page-scroll" href="./index.html">BitBiz Crypto</a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a class="page-scroll" href="body">Home</a></li>
                            <li><a class="page-scroll" href="#about-section">About Us</a></li>
                            <li><a class="page-scroll" href="#services-section">Investment Calculator</a></li>
                            <li><a class="page-scroll" href="#portfolio-section">What Else Should I Know?</a></li>
                            <li><a class="page-scroll" href="#contact-section">Contact</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                  </div><!-- /.container -->
                </nav>
                <!-- End Navbar -->

            </header>
            <!-- ========= END HEADER =========-->
            
            
            
            
        	<!-- Begin text carousel intro section -->
			<section id="text-carousel-intro-section" class="parallax" data-stellar-background-ratio="0.5" style="background-image: url(img/slider-bg.jpg);">
				
				<div class="container">
					<div class="caption text-center text-white" data-stellar-ratio="0.7">

						<!--div id="owl-intro-text" class="owl-carousel"-->
							<div class="item">
								<h1>Introducing BitBiz</h1>
								<p>Cyrpto Investing Made Simple</p>
                                <div class="extra-space-l"></div>
							</div>
					</div> <!-- /.caption -->
				</div> <!-- /.container -->

			</section>
			<!-- End text carousel intro section -->
                
                
                
                
            <!-- Begin about section -->
			<section id="about-section" class="page bg-style1">
                <!-- Begin page header-->
                <div class="page-header-wrapper">
                    <div class="container">
                        <div class="page-header text-center wow fadeInUp" data-wow-delay="0.3s">
                            <h2>About Us</h2>
                            <div class="devider"></div>
                            <p class="subtitle">It's Nice to Meet You</p>
                        </div>
                    </div>
                </div>
                <!-- End page header-->

                <!-- Begin rotate box-1 -->
                <div class="rotate-box-1-wrapper">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <a href="#" class="rotate-box-1 square-icon wow zoomIn" data-wow-delay="0">
                                    <span class="rotate-box-icon"><i class="fa fa-database"></i></span>
                                    <div class="rotate-box-info">
                                        <h4>Blockchain </h4>
                                        <p>The blockchain is an incorruptible digital ledger of economic transactions that can be programmed to record not just financial transactions but virtually everything of value.</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <a href="#" class="rotate-box-1 square-icon wow zoomIn" data-wow-delay="0.2s">
                                    <span class="rotate-box-icon"><i class="fa fa-laptop"></i></span>
                                    <div class="rotate-box-info">
                                        <h4>What We Do?</h4>
                                        <p>BitBiz Crypto Inc. validates transactions in the blockchain and is awarded Ethereum for our efforts. The more we grow, the more rewards we reap.</p>
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <a href="#" class="rotate-box-1 square-icon wow zoomIn" data-wow-delay="0.4s">
                                    <span class="rotate-box-icon"><i class="fa fa-pie-chart"></i></span>
                                    <div class="rotate-box-info">
                                        <h4>How Can I Benefit?</h4>
                                        <p>We pay our investors dividends on a weekly basis. Dividends are paid in digital or fiat currency.</p>
                                    </div>
                                </a>
                            </div>
                            
                            <div class="col-md-3 col-sm-6">
                                <a href="#" class="rotate-box-1 square-icon wow zoomIn" data-wow-delay="0.6s">
                                    <span class="rotate-box-icon"><i class="fa fa-clock-o"></i></span>
                                    <div class="rotate-box-info">
                                        <h4>Since When?</h4>
                                        <p>BitBiz has been in operation since the end of 2017 and is based in Canada.</p>
                                    </div>
                                </a>
                            </div>
                        </div> <!-- /.row -->
                    </div> <!-- /.container -->
                </div>
                <!-- End rotate box-1 -->
          </section>
          <!-- End about section -->

              
              
              
          <!-- Begin Prospectus -->
          <section id="cta-section" class="testimonial text-white parallax" data-stellar-background-ratio="0.5" style="background-image: url(img/testimonial-bg.jpg);">
          	<div class="cta" >
			<div class="cover"></div>
            	<div class="container">
                	<div class="row">
                    	<div class="col-md-9">
                        	<h1>Review Our Prospectus</h1>
                            <p>Find out why investing with us is a good idea...</p>
                        </div>
                        
                        <div class="col-md-3">
                        	<div class="cta-btn wow bounceInRight" data-wow-delay="0.4s">
								<a class="btn btn-disabled btn-lg" href="#" role="button"><span class="rotate-box-icon"><i class="fa fa-file-pdf-o"></i></span> Coming Soon</a>
                        	</div>
                        </div>
                        
                    </div> <!-- /.row -->
                </div> <!-- /.container -->
            </div>
          </section>
          <!-- End Prospectus -->
			
              
              
            <!-- Begin Investment Calculator -->
            <section id="services-section" class="page text-center">
                <!-- Begin page header-->
                <div class="page-header-wrapper">
                    <div class="container">
                        <div class="page-header text-center wow fadeInDown" data-wow-delay="0.4s">
                            <h2>Investment Calculator</h2>
                            <div class="devider"></div>
                            <p class="subtitle">What Investing With Us Looks Like</p>
                        </div>
                    </div>
                </div>
                <!-- End page header-->
            
                <!-- Begin rotate box-2 -->
                <div class="rotate-box-2-wrapper">
                    <div class="container">
                        <div class="row">
							<div class="col-sm-4"> <!-- Form -->
								<div class="calc-form">
                                	<h4>Investment Amount: <a href=""><i class="fa fa-question-circle"></i></a></h4>
                                    <form role="form">
										<style>
											.slidecontainer {
												width: 100%;
												margin: 20px;
											}

											#invSlider {
												-webkit-appearance: none;
												width: 100%;
												height: 10px;
												border-radius: 5px;
												background: #025142;
												outline: none;
												opacity: 1;
											}

											#invSlider:hover {
												opacity: 1;
											}

											#invSlider::-webkit-slider-thumb {
												-webkit-appearance: none;
												appearance: none;
												width: 24px;
												height: 24px;
												border: 0;
												background: url('./img/bitbizlogo.png');
												cursor: pointer;
											}

											#invSlider::-moz-range-thumb {
												width: 24px;
												height: 24px;
												border: 0;
												background: url('./img/bitbizlogo.png');
												cursor: pointer;
											}
										</style>
										<div class="slidecontainer">
											<!--label for="invSlider">Investment:</label-->
											<input type="range" min="10000" max="100000" value="10000" id="invSlider" step="10000" list="invamt">
											<datalist id="invamt">
												<option>10000</option>
												<option>20000</option>
												<option>30000</option>
												<option>40000</option>
												<option>50000</option>
												<option>60000</option>
												<option>70000</option>
												<option>80000</option>
												<option>90000</option>
												<option>100000</option>
											</datalist>
										</div>
                                        <!--div class="form-group">
                                            <input type="number" class="form-control input-lg" placeholder="Investment Amount" value="10000" min="10000" max="100000" required>
                                        </div>
                                        <div class="form-group">
											<button type="submit" class="btn btn-default wow bounceInRight" data-wow-delay="0.8s">Calculate</button>
                                        </div-->
                                        <div class="form-group">
											<div class="row">
												<div class="col-sm-8">
													<h5><i>Investment Amount:</i></h5>
												</div>
												<div class="col-sm-4">
													<font color="#025142"><h5>$<span id="invAmt"></span></h5></font>
												</div>
											</div>
                                        </div>
                                        <div class="form-group">
											<div class="row">
												<div class="col-sm-8">
													<h5><i>Percentage Shares Owned:</i></h5>
												</div>
												<div class="col-sm-">
													<font color="#025142"><h5><span id="perc"></span><?php //echo $opercentage;?>%</h5></font>
												</div>
											</div>	
                                        </div>
                                        <div class="form-group">
											<div class="row">
												<div class="col-sm-8">
													<h5><i>Total Return in <?php echo $j;?> Months:</i></h5>
												</div>
												<div class="col-sm-">
													<font color="#025142"><h5><span id="ROI">$<?php echo number_format((float)$totalPayout, 2, '.', ''); ?></span></h5></font>
												</div>	
											</div>
                                        </div>
										<script type="text/javascript">
											
										</script>
                                    </form>
                                </div>
							</div>
							
							<div class="col-sm-8"> <!-- Chart -->
								<script src="./js/chart.js"></script>
								<div id="chartcontainer" style="min-width: 310px; height: 400px; margin: 0"></div>
								<script type="text/javascript">
									// Slider Script
									var slider = document.getElementById("invSlider");
									var invAmt = document.getElementById("invAmt");
									var perc = document.getElementById("perc");
									invAmt.innerHTML = slider.value; // Display the default slider value
									perc.innerHTML = slider.value/10000; // Display the default slider value

									// Update the current slider value (each time you drag the slider handle)
									slider.oninput = function() {
										invAmt.innerHTML = this.value;
										perc.innerHTML = this.value/10000;
									}
									// End Slider Script
								
									var dividendPayout = [<?php echo $dividenddisp; ?>];
									var monthlyDividend = [<?php echo $payoutdisp; ?>];
									var slider = document.getElementById("invSlider");
									// Creates a series corresponding to straight line of 
									// investment cost. Has an extra datapoint due to
									// starting point on xAxis being 0.
									var defaultROILine = dividendPayout.map(x => 10000);
									defaultROILine.push(10000);
									var roiLine = defaultROILine;
									var chart = Highcharts.chart('chartcontainer', {
										chart: {
											zoomType: 'x',
											animation: {
												duration: 750
										    }
										},
										xAxis: {
											min: 1,
											title: {
												text: 'Months'
											}
										},
										yAxis: {
											min: 1,
											title: {
												text: 'Canadian Dollars'
											}, 
											// must divide maximum axis amount
											tickPixelInterval: 72, 
											tickInterval: 10000,
											maxPadding: 0,

										},
										
										colors: ['#025142', 'black', 'orange'],
										title: {
											text: 'Total Dividends Over Time'
										},
										tooltip: {
											shared: true,
											crosshairs: true
										},
										series: [
											{
												type: 'column',
												name: 'Dividend Paid to Date',
												data: dividendPayout,
												pointStart: 1,
												marker: {
													radius: 4
												},
												tooltip: {
													valueDecimals: 2,
													valuePrefix: '$'
												},
											},
											{
												type: 'line',
												name: 'Monthly Dividend Amount',
												data: monthlyDividend,
												pointStart: 1,
												marker: {
													radius: 4
												},
												tooltip: {
													valueDecimals: 2,
													valuePrefix: '$'
												},
											},
											{
												type: 'line',
												name: 'Return on Investment Mark',
												data: roiLine,
												pointStart: 0,
												marker: {
													enabled: false
												},
												states: {
													hover: {
														lineWidth: 0
													}
												},
												enableMouseTracking: false
											}
										]
									});	

									//default axis setting (set with function to avoid constant duplication)
									formatYAxis(1);
									// when the slider changes it triggers an onchange event
									slider.onchange = function recalculateInvestment(){
										/*
										Instead of redoing all the math done in the PHP formula, much of
										it can be reused here. The PHP formula finds the returns on a
										10k investment then scales it by the appropriate amounts.
										The recalculation on that 10k investment does not need to be repeated,
										only the scaling, which is done here.
										*/
										// resets dividenPayout array from last time slider was changed
										dividendPayout = [<?php echo $dividenddisp; ?>];
										// resets monthlyDividend array from last time slider was changed
										monthlyDividend = [<?php echo $payoutdisp; ?>];
										// corresponds to $opercentage
										investFactor = getOpcnt(slider.value)

										// rescales the dividendPayout array.
										dividendPayout = dividendPayout.map(x => investFactor*x);
										// rescales monthlyDividend (dividend payments Series data)
										monthlyDividend = monthlyDividend.map(x => investFactor*x);
										roiLine = defaultROILine.map(x => 10000*investFactor);
										/* 
										The chart could be redrawn now but that wouldn't include 
										any animation apart from a barely noticable axis # change.

										Axis settings on the chart have to be manipulated to create 
										an animation, otherwise the picture of the graph stays static
										and only the axis numbers change (since the dollar value of returns
										is only scalar multiple of the original 10k investment).
										*/
										
										// update extremes here
										formatYAxis(investFactor);
										// redraws charts with updated series from slider input
										chart.series[0].setData(dividendPayout, true);
										chart.series[1].setData(monthlyDividend, true);
										chart.series[2].setData(roiLine, true);
									}
									
									function getOpcnt(invest){
										if (invest == 10000){
											return 1;
										}
										else if (invest == 20000){
											return 2;
										}
										else if (invest == 30000){
											return 3;
										}
										else if (invest == 40000){
											return 4;
										}
										else if (invest == 50000){
											return 5;
										}
										else if (invest == 60000){
											return 6;
										}
										else if (invest == 70000){
											return 7;
										}
										else if (invest == 80000){
											return 8;
										}
										else if (invest == 90000){
											return 9;
										}
										else if (invest == 100000){
											return 10;
										}
									}
									
									// sets parameters for Y axis on the basis of a factor
									function formatYAxis(factor){
										/* 
										The Y axis needs to be adjusted or changes from the slider 
										will not be noticable. The scaling factor will always be [1,10]
										*/
										factor = Math.min(10, Math.max(1, factor));
										var maxAmt = 22500*factor - factor**(1.4)*1000;

										// if (factor==2){
										// 	maxAmt = 60000
										// }
										// if 
										// chart.yAxis[0].setExtremes(0, 25000*factor + 2500*(10-factor)/10);
										chart.yAxis[0].setExtremes(0, maxAmt);
									}
									// function to set y axis extemes goes here.								
								</script>
							</div> <!-- End Chart-->
                        </div> <!-- /.row -->
                    </div> <!-- /.container -->
                </div>
                <!-- End rotate-box-2 -->
            </section>
            <!-- End Investment Calculator -->

            <!-- Begin counter up -->
            <section id="counter-section">                					
				<div id="counter-up-trigger" class="counter-up text-white parallax" data-stellar-background-ratio="0.5" style="background-image: url(img/counter-bg.jpg);">
					<div class="cover"></div>
                    <!-- Begin page header-->
                    <div class="page-header-wrapper">
                        <div class="container">
                            <div class="page-header text-center wow fadeInDown" data-wow-delay="0.4s">
                                <h2>Some Fun Facts</h2>
                                <div class="devider"></div>
                                <p class="subtitle">Why We Love Ethereum (Figures are Real-Time)</p>
                            </div>
                        </div>
                    </div>
                    <!-- End page header-->
					<div class="container">

						<div class="row">
							
							<?php
								if ($obj != "") {
									// $ethCurPrice = $obj->CAD;
									//$ethCurPrice = $obj->price_cad;
									$ethCurPrice = $obj->{'price_cad'};
									$ethCurPrice = number_format((float)$ethCurPrice, 2, '.', '');
									//$ethMarCap = $obj->market_cap_cad;
									$marcap = $obj->{'market_cap_cad'};
									if ($marcap < 1000000) {
										// Anything less than a million
										$marcap = number_format($marcap);
									} else if ($marcap < 1000000000) {
										// Anything less than a billion
										$marcap = number_format($marcap / 1000000, 2);
										$suffix = "M";
									} else if ($marcap < 1000000000000) {
										// At least a billion
										$marcap = number_format($marcap / 1000000000, 2);
										$suffix = "B";
									} else {
										// At least a trillion
										$marcap = number_format($marcap / 1000000000000, 2);
										$suffix = "T";
									}
									//$rank = $obj->rank;
									$rank = $obj->{'rank'};
									
									// Display Ethereum's current price
									$eth = "
										<div class='fact text-center col-md-3 col-sm-6'>
											<div class='fact-inner'>
												<i class='fab fa-ethereum fa-3x'></i>
												<div class='extra-space-l'></div>
												<i class='fas fa-dollar-sign fa-2x'></i><span class='counter'>".$ethCurPrice."</span>
												<p class='lead'>Ethereum's Current Price in CAD</p>
											</div>
										</div>
									";
									
									$marcap = "
									<div class='fact text-center col-md-3 col-sm-6'>
										<div class='fact-inner'>
											<i class='fa fa-pie-chart fa-3x'></i>
											<div class='extra-space-l'></div>
											<i class='fas fa-dollar-sign fa-2x'></i><span class='counter'>".$marcap."</span><i class='fa-2x'>".$suffix."</i>
											<p class='lead'>Ethereum's Market Cap in CAD</p>
										</div>
									</div>
									";
									
									$rank = "
										<div class='fact last text-center col-md-3 col-sm-6'>
											<div class='fact-inner'>
												<i class='fa fa-trophy fa-3x'></i>
												<div class='extra-space-l'></div>
												<span class='counter'>".$rank."</span>
												<p class='lead'>Current Rank</p>
											</div>
										</div>
									";
									
									
									$mom = "
										<div class='fact text-center col-md-3 col-sm-6'>
											<div class='fact-inner'>
												<i class='fa fa-line-chart fa-3x'></i>
												<div class='extra-space-l'></div>
												<span class='counter'>".$avgMonthlyReturn."</span><i class='fas fa-percent fa-2x'></i>
												<p class='lead'>Month-over-Month return since August 12th, 2015</p>
											</div>
										</div>
									";
									echo $eth;
									echo $mom;
									echo $rank;
									echo $marcap;
								}
								
							?>

						</div> <!-- /.row -->
					</div> <!-- /.container -->
				</div>
            </section>
			<!-- End counter up -->
              
              
              
                
            <!-- Begin What Else? -->
            <section id="portfolio-section" class="page bg-style1">
            	<div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portfolio">
                                <!-- Begin page header-->
                                <div class="page-header-wrapper">
                                    <div class="container">
                                        <div class="page-header text-center wow fadeInDown" data-wow-delay="0.4s">
                                            <h2>What Else Should I Know?</h2>
                                            <div class="devider"></div>
                                            <p class="subtitle">Global Organizations are Investing in the Ethereum Infrastructure. Take a Look for Yourself.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- End page header-->
                                <div class="portfoloi_content_area" >
                                    <div class="portfolio_content">
                                        <div class="row"  id="portfolio">
                                            <div class="col-xs-12 col-sm-4 appsDevelopment">
                                                <div class="portfolio_single_content">
                                                    <img src="img/portfolio/p1.jpg" alt="title"/>
                                                    <div>
                                                        <a href="https://globalnews.ca/news/3977745/ethereum-blockchain-canada-nrc/" target="_blank">Canada Trialing Use of Ethereum Blockchain to Enhance Transparency in Government Funding</a>
                                                        <span>January 20, 2018</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 GraphicDesign">
                                                <div class="portfolio_single_content">
                                                    <img src="img/portfolio/p2.jpg" alt="title"/>
                                                    <div>
                                                        <a href="https://www.coindesk.com/royal-bank-of-canada-credit-scores-blockchain-patent-application/" target="_blank">Royal Bank of Canada Explores Blockchain to Automate Credit Scores</a>
                                                        <span>March 16, 2018</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 responsive">
                                                <div class="portfolio_single_content">
                                                    <img src="img/portfolio/p3.jpg" alt="title"/>
                                                    <div>
                                                        <a href="http://www.nationalpost.com/blockchain+come+street+will+street+board/17295905/story.html" target="_blank">Blockchain has come to Bay Street, but will Bay Street get on board?</a>
                                                        <span>April 16, 2018</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 webDesign websites">
                                                <div class="portfolio_single_content">
                                                    <img src="img/portfolio/p4.jpg" alt="title"/>
                                                    <div>
                                                        <a href="https://www.coindesk.com/crypto-blockchain-create-10-trillion-market-rbc-analyst-says/" target="_blank">RBC Report: Crypto and Blockchain Could Unlock $10 Trillion Market</a>
                                                        <span>January 3, 2018</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 appsDevelopment websites">
                                                <div class="portfolio_single_content">
                                                    <img src="img//portfolio/p5.jpg" alt="title"/>
                                                    <div>
                                                        <a href="https://www.theglobeandmail.com/report-on-business/omers-expands-cryptocurrency-presence-with-50-million-ethereum-public-company-offering/article37764394/" target="_blank">OMERS Expands Cryptocurrency Presence With $50-Million Ethereum Public Company Offering</a>
                                                        <span>January 29, 2018</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-4 GraphicDesign">
                                                <div class="portfolio_single_content">
                                                    <img src="img/portfolio/p6.jpg" alt="title"/>
                                                    <div>
                                                        <a href="http://business.financialpost.com/news/fp-street/from-blockchain-to-augmented-reality-canadas-big-banks-aim-to-patent-the-future-of-finance" target="_blank">From Blockchain to Augmented Reality, Canada's Big Banks Aim to Patent the Future of Finance</a>
                                                        <span>April 13, 2018</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End What else? -->

                
                
                
                
            <!-- Begin contact section -->
			<section id="contact-section" class="page text-white parallax" data-stellar-background-ratio="0.5" style="background-image: url(img/map-bg.jpg);">
            <div class="cover"></div>
            
                 <!-- Begin page header-->
                <div class="page-header-wrapper">
                    <div class="container">
                        <div class="page-header text-center wow fadeInDown" data-wow-delay="0.4s">
                            <h2>Contacts</h2>
                            <div class="devider"></div>
                            <p class="subtitle">How to Contact Us</p>
                        </div>
                    </div>
                </div>
                <!-- End page header-->
                
                <div class="contact wow bounceInRight" data-wow-delay="0.4s">
                    <div class="container">
                    	<div class="row">
                        
                            <div class="col-sm-12">
                                <div class="contact-info">
									<h4>Connect With Us Socially</h4>
									<ul class="social-list">
										<li> <a href="https://www.facebook.com/bitbizcrypto/" class="rotate-box-1 square-icon text-center wow zoomIn" target="_blank" data-wow-delay="0.3s"><span class="rotate-box-icon"><i class="fa fa-facebook"></i></span></a></li>
										<li> <a href="https://twitter.com/bitbizcrypto" class="rotate-box-1 square-icon text-center wow zoomIn" target="_blank" data-wow-delay="0.4s"><span class="rotate-box-icon"><i class="fa fa-twitter"></i></span></a></li>
										<li> <a href="https://www.instagram.com/Bitbizcrypto/" class="rotate-box-1 square-icon text-center wow zoomIn" target="_blank" data-wow-delay="0.5s"><span class="rotate-box-icon"><i class="fa fa-instagram"></i></span></a></li>                   
									</ul>
                                </div>
                            </div>
                        
                        	<!--div class="col-sm-6">
                                <div class="contact-form">
                                	<h4>Write to Us</h4>
                                    <form role="form">
                                        <div class="form-group">
                                            <input type="text" class="form-control input-lg" placeholder="Your Name" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control input-lg" placeholder="E-mail" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control input-lg" placeholder="Subject" required>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control input-lg" rows="5" placeholder="Message" required></textarea>
                                        </div>
                                        <button type="submit" class="btn wow bounceInRight" data-wow-delay="0.8s">Send</button>
                                    </form>
                                </div>	
                            </div-->
                                                                                
                        </div> <!-- /.row -->
                    </div> <!-- /.container -->
                </div>
            </section>
            <!-- End contact section -->
                
                
                
                
            <!-- Begin social section -->
			<!-- section id="social-section">
            
                 <!-- Begin page header>
                <div class="page-header-wrapper">
                    <div class="container">
                        <div class="page-header text-center wow fadeInDown" data-wow-delay="0.4s">
                            <h2>Join Us</h2>
                            <div class="devider"></div>
                            <p class="subtitle">Connect with us on social networks</p>
                        </div>
                    </div>
                </div>
                <!-- End page header >
                
                <div class="container">
                	<ul class="social-list">
                		<li> <a href="https://www.facebook.com/bitbizcrypto/" class="rotate-box-1 square-icon text-center wow zoomIn" target="_blank" data-wow-delay="0.3s"><span class="rotate-box-icon"><i class="fa fa-facebook"></i></span></a></li>
                		<li> <a href="https://twitter.com/bitbizcrypto" class="rotate-box-1 square-icon text-center wow zoomIn" target="_blank" data-wow-delay="0.4s"><span class="rotate-box-icon"><i class="fa fa-twitter"></i></span></a></li>
                		<li> <a href="#" class="rotate-box-1 square-icon text-center wow zoomIn" data-wow-delay="0.5s"><span class="rotate-box-icon"><i class="fa fa-instagram"></i></span></a></li>                   
                    </ul>
                </div>
                
            </section -->
            <!-- End social section -->                
                

                
            <!-- Begin footer --
            <footer class="text-off-white">
            
                <div class="footer-top">
                	<div class="container">
                    	<div class="row wow bounceInLeft" data-wow-delay="0.4s">

                            <div class="col-sm-6 col-md-4">
                            	<h4>Useful Links</h4>
                                <ul class="imp-links">
                                	<li><a href="">About</a></li>
                                	<li><a href="">Services</a></li>
                                	<li><a href="">Press</a></li>
                                	<li><a href="">Copyright</a></li>
                                	<li><a href="">Advertise</a></li>
                                	<li><a href="">Legal</a></li>
                                </ul>
                            </div>
                        
                        	<div class="col-sm-6 col-md-4">
                                <h4>Subscribe</h4>
                            	<div id="footer_signup">
                                    <div id="email">
                                        <form id="subscribe" method="POST">
                                            <input type="text" placeholder="Enter email address" name="email" id="address" data-validate="validate(required, email)"/>
                                            <button type="submit">Submit</button>
                                            <span id="result" class="section-description"></span>
                                        </form> 
                                    </div>
                                </div> 
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p> 
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <h4>Recent Tweets</h4>
                                <div class="single-tweet">
                                    <div class="tweet-content"><span>@Unika</span> Excepteur sint occaecat cupidatat non proident</div>
                                    <div class="tweet-date">1 Hour ago</div>
                                </div>
                                <div class="single-tweet">
                                    <div class="tweet-content"><span>@Unika</span> Excepteur sint occaecat cupidatat non proident uku shumaru</div>
                                    <div class="tweet-date">1 Hour ago</div>
                                </div>
                            </div>
                            
                        </div> <!-- /.row -->
                    </div> <!-- /.container -->
                </div>
                
            </footer>
            <!-- End footer -->

            <a href="#" class="scrolltotop"><i class="fa fa-arrow-up"></i></a> <!-- Scroll to top button -->
                                              
        </div><!-- body ends -->
        
        
        
        
        <!-- Plugins JS -->
		<script src="inc/jquery/jquery-1.11.1.min.js"></script>
		<script src="inc/bootstrap/js/bootstrap.min.js"></script>
		<script src="inc/owl-carousel/js/owl.carousel.min.js"></script>
		<script src="inc/stellar/js/jquery.stellar.min.js"></script>
		<script src="inc/animations/js/wow.min.js"></script>
        <script src="inc/waypoints.min.js"></script>
		<script src="inc/isotope.pkgd.min.js"></script>
		<script src="inc/classie.js"></script>
		<script src="inc/jquery.easing.min.js"></script>
		<script src="inc/jquery.counterup.min.js"></script>
		<script src="inc/smoothscroll.js"></script>

		<!-- Theme JS -->
		<script src="js/theme.js"></script>

    </body> 
        
            
</html>
