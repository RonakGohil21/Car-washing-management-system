<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
?>
<!DOCTYPE HTML>
<html>
<head>
<title>CWMS | Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<!-- Graph CSS -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<script src="js/jquery-2.1.4.min.js"></script>
<!-- //jQuery -->
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<!-- lined-icons -->
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
<!-- //lined-icons -->
<style>
:root {
    --metallic-blue: #2C3E50;
    --racing-red: #E74C3C;
    --chrome-silver: #BDC3C7;
    --garage-dark: #2C3E50;
    --neon-blue: #3498DB;
    --warning-yellow: #F1C40F;
    --success-green: #2ECC71;
}

body {
    font-family: 'Rajdhani', sans-serif;
    background: #1a1a1a;
    margin: 0;
    padding: 0;
    position: relative;
    overflow-x: hidden;
    color: #fff;
}

/* Racing Stripe Background */
body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: repeating-linear-gradient(
        45deg,
        #1a1a1a,
        #1a1a1a 10px,
        #222 10px,
        #222 20px
    );
    opacity: 0.1;
    z-index: -1;
}

.page-container {
    display: flex;
    min-height: 100vh;
}

.left-content {
    flex: 1;
    padding: 20px;
    margin-left: 250px;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    background: rgba(26, 26, 26, 0.95);
}

.sidebar {
    width: 250px;
    background: linear-gradient(135deg, var(--metallic-blue) 0%, #1a1a1a 100%);
    position: fixed;
    height: 100%;
    left: 0;
    top: 0;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1000;
    box-shadow: 4px 0 15px rgba(0,0,0,0.3);
}

.dashboard-header {
    background: linear-gradient(135deg, var(--metallic-blue) 0%, #1a1a1a 100%);
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
    animation: slideInDown 0.5s ease;
    border: 1px solid rgba(255,255,255,0.1);
}

.dashboard-header::after {
    content: '';
    position: absolute;
    top: 0;
    left: -150%;
    width: 200%;
    height: 100%;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255,255,255,0.1),
        transparent
    );
    animation: shine 3s infinite;
}

@keyframes shine {
    to {
        left: 100%;
    }
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
}

