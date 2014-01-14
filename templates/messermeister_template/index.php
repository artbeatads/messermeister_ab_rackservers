<?php  
/*------------------------------------------------------------------------
# author    The Brand Pool
# copyright Copyright © 2014 thebrandpool.com.au. All rights reserved.
-------------------------------------------------------------------------*/

defined( '_JEXEC' ) or die; 

// variables
$app = JFactory::getApplication();
$doc = JFactory::getDocument(); 
$params = &$app->getParams();
$pageclass = $params->get('pageclass_sfx');
$tpath = $this->baseurl.'/templates/'.$this->template;
$menu = $app->getMenu();

// load sheets and scripts
//$doc->addStyleSheet($tpath.'/css/template.css.php?v=1.0.0'); 
$doc->addStyleSheet('/templates/system/css/system.css'); 
$doc->addStyleSheet('/templates/system/css/general.css'); 

?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >

<head>

    <link rel="stylesheet" href="<?php echo $tpath; ?>/css/bootstrap.css">
    <script src="<?php echo $tpath; ?>/js/jquery-1.8.3.js"></script>
    <jdoc:include type="head" />
     <!--<meta name="viewport" content="width=device-width, initial-scale=1.0" /> mobile viewport -->
    <link rel="apple-touch-icon-precomposed" href="<?php echo $tpath; ?>/apple-touch-icon-57x57.png"> <!-- iphone, ipod, android -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $tpath; ?>/ico/apple-touch-icon-72x72.png"> <!-- ipad -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $tpath; ?>/ico/apple-touch-icon-114x114.png"> <!-- iphone retina -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $tpath; ?>/ico/apple-touch-icon-144x144.png"> <!-- iphone retina -->
    <link rel="shortcut icon" href="<?php echo $tpath; ?>/ico/favicon.ico">
    
    <link rel="stylesheet" href="<?php echo $tpath; ?>/css/template.css">
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <script type="text/javascript" src="<?php echo $tpath; ?>/js/browser_upgrade_notification.js"></script>
     
</head>

<body class="<?php echo $pageclass; ?> <?php if ($menu->getActive() == $menu->getDefault()) : ?>home<?php endif; ?> ">
	<div class="wrapper">
    
        <header>
            <div class="container">
                <img class="logo" src="<?php echo $tpath; ?>/images/messermeister_logo.gif" width="253" height="46" alt="Messermeister - The Knife for Life ">
                <nav class="product_nav">
                    <jdoc:include type="modules" name="product_nav" style="none" />
                </nav>
            </div> <!-- /container -->
        </header>
        
        
        <nav class="info_nav">
            <div class="container">
                <jdoc:include type="modules" name="info_nav" style="none" />
            </div><!--container-->
        </nav>
        
        <div class="content_wrapper">
        
        	<div class="breadcrumbs">
                <div class="container">
                    <jdoc:include type="modules" name="breadcrumbs" style="none" />
                </div><!--container-->
            </div><!--/breadcrumbs-->
        
            <div class="slideshow">
                <jdoc:include type="modules" name="slideshow" style="none" />
            </div><!--slideshow-->
            
    
            <section class="all_content">
            
            <?php if ($menu->getActive() == $menu->getDefault()) { ?>
            
                <article class="container promo">
                    <div class="row">
                    
                        <a class="span4 knives">
                            <jdoc:include type="modules" name="homepage_promo_knives" style="none" />
                        </a><!--span4-->
                        
                        <a class="span4 luggage">
                            <jdoc:include type="modules" name="homepage_promo_luggage" style="none" />
                        </a><!--span4-->
                        
                        <a class="span4 accessories">
                            <jdoc:include type="modules" name="homepage_promo_accessories" style="none" />
                        </a><!--span4-->
            
                    </div><!--row-->
                </article><!--/container-->
                
            <?php } else { ?>
                
                <article class="container main">
                    <jdoc:include type="message" />
                    <jdoc:include type="component" />
                </article><!--/container-->
                
            <?php } ?> 
                
            </section><!--all_content-->
            
            <jdoc:include type="modules" name="after_content" style="xhtml" />
                            
        </div><!--/content_wrapper-->

        <footer>
          
            <div class="container">
                <nav class="row">
                
                    <div class="span2">
                        <jdoc:include type="modules" name="footer_nav_col1" style="none" />
                    </div><!--span2-->
                    
                    <div class="span2">
                        <jdoc:include type="modules" name="footer_nav_col2" style="none" />
                    </div><!--span4-->
                    
                    <div class="span4">
                        <jdoc:include type="modules" name="footer_nav_col3" style="none" />
                    </div><!--span4-->
                    
                    <div class="span4">
                        <jdoc:include type="modules" name="footer_nav_col4" style="none" />
                    </div><!--span4-->
    
                </nav><!--row-->
            </div><!--container-->
            
        </footer>


	</div><!--wrapper--> 
</body>
</html>
