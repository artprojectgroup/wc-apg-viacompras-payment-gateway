<div class="informacion">
  <div class="fila">
    <div class="columna">
      <p>
        <?php _e( 'If you enjoyed and find helpful this plugin, please make a donation:', 'apg_viacompras' ); ?>
      </p>
      <p><a href="<?php echo $apg_viacompras['donacion']; ?>" target="_blank" title="<?php _e( 'Make a donation by ', 'apg_viacompras' ); ?>APG"><span class="genericon genericon-cart"></span></a></p>
    </div>
    <div class="columna">
      <p>Art Project Group:</p>
      <p><a href="http://www.artprojectgroup.es" title="Art Project Group" target="_blank"><strong class="artprojectgroup">APG</strong></a></p>
    </div>
  </div>
  <div class="fila">
    <div class="columna">
      <p>
        <?php _e( 'Follow us:', 'apg_viacompras' ); ?>
      </p>
      <p><a href="https://www.facebook.com/artprojectgroup" title="<?php _e( 'Follow us on ', 'apg_viacompras' ); ?>Facebook" target="_blank"><span class="genericon genericon-facebook-alt"></span></a> <a href="https://twitter.com/artprojectgroup" title="<?php _e( 'Follow us on ', 'apg_viacompras' ); ?>Twitter" target="_blank"><span class="genericon genericon-twitter"></span></a> <a href="https://plus.google.com/+ArtProjectGroupES" title="<?php _e( 'Follow us on ', 'apg_viacompras' ); ?>Google+" target="_blank"><span class="genericon genericon-googleplus-alt"></span></a> <a href="http://es.linkedin.com/in/artprojectgroup" title="<?php _e( 'Follow us on ', 'apg_viacompras' ); ?>LinkedIn" target="_blank"><span class="genericon genericon-linkedin"></span></a></p>
    </div>
    <div class="columna">
      <p>
        <?php _e( 'More plugins:', 'apg_viacompras' ); ?>
      </p>
      <p><a href="http://profiles.wordpress.org/artprojectgroup/" title="<?php _e( 'More plugins on ', 'apg_viacompras' ); ?>WordPress" target="_blank"><span class="genericon genericon-wordpress"></span></a></p>
    </div>
  </div>
  <div class="fila">
    <div class="columna">
      <p>
        <?php _e( 'Contact with us:', 'apg_viacompras' ); ?>
      </p>
      <p><a href="mailto:info@artprojectgroup.es" title="<?php _e( 'Contact with us by ', 'apg_viacompras' ); ?>e-mail"><span class="genericon genericon-mail"></span></a> <a href="skype:artprojectgroup" title="<?php _e( 'Contact with us by ', 'apg_viacompras' ); ?>Skype"><span class="genericon genericon-skype"></span></a></p>
    </div>
    <div class="columna">
      <p>
        <?php _e( 'Documentation and Support:', 'apg_viacompras' ); ?>
      </p>
      <p><a href="<?php echo $apg_viacompras['plugin_url']; ?>" title="<?php echo $apg_viacompras['plugin']; ?>"><span class="genericon genericon-book"></span></a> <a href="<?php echo $apg_viacompras['soporte']; ?>" title="<?php _e( 'Support', 'apg_viacompras' ); ?>"><span class="genericon genericon-cog"></span></a></p>
    </div>
  </div>
  <div class="fila final">
    <div class="columna">
      <p> <?php echo sprintf( __( 'Please, rate %s:', 'apg_viacompras' ), $apg_viacompras['plugin'] ); ?> </p>
      <?php echo apg_viacompras_plugin( $apg_viacompras['plugin_uri'] ); ?> </div>
    <div class="columna final"></div>
  </div>
</div>