.stat-card {
    background: linear-gradient(145deg, #1a1a1a, #2c3e50);
    border-radius: 15px;
    padding: 25px;
    padding-right: 85px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    animation: fadeInUp 0.5s ease;
    border: 1px solid rgba(255,255,255,0.1);
    text-decoration: none;
}

.stat-card::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 2px;
    bottom: 0;
    left: 0;
    background: linear-gradient(90deg, var(--neon-blue), transparent);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.stat-card:hover::before {
    transform: scaleX(1);
}

.stat-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 35px rgba(0,0,0,0.3);
    background: linear-gradient(145deg, #2c3e50, #1a1a1a);
}

.stat-card .icon {
    font-size: 2.5rem;
    margin-bottom: 20px;
    color: var(--neon-blue);
    position: relative;
    z-index: 1;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.stat-card h3 {
    font-size: 1.1rem;
    color: var(--chrome-silver);
    margin: 0;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.stat-card h4 {
    font-size: 2.2rem;
    color: #fff;
    margin: 10px 0 0;
    font-weight: 700;
}

/* Speedometer Animation */
.speed-line {
    position: absolute;
    right: 0;
    bottom: 0;
    width: 50%;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--neon-blue));
    transform-origin: left;
    animation: speedLine 2s ease-in-out infinite;
}

@keyframes speedLine {
    0% { transform: scaleX(0); opacity: 0; }
    50% { transform: scaleX(1); opacity: 1; }
    100% { transform: scaleX(0); opacity: 0; }
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: var(--neon-blue);
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-item.active {
    color: var(--chrome-silver);
}

.chart-container {
    background: linear-gradient(145deg, #1a1a1a, #2c3e50);
    border-radius: 15px;
    padding: 25px;
    margin-top: 30px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    position: relative;
    overflow: hidden;
    animation: fadeInUp 0.7s ease;
    border: 1px solid rgba(255,255,255,0.1);
}

.washing-points-stats {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 20px;
}

.btn-primary {
    background: linear-gradient(45deg, var(--neon-blue), var(--metallic-blue));
    border: none;
    padding: 12px 30px;
    border-radius: 8px;
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-primary::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
        45deg,
        transparent,
        rgba(255,255,255,0.1),
        transparent
    );
    transform: rotate(45deg);
    animation: buttonShine 3s infinite;
}

@keyframes buttonShine {
    to {
        transform: rotate(45deg) translate(100%, 100%);
    }
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(52, 152, 219, 0.4);
}

/* Dashboard Stats Icons Animation */
.stat-card[href*="all-bookings"] .icon { color: var(--neon-blue); }
.stat-card[href*="new-booking"] .icon { color: var(--warning-yellow); }
.stat-card[href*="completed-booking"] .icon { color: var(--success-green); }
.stat-card[href*="manage-enquires"] .icon { color: var(--racing-red); }

/* Custom Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Gear Animation */
.gear-icon {
    position: absolute;
    right: 20px;
    top: 20px;
    font-size: 3rem;
    color: rgba(255,255,255,0.1);
    animation: spin 10s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Custom Logo Styles */
.card-logo {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 60px;
    height: 60px;
    opacity: 0.1;
    transition: all 0.3s ease;
}

.stat-card:hover .card-logo {
    opacity: 0.2;
    transform: scale(1.1);
}

/* Custom SVG Logos */
.logo-container {
    position: relative;
    margin-bottom: 20px;
}

.logo-container svg {
    width: 40px;
    height: 40px;
    fill: currentColor;
}

/* Service Point Badge */
.service-badge {
    display: inline-flex;
    align-items: center;
    background: rgba(52, 152, 219, 0.1);
    padding: 8px 15px;
    border-radius: 50px;
    margin-bottom: 20px;
}

.service-badge svg {
    width: 24px;
    height: 24px;
    margin-right: 10px;
    fill: var(--neon-blue);
}
</style>
</head> 
<body>
    <div class="page-container">
        <div class="left-content">
            <div class="mother-grid-inner">
                <?php include('includes/header.php');?>
                
                <div class="dashboard-header">
                    <i class="fas fa-cog gear-icon"></i>
                    <h1 class="h3 mb-0">Control Center</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>

                <div class="stats-grid">
                    <a href="all-bookings.php" class="stat-card">
                        <div class="speed-line"></div>
                        <svg class="card-logo" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12,18H6V14H12M21,14V12L20,7H4L3,12V14H4V18A2,2 0 0,0 6,20H12A2,2 0 0,0 14,18V14H19V18A2,2 0 0,0 21,20H23V14M10,6L11.5,5H17.5L19,6H10Z"/>
                            <circle fill="currentColor" cx="7" cy="15" r="2"/>
                            <circle fill="currentColor" cx="17" cy="15" r="2"/>
                        </svg>
                        <div class="logo-container">
                            <i class="fas fa-car-side"></i>
                        </div>
                        <h3>Total Bookings</h3>
                        <?php 
                        $sql = "SELECT id from tblcarwashbooking";
                        $query = $dbh -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $cnt=$query->rowCount();
                        ?>
                        <h4><?php echo htmlentities($cnt);?></h4>
                    </a>

                    <a href="new-booking.php" class="stat-card">
                        <div class="speed-line"></div>
                        <svg class="card-logo" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M19,19H5V8H19M16,1V3H8V1H6V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3H18V1M17,12H12V17H17V12Z"/>
                        </svg>
                        <div class="logo-container">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <h3>New Bookings</h3>
                        <?php 
                        $sql1 = "SELECT id from tblcarwashbooking where status='New'";
                        $query1 = $dbh -> prepare($sql1);
                        $query1->execute();
                        $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                        $newbookings=$query1->rowCount();
                        ?>
                        <h4><?php echo htmlentities($newbookings);?></h4>
                    </a>

                    <a href="completed-booking.php" class="stat-card">
                        <div class="speed-line"></div>
                        <svg class="card-logo" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M16.2,16.2L11,13V7H12.5V12.2L17,14.9L16.2,16.2Z"/>
                            <path fill="currentColor" d="M9.5,11.5L11,13L16,8L14.5,6.5L11,10L9.5,8.5L8,10L9.5,11.5Z"/>
                        </svg>
                        <div class="logo-container">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h3>Completed Bookings</h3>
                        <?php 
                        $sql3 = "SELECT id from tblcarwashbooking where status='Completed'";
                        $query3= $dbh -> prepare($sql3);
                        $query3->execute();
                        $results3=$query3->fetchAll(PDO::FETCH_OBJ);
                        $completedbookings=$query3->rowCount();
                        ?>
                        <h4><?php echo htmlentities($completedbookings);?></h4>
                    </a>

                    <a href="manage-enquires.php" class="stat-card">
                        <div class="speed-line"></div>
                        <svg class="card-logo" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4A2,2 0 0,0 20,2M20,16H6L4,18V4H20"/>
                            <path fill="currentColor" d="M7,9H17V7H7M7,13H17V11H7"/>
                        </svg>
                        <div class="logo-container">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3>Enquiries</h3>
                        <?php 
                        $sql2 = "SELECT id from tblenquiry";
                        $query2= $dbh -> prepare($sql2);
                        $query2->execute();
                        $results2=$query2->fetchAll(PDO::FETCH_OBJ);
                        $cnt2=$query2->rowCount();
                        ?>
                        <h4><?php echo htmlentities($cnt2);?></h4>
                    </a>
                </div>

                <div class="chart-container">
                    <svg class="card-logo" viewBox="0 0 24 24" style="top: 20px; right: 20px;">
                        <path fill="currentColor" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4M12,6A6,6 0 0,0 6,12A6,6 0 0,0 12,18A6,6 0 0,0 18,12A6,6 0 0,0 12,6M12,8A4,4 0 0,1 16,12A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8"/>
                    </svg>
                    <div class="service-badge">
                        <svg viewBox="0 0 24 24">
                            <path fill="currentColor" d="M22,17V19H14V17H22M12,17V19H4V17H12M22,13V15H4V13H22M22,9V11H14V9H22M12,9V11H4V9H12M22,5V7H4V5H22Z"/>
                        </svg>
                        <!-- <span>Service Center</span> -->
                    </div>
                    <h3>Service Points</h3>
                    <?php 
                    $sql5 = "SELECT id from tblwashingpoints";
                    $query5= $dbh -> prepare($sql5);
                    $query5->execute();
                    $results5=$query5->fetchAll(PDO::FETCH_OBJ);
                    $washingpoints=$query5->rowCount();
                    ?>
                    <div class="washing-points-stats">
                        <h4><?php echo htmlentities($washingpoints);?> Active Service Points</h4>
                        <a href="managecar-washingpoints.php" class="btn btn-primary">
                            <i class="fas fa-tools"></i> Manage Service Points
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php include('includes/sidebarmenu.php');?>
    </div>

    <!-- jQuery -->
    <script src="js/jquery-2.1.4.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function() {
        // Sidebar Toggle
        $(".sidebar-icon").click(function() {
            $(".page-container").toggleClass("sidebar-collapsed");
            
            if($(".page-container").hasClass("sidebar-collapsed")) {
                $(".left-content").css("margin-left", "70px");
            } else {
                $(".left-content").css("margin-left", "250px");
            }
        });

        // Add entrance animations to elements as they come into view
        function animateOnScroll() {
            $('.stat-card, .chart-container').each(function() {
                const elementTop = $(this).offset().top;
                const elementBottom = elementTop + $(this).outerHeight();
                const viewportTop = $(window).scrollTop();
                const viewportBottom = viewportTop + $(window).height();

                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $(this).addClass('animate__animated animate__fadeInUp');
                }
            });
        }

        // Run on scroll
        $(window).on('scroll', animateOnScroll);
        // Run on page load
        animateOnScroll();

        // Add logo animation
        $('.card-logo').each(function() {
            $(this).css({
                transform: 'rotate(' + (Math.random() * 20 - 10) + 'deg)'
            });
        });

        $('.stat-card').hover(function() {
            $(this).find('.card-logo').css({
                transform: 'rotate(0deg) scale(1.1)',
                opacity: '0.2'
            });
        }, function() {
            $(this).find('.card-logo').css({
                transform: 'rotate(' + (Math.random() * 20 - 10) + 'deg) scale(1)',
                opacity: '0.1'
            });
        });
    });
    </script>
</body>
</html>
<?php } ?>