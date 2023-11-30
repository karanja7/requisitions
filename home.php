<?php
session_start();
include('connection.php');

// Handle sign-out button click
if (isset($_POST['sign-out-btn'])) {
    // Destroy the session to log the user out
    session_destroy();
    // Redirect to the login page
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartREQ Dashboard | welcome</title>
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="home.css">
    <script src="loginscript.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
        <a href="home.php"><img src="images/smart REQ logo.png" alt="SmartREQ " class="logo"></a>
        <a href="home.php" ><ion-icon name="home-sharp">home</ion-icon></a>
        <nav> 
            <a href="#main" class="direct">About Us</a>
            <a href="#help-support" class="direct">Help & support</a>     
        </nav>
    </div>
    
    <div class="sidebar">
        <div class="user-info">
        <?php
        if (isset($_SESSION['username'])) {
            echo "You are logged in as: " . $_SESSION['username'];
        }
        ?>
        </div>
        <ul class="menu">
            <li>
                <a href="budgets.php"><ion-icon name="podium"></ion-icon> Budgets</a>
                <a href="requisitions.php"><ion-icon name="newspaper"></ion-icon></ion-icon> Requisitions</a>  
                <a href="myprofile.php"><ion-icon name="person-circle-sharp"></ion-icon> Profile</a>
                <a href="F.A.Qs.php"><ion-icon name="help-circle"></ion-icon> F.A.Qs</a>
                <a href="reports.php"><ion-icon name="settings"></ion-icon> Reports</a>
            </li>
        </ul>
        <form method="post">
            <button type="submit" id="sign-out-btn" name="sign-out-btn"> <ion-icon name="log-out"></ion-icon> Sign Out</button>
        </form>
        </div>
<!--main content-->

    <section id="showcase">
    <div class="home-main-content">
        <h1>A Requisitions and management system</h1>
        <p>SmartREQ is a revolutionary budgets and requisitions system that helps streamline the procurement process. Our intuitive system allows you to keep track of all of your spending, allowing for more accurate forecasting and better budget management. With SmartREQ, you can reduce paperwork, speed up processes, and simplify procurement, resulting in more time to focus on other important tasks.</p>
        </div>
    </section>

        <section id="boxes">
            <div class="container">
                <div class="box">
                    <a href="budgets.php"><img src="images/management.jpg" alt="Financial Management Dashboard"></a>
                    <h3>Financial Management Dashboard</h3>
                    <p>Our financial overview service provides detailed insight into your budgets, expenses, and requisitions in a formal tone.</p>

                </div>
                <div class="box">
                    <div class="overlay"></div>
                    <img src="images/assistance.jpg" alt="Budget and Requisition Management Assistance">
                    <h3>Reporting and analytical capabilities.</h3>
                    <p>The Help and Support section allowing organizations to generate detailed financial reports and analyze financial data.</p>

                </div>
                <div class="box">
                    <img src="images/tool.jpg" alt="Requisition Management Tool">
                    <h3>Requisition Management Tool</h3>
                    <p>To submit a new requisition, access the Requisitions Management section and follow the necessary steps. </p>

                </div>
            </div>
        </section>

        <section id="main">
            <div class="container">
                <article id="main-col">
                    <h1 class="page-title"> About Us</h1>
                    <p>
                    SmartREQ is a groundbreaking budgeting and requisitions solution that aids in the procurement process. Our simple system keeps track of all your expenditures, allowing for more accurate forecasting and better budget management.
                    </p>
                    <p class="dark">
                        We work with our clients to develop strategies that are tailored to their unique needs, allowing them to maximize their resources and achieve their goals. We also provide ongoing support and assistance throughout the process, making sure that our clients are able to get the most out of their budgets and requisition services. 
                    </p>
                </article>

                <aside id="sidebar">
                    <div class="dark">
                    <h3>what we do </h3>
                    <p>Our comprehensive financial management platform streamlines budget tracking and requisition processes, empowering businesses to make informed financial decisions and drive growth.</p>
                    </div>
                </aside>
                
            </div>
        </section>
        
    <section id="help-support">
        <h2>Help and Support</h2>
        <div class="contact-container">
            <div class="contact">
                <h3>Production Department</h3>
                <p>Contact: +254 789-456-345</p>
                <p>Email: production@SmartREQ.com</p>
            </div>
            <div class="contact">
                <h3>Tech Department</h3>
                <p>Contact: +254 790-456-345</p>
                <p>Email: tech@SmartREQ.com</p>
            </div>
            <div class="contact">
                <h3>Records Department</h3>
                <p>Contact: +254 792-456-345</p>
                <p>Email: records@SmartREQ.com</p>
            </div>
            <div class="contact">
                <h3>General Support</h3>
                <p>Contact: +254 794-456-345</p>
                <p>Email: SmartREQ.ac.ke</p>
            </div>
    </div>
    </section>


  <div class="footer">
        <a href="https://twitter.com" target="_blank"><ion-icon name="logo-twitter"></ion-icon></a>
        <a href="https://facebook.com" target="_blank"><ion-icon name="logo-facebook"></ion-icon></a>
        <a href="https://instagram.com" target="_blank"><ion-icon name="logo-instagram"></ion-icon></a>
    </div> 

    <footer>
            <div class="footer-wrapper">

                <div class="social-wrapper">
                    <div class='social-links'>
                        <ul>
                            <li>
                                <a href="#" title="Instagram">
                                    <img src="images/instagram.svg" alt='Instagram'>                       
                                </a>
                            </li>
                            <li>
                                <a href="#" title="Linkedin">
                                    <img src="images/linkedin.svg" alt='Linkedin'>
                                </a>
                            </li>
                            <li>
                                <a href="#" title="Twitter">
                                    <img src="images/twitter.svg" alt='Twitter'>
                                </a>
                            </li>
                            <li>
                                <a href="#" title="Youtube">
                                    <img src="images/youtube.svg" alt='YouTube'>
                                </a>
                            </li>
                            <li>
                                <a href="#" title="GitHub">
                                    <img src="images/github.svg" alt='GitHub'>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
              
                <div class="footer-columns">
                    <div class="footer-links">
                        <div class="footer-logo">
                            <svg width="1103" height="996" viewBox="0 0 1103 996" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M410.988 255.56L0 995.337H189.802L505.141 427.427L410.988 255.56ZM1102.94 995.337L647.119 170.373L551.471 0L457.317 170.373L551.471 340.746L711.79 629.718H498.683L405.461 786.972H799.034L914.634 995.337H1102.94Z" fill="#FAFBFC"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M410.988 255.56L0 995.337H189.802L505.141 427.427L410.988 255.56ZM1102.94 995.337L647.119 170.373L551.471 0L457.317 170.373L551.471 340.746L711.79 629.718H498.683L405.461 786.972H799.034L914.634 995.337H1102.94Z" fill="#FAFBFC"/>
                            </svg>
                        </div>
                        <section>
                            <h3>Product</h3>
                            <ul>
                                <li>
                                    <a href="#" title="API">API</a>
                                </li>
                                <li>
                                    <a href="#" title="Pricing">Pricing</a>
                                </li>
                                <li>
                                    <a href="#" title="Documentation">Documentation</a>
                                </li>
                                <li>
                                    <a href="#" title="Release Notes">Release Notes</a>
                                </li>
                                <li>
                                    <a href="#" title="Status">Status</a>
                                </li>
                            </ul>
                        </section>
                        <section>
                            <h3>Resources</h3>
                            <ul>
                                <li>
                                    <a href="#" title="Support">Support</a>
                                </li>
                                <li>
                                    <a href="#" title="Sitemap">Sitemap</a>
                                </li>
                                <li>
                                    <a href="#" title="Newsletter">Newsletter</a>
                                </li>
                                <li>
                                    <a href="#" title="Help Centre">Help Centre</a>
                                </li>
                                <li>
                                    <a href="#" title="Investor">Investor</a>
                                </li>
                            </ul>
                        </section>
                        <section>
                            <h3>Company</h3>
                            <ul>
                                <li>
                                    <a href="#" title="About Us">About Us</a>
                                </li>
                                <li>
                                    <a href="#" title="Blog">Blog</a>
                                </li>
                                <li>
                                    <a href="#" title="Careers">Careers</a>
                                </li>
                                <li>
                                    <a href="#" title="Press">Press</a>
                                </li>
                                <li>
                                    <a href="#" title="Contact">Contact</a>
                                </li>
                            </ul>
                        </section>
                        <section>
                            <h3>Legal</h3>
                            <ul>
                                <li>
                                    <a href="#" title="Terms and services">
                                        Terms
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Privacy Policy">
                                        Privacy
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Cookies">
                                        Cookies
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Licenses">
                                        Licenses
                                    </a>
                                </li>
                                <li>
                                    <a href="#" title="Cookies">
                                        Contact
                                    </a>
                                </li>
                            </ul>
                        </section>
                    </div>
                   
                </div>
                <div class="footer-bottom">
                    <div class="footer-description">
                        <h3>Streamline Your Procurement with SMART REQ</h3>
                        <p>Elevate your procurement process<p>
                    </div>
                    <small>© Smartreq co Ltd. <span id="year"></span>, All rights reserved</small>
                </div>
            </div>
        </footer>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>