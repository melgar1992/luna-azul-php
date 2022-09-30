        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
        </div>
        </div>

        <!-- jQuery -->
        <script src="<?php echo base_url(); ?>application/assets/template/jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo base_url(); ?>application/assets/template/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url(); ?>application/assets/template/fastclick/fastclick.js"></script>
        <!-- NProgress -->
        <script src="<?php echo base_url(); ?>application/assets/template/nprogress/nprogress.js"></script>

        <!-- Custom Theme Scripts -->
        <script src="<?php echo base_url(); ?>application/assets/template/build/js/custom.min.js"></script>
        <input type="hidden" value="<?php echo base_url() ?>" id="base_url">

        <?php
        if (isset($pagina)) { ?>
          <script type="text/javascript" src="<?php echo base_url(); ?>application/assets/js/<?php echo $pagina; ?>.js"></script>
        <?php
        }
        ?>
        <script>
          let base_url = $("#base_url").val();

          function mayus(e) {
            e.value = e.value.toUpperCase();
          }
        </script>
        </body>

        </html>