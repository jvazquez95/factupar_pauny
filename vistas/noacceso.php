
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box box-solid">
                    <div class="box-body text-center" style="padding: 40px 20px;">
                      <div class="noacceso-icono" style="font-size: 72px; color: #dd4b39; margin-bottom: 20px;">
                        <i class="fa fa-lock"></i>
                      </div>
                      <h2 class="text-gray" style="margin: 0 0 10px;">Acceso no autorizado</h2>
                      <p class="text-muted" style="font-size: 16px; max-width: 480px; margin: 0 auto 24px; line-height: 1.5;">
                        Estimado/a <?php echo htmlspecialchars(isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'usuario'); ?>, no cuenta con los permisos necesarios para acceder a esta sección del sistema.
                      </p>
                      <p class="text-muted" style="font-size: 14px; margin-bottom: 24px;">
                        Si considera que debería tener acceso, contacte al administrador del sistema.
                      </p>
                      <a href="escritorio.php" class="btn btn-primary btn-lg"><i class="fa fa-home"></i> Volver al escritorio</a>
                    </div>
                  </div>
              </div>
          </div>
      </section>
    </div>
  <!--Fin-Contenido-->
