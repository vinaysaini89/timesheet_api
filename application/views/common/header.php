<!DOCTYPE html>
<html>
  <head>
  <?php 
    if(!$this->lib_user->isLoggedIn())
    {
        redirect('login');
    }
  ?>
    <title>Employee Time Sheet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="<?php echo base_url();?>assets/css/styles.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
   

  </head>
  <body>
    <div class="header">
         <div class="container">
            <div class="row">
               <div class="col-md-6">
                  <!-- Logo -->
                  <div class="logo">
                     <h1><a href="/">Jindagi Live Digital Pvt Ltd</a></h1>
                  </div>
               </div>
               
               <div class="col-md-6">
                  <div class="navbar navbar-inverse" role="banner">
                      <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
                        <ul class="nav navbar-nav">
                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo ucwords($this->lib_user->fullName()); ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu animated fadeInUp">
                             
                              <li><a href="<?php echo site_url('logout');?>">Logout</a></li>
                            </ul>
                          </li>
                        </ul>
                      </nav>
                  </div>
               </div>
            </div>
         </div>
    </div>