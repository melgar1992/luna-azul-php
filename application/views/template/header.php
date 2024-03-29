<!DOCTYPE html>
<?php
if (!$this->session->userdata('login')) {
  redirect(base_url() . 'inicio');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Gentelella Alela! | </title>

  <!-- Bootstrap -->
  <link href="<?php echo base_url(); ?>application/assets/template/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?php echo base_url(); ?>application/assets/template/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="<?php echo base_url(); ?>application/assets/template/nprogress/nprogress.css" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="<?php echo base_url(); ?>application/assets/template/build/css/custom.min.css" rel="stylesheet">
  <!-- Data Tables export -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/template/datatables-export/css/buttons.dataTables.min.css">
  <!-- DataTables-->
  <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/template/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/template/datatables.net-responsive-bs/css/responsive.bootstrap.min.css">
  <!-- DroopZone-->
  <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/template/dropzone/dist/min/dropzone.min.css">
  <!-- Estilos personales -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/app.css">


</head>