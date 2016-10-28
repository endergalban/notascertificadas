<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Notas Certificadas</title>

    <!-- Bootstrap -->
    <link href="<?php echo site_url();?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo site_url();?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo site_url();?>vendors/nprogress/nprogress.css" rel="stylesheet">
 <!-- Datatables -->
    <link href="<?php echo site_url();?>/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo site_url();?>/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">

 <!-- Select2 -->
    <link href="<?php echo site_url();?>/vendors/select2/dist/css/select2.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo site_url();?>css/custom.min.css" rel="stylesheet">

    <script id="dsq-count-scr" src="//notascertificadas.disqus.com/count.js" async></script>
  </head>

  <body class="nav-md footer_fixed">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">

              <a href="index" class="site_title"><i class="fa fa-book"></i><span> N.Certificadas!</span></a>

            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="<?php echo  site_url(array('images','users',$miniatura));?>" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Bienvenido,</span>
                <h2><?php echo $nombre;?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
				<?php echo $menu;?>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Inicio" href="<?php echo site_url(array('user/index'));?>">
                <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Ayuda" href="<?php echo site_url(array('user/dasboard'));?>">
                <span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Perfil" href="<?php echo site_url(array('user/perfil'));?>">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Salir" href="<?php echo site_url(array('login','logout'));?>">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo site_url(array('images','users',$miniatura));?>" alt=""><?php echo $nombre;?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="<?php echo site_url(array('user/perfil'));?>"> Perfil</a></li>

                    <li><a href="javascript:;">Ayuda</a></li>
                    <li><a href="<?php echo site_url(array('login','logout'));?>"><i class="fa fa-sign-out pull-right"></i> Salir</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green"><?php echo count($datamensaje);?></span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
					<?php
						for($i=0;$i<count($datamensaje);$i++)
						{
							echo '<li>
								  <a href="Dialog"  class="open-Dialog" data-toggle="modal" data-titulo="'.$datamensaje[$i]['asunto'].'" data-mensaje="'.$datamensaje[$i]['mensaje'].'">
									<span class="image"><img src="'.site_url(array('images','users',$datamensaje[$i]['miniatura'])).'" /></span>
									<span>
										<span>&nbsp;</span>
									  <span class="time">'.$datamensaje[$i]['fechahora'].'</span>
									</span>
									<span class="message">
									 '.$datamensaje[$i]['asunto'].'
									</span>

								  </a>
								</li>';
						}
					?>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>ver todos</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><?php echo $nombrefuncion;?></h3>
              </div>

			<?php
				if($this->session->userdata('idtipousuario')==2){
					echo form_open(site_url(array('user','calificaciones','buscar')));
					$searchplace='estudiante';
				}else{
					echo form_open(site_url(array('user','usuarios','buscar')));
					$searchplace='email';
				}
			?>
              <div class="title_right">
                <div class="col-md-6 col-sm-6 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
						<input type="text" id="search" name="search" class="form-control" placeholder="Buscar <?php echo $searchplace;?>...">
						<span class="input-group-btn">
						  <button class="btn btn-default" type="submit" id="btnsearch" name="btnsearch">Buscar!</button>
						</span>
                  </div>
                </div>
              </div>
             </div>
            </form>


            <div class="clearfix"></div>
        <!-- /page content -->
