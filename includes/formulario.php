<?php global $apg_viacompras; ?>

<h3><a href="<?php echo $apg_viacompras['plugin_url']; ?>" title="<?php echo $apg_viacompras['plugin']; ?>" target="_blank"><?php echo $apg_viacompras['plugin']; ?></a></h3>
<p>
	<?php _e( 'Viacompras works by sending the user to Viacompras to enter their payment information.', 'wc-apg-viacompras-payment-gateway' ); ?>
</p> 
<?php include( 'cuadro-informacion.php' ); ?>
<div class="cabecera"> <a href="<?php echo $apg_viacompras['plugin_url']; ?>" title="<?php echo $apg_viacompras['plugin']; ?>" target="_blank"><img src="<?php echo plugins_url( '../assets/images/cabecera.jpg', __FILE__ ); ?>" class="imagen" alt="<?php echo $apg_viacompras['plugin']; ?>" /></a> </div>
<table class="form-table apg-table">
	<?php $this->generate_settings_html(); ?>
</table>
<!--/.form-table-->