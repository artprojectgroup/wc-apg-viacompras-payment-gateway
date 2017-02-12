<?php
/*
Plugin Name: WC - APG Viacompras payment gateway
Version: 0.1.2
Plugin URI: https://wordpress.org/plugins/wc-apg-viacompras-payment-gateway/
Description: Add Viacompras payment gateway to WooCommerce.
Author URI: https://artprojectgroup.es/
Author: Art Project Group
Requires at least: 3.8
Tested up to: 4.7.2

Text Domain: apg_viacompras
Domain Path: /languages

@package WC - APG Viacompras payment gateway
@category Core
@author Art Project Group
*/

//Igual no deberías poder abrirme
if ( !defined( 'ABSPATH' ) ) {
    exit();
}

//Definimos constantes
define( 'DIRECCION_apg_viacompras', plugin_basename( __FILE__ ) );

//Definimos las variables
$apg_viacompras = array(	
	'plugin' 		=> 'WC - APG Viacompras payment gateway', 
	'plugin_uri' 	=> 'wc-apg-viacompras-payment-gateway', 
	'donacion' 		=> 'https://artprojectgroup.es/tienda/donacion',
	'soporte' 		=> 'https://wcprojectgroup.es/tienda/ticket-de-soporte',
	'plugin_url' 	=> 'https://artprojectgroup.es/plugins-para-wordpress/plugins-para-woocommerce/wc-apg-viacompras-payment-gateway', 
	'ajustes' 		=> 'admin.php?page=wc-settings&tab=checkout&section=viacompras', 
	'puntuacion' 	=> 'https://wordpress.org/support/view/plugin-reviews/wc-apg-viacompras-payment-gateway'
);

//Carga el idioma
load_plugin_textdomain( 'apg_viacompras', null, dirname( DIRECCION_apg_viacompras ) . '/languages' );

//Enlaces adicionales personalizados
function apg_viacompras_enlaces( $enlaces, $archivo ) {
	global $apg_viacompras;

	if ( $archivo == DIRECCION_apg_viacompras ) {
		$plugin = apg_viacompras_plugin( $apg_viacompras['plugin_uri'] );
		$enlaces[] = '<a href="' . $apg_viacompras['donacion'] . '" target="_blank" title="' . __( 'Make a donation by ', 'apg_viacompras' ) . 'APG"><span class="genericon genericon-cart"></span></a>';
		$enlaces[] = '<a href="'. $apg_viacompras['plugin_url'] . '" target="_blank" title="' . $apg_viacompras['plugin'] . '"><strong class="artprojectgroup">APG</strong></a>';
		$enlaces[] = '<a href="https://www.facebook.com/artprojectgroup" title="' . __( 'Follow us on ', 'apg_viacompras' ) . 'Facebook" target="_blank"><span class="genericon genericon-facebook-alt"></span></a> <a href="https://twitter.com/artprojectgroup" title="' . __( 'Follow us on ', 'apg_viacompras' ) . 'Twitter" target="_blank"><span class="genericon genericon-twitter"></span></a> <a href="https://plus.google.com/+ArtProjectGroupES" title="' . __( 'Follow us on ', 'apg_viacompras' ) . 'Google+" target="_blank"><span class="genericon genericon-googleplus-alt"></span></a> <a href="http://es.linkedin.com/in/artprojectgroup" title="' . __( 'Follow us on ', 'apg_viacompras' ) . 'LinkedIn" target="_blank"><span class="genericon genericon-linkedin"></span></a>';
		$enlaces[] = '<a href="https://profiles.wordpress.org/artprojectgroup/" title="' . __( 'More plugins on ', 'apg_viacompras' ) . 'WordPress" target="_blank"><span class="genericon genericon-wordpress"></span></a>';
		$enlaces[] = '<a href="mailto:info@artprojectgroup.es" title="' . __( 'Contact with us by ', 'apg_viacompras' ) . 'e-mail"><span class="genericon genericon-mail"></span></a> <a href="skype:artprojectgroup" title="' . __( 'Contact with us by ', 'apg_viacompras' ) . 'Skype"><span class="genericon genericon-skype"></span></a>';
		$enlaces[] = apg_viacompras_plugin( $apg_viacompras['plugin_uri'] );
	}
	
	return $enlaces;
}
add_filter( 'plugin_row_meta', 'apg_viacompras_enlaces', 10, 2 );

//Añade el botón de configuración
function apg_viacompras_enlace_de_ajustes( $enlaces ) { 
	global $apg_viacompras;

	$enlaces_de_ajustes = array(
		'<a href="' . $apg_viacompras['ajustes'] . '" title="' . __( 'Settings of ', 'apg_viacompras' ) . $apg_viacompras['plugin'] .'">' . __( 'Settings', 'apg_viacompras' ) . '</a>', 
		'<a href="' . $apg_viacompras['soporte'] . '" title="' . __( 'Support of ', 'apg_viacompras' ) . $apg_viacompras['plugin'] .'">' . __( 'Support', 'apg_viacompras' ) . '</a>'
	);
	foreach ( $enlaces_de_ajustes as $enlace_de_ajustes ) {
		array_unshift( $enlaces, $enlace_de_ajustes );
	}
	
	return $enlaces; 
}
$plugin = DIRECCION_apg_viacompras; 
add_filter( "plugin_action_links_$plugin", 'apg_viacompras_enlace_de_ajustes' );

//¿Está activo WooCommerce?
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	/*
	Inicia el plugin
	*/
	function init_apg_viacompras() {
		//¿Existe la clase que controla los medios de pago?
	    if ( ! class_exists( 'WC_Payment_Gateway' ) ) { 
			return; 
		}
	    
		/*
		Añade el medio de pago
		*/
		class WC_Viacompras extends WC_Payment_Gateway {
			/*
			Inicia lu construcción
			*/
			public function __construct() {	
				$this->id					= 'viacompras';
				$this->icon 				= apply_filters( 'woocommerce_viacompras_icon', plugins_url( 'assets/images/viacompras.jpg' , __FILE__ ) );
				$this->url					= 'http://www.viacompras.com/pvv3reqeticket.asp';
				$this->method_title			= __( 'Viacompras', 'apg_viacompras' );
				$this->method_description	= __( 'Pay with credit card using Viacompras (Banco de Crédito BCP)', 'apg_viacompras' );
				$this->notify_url   		= WC()->api_request_url( 'WC_Viacompras' );
	                
				//Carga los campos del formulario
				$this->init_form_fields();
		
				//Carga la configuración actual
				$this->init_settings();
		
				//Define las variables
				$this->title				= $this->settings['title'];
				$this->description			= $this->settings['description'];
				$this->commerce_name		= $this->settings['commerce_name'];
		
				//Acciones
				add_action( 'woocommerce_receipt_viacompras', array( $this, 'apg_viacompras_pedido' ) );
				add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
				
				//Acción que gestiona la respuesta de Viacompras
				add_action( 'woocommerce_api_' . strtolower( get_class( $this ) ), array( $this, 'apg_viacompras_notificacion' ) );
		    }
		
			/*
			Formulario de configuración
			*/
			public function admin_options() {
				include( 'includes/formulario.php' );
		    }
		
		    /*
			Campos del formulario
			*/
		    public function init_form_fields() {
		    	$this->form_fields = array(
					'enabled'		=> array(
									'title'			=> __( 'Enable/Disable', 'apg_viacompras' ),
									'type'			=> 'checkbox',
									'label' 		=> __( 'Enable Viacompras', 'apg_viacompras' ),
									'default'		=> 'yes'
								),
					'commerce_name'	=> array(
									'title'			=> __( 'Commerce name', 'apg_viacompras' ),
									'type'			=> 'text',
									'description'	=> __( 'The commerce name.', 'apg_viacompras' ),
									'default'		=> __( 'Viacompras', 'apg_viacompras' )
								),
					'title'			=> array(
									'title'			=> __( 'Title', 'apg_viacompras' ),
									'type'			=> 'text',
									'description'	=> __( 'This controls the title which the user sees during checkout.', 'apg_viacompras' ),
									'default'		=> __( 'Viacompras', 'apg_viacompras' )
								),
					'description'	=> array(
									'title'			=> __( 'Description', 'apg_viacompras' ),
									'type'			=> 'textarea',
									'description'	=> __( 'This controls the description which the user sees during checkout.', 'apg_viacompras' ),
									'default'		=> __("Pay with your credit card via Viacompras", 'apg_viacompras')
								),
					);
		    }
		
			/*
			Genera los datos que se van a enviar a Viacompras
			*/
			public function apg_viacompras_dame_datos( $pedido ) {	
				if ( !get_option( 'wcj_order_number_sequential_enabled' ) || 'no' === get_option( 'wcj_order_number_sequential_enabled' ) ) {
					$numero_pedido = $pedido->id;
				} else { 
					$numero_pedido = get_post_meta( $pedido->id, '_wcj_order_number', true );
				}
						
				$importe = number_format( $pedido->get_total(), 2, ".", "" );
			
				// Viacompras Args
				$viacompras_args = array(
					'txtorderamount'			=> $importe,	
					'txtorderid'				=> str_pad( $numero_pedido, 4, '0', STR_PAD_LEFT ),
					'txtCommerceName'			=> $this->commerce_name,	
					'txturlresponse'			=> $this->notify_url,
				);
		
				return apply_filters( 'woocommerce_viacompras_args', $viacompras_args );
			}
		
		    /*
			Envía el pedido a Viacompras
			*/
		    public function apg_viacompras_pedido( $numero_pedido ) {	
				$pedido = new WC_Order( $numero_pedido );
				
				//Guarda una cookie con el número del pedido
        		setcookie( 'apg_viacompras', $numero_pedido, time() + 3600, COOKIEPATH, COOKIE_DOMAIN, false);
				
				//Muestra un mensaje en pantalla mientras terminamos el procesamiento del pedido
				echo '<p>' . __('Thank you for your order, please click the button below to pay with Viacompras.', 'apg_viacompras') . '</p>';
				
				//Obtiene los datos que tenemos que enviar		
				$viacompras_args = $this->apg_viacompras_dame_datos( $pedido );
		
				$viacompras_args_inputs = array();
				foreach ( $viacompras_args as $key => $value ) {
					$viacompras_args_inputs[] = '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '" />';
				}
		
				//Genera el JavaScript que enviará el formulario
				wc_enqueue_js( '
					jQuery( "body" ).block( {
							message: "<img src=\"' . esc_url( apply_filters( 'woocommerce_viacompras_icon', plugins_url( 'assets/images/viacompras.jpg' , __FILE__ ) ) ) . '\" alt=\"Redirecting&hellip;\" style=\"float:left; margin-right: 10px;\" />' . __('Thank you for your order. We are now redirecting you to Viacompras to make payment.', 'apg_viacompras') . '",
							overlayCSS: {
								background:			"#fff",
								opacity:			0.6
							},
							css: {
						        padding:        	20,
						        textAlign:      	"center",
						        color:          	"#555",
						        border:         	"3px solid #aaa",
						        backgroundColor:	"#fff",
						        cursor:         	"wait",
						        lineHeight:			"32px"
						    }
						} );
					jQuery( "#submit_viacompras_payment_form" ).click();
				' );
		
				//Genera el formulario
				echo '<form action="' . esc_url( $this->url ) . '" method="post" id="viacompras_payment_form" target="_top">
						' . implode( '', $viacompras_args_inputs ) . '
						<!-- Botón -->
						<div class="payment_buttons">
							<input type="submit" class="button-alt" id="submit_viacompras_payment_form" value="' . __('Pay via Viacompras', 'apg_viacompras').'" /> <a class="button cancel" href="' . esc_url( $pedido->get_cancel_order_url() ) . '">' . __('Cancel order &amp; restore cart', 'apg_viacompras') . '</a>
						</div>
						<script type="text/javascript">
							jQuery( ".payment_buttons" ).hide();
						</script>
					</form>';
		
			}
		
		    /*
			Procesa el pago y devuelve el resultado
			*/
			public function process_payment( $numero_pedido ) {
				$pedido = new WC_Order( $numero_pedido );
				
				return array(
					'result' 	=> 'success',
					'redirect'	=> $pedido->get_checkout_payment_url( true )
				);
			}
		
			/*
			Comprueba la respuesta de Viacompras
			*/
			public function apg_viacompras_notificacion() {				
				//Lee la cookie y obtenemos los datos del pedido
				$numero_pedido = $_COOKIE['apg_viacompras'];
				$pedido = new WC_Order( $numero_pedido );
				
				//Comprueba los datos enviados por Viacompras
			    if ( !empty( $_POST['oid'] ) && !empty( $_POST['cre'] ) ) {
					//Realiza algunas comprobaciones de seguridad
			        if ( $pedido->id != $numero_pedido ) {
			        	exit();
			        }
					if ( $pedido->status == 'completed' ) {
						exit();
					}				      

					//Comprueba el resultado de la operación
			        if ( $_POST['cre'] == "000" ) {	//Completada
						//Guarda los detalles del pedido
						if ( !empty( $_POST['sta'] ) ) {
							update_post_meta( $numero_pedido, 'Payment status', $_POST['sta'] );
						}
						if ( !empty( $_POST['eti'] ) ) {
							update_post_meta( $numero_pedido, 'Payment ticket', $_POST['eti'] );
						}
						if ( !empty( $_POST['pan'] ) ) {
							update_post_meta( $numero_pedido, 'Credit Card', $_POST['pan'] );
						}
						if ( !empty( $_POST['nth'] ) ) {
							update_post_meta( $numero_pedido, 'Credit Card owner', $_POST['nth'] );
						}

						//Marca el pedido como Procesando
						$pedido->add_order_note( __('Viacompras payment completed', 'apg_viacompras') );
						$pedido->payment_complete();
						wp_redirect( $this->get_return_url( $pedido ) ); 
						die( 'Proceso completado con éxito.' );
			        }
			    }
				//Marca el pedido como Fallido
			    $message = sprintf( __( 'Payment error: code: %s.', 'apg_viacompras' ), $_POST['cre'] );
				$pedido->update_status( 'failed', $message );
				wp_redirect( $pedido->get_cancel_order_url() );
				die( 'Proceso fallido.' );
			}
		}
	    
	    /*
		Añade el nuevo medio de pago
		*/
		function apg_viacompras_anade_pago( $metodos ) {
			$metodos[] = 'WC_Viacompras';
			
			return $metodos;
		}
		
		add_filter('woocommerce_payment_gateways', 'apg_viacompras_anade_pago' );
	}
	add_action( 'plugins_loaded', 'init_apg_viacompras', 0 );

	/*
	Carga las hojas de estilo
	*/
	function apg_viacompras_hojas_de_estilo() {
		//Carga la hoja de estilo
		wp_register_style( 'apg_viacompras_hoja_de_estilo', plugins_url( 'assets/css/style.css', __FILE__ ) );
		//Carga la hoja de estilo global
		wp_enqueue_style( 'apg_viacompras_hoja_de_estilo' ); 
	}
	add_action( 'admin_init', 'apg_viacompras_hojas_de_estilo' );

	/*
	Carga los scripts y CSS de WooCommerce
	*/
	function apg_viacompras_screen_id( $woocommerce_screen_ids ) {
		$woocommerce_screen_ids[] = 'woocommerce_page_apg_viacompras';

		return $woocommerce_screen_ids;
	}
	add_filter( 'woocommerce_screen_ids', 'apg_viacompras_screen_id' );
}

/*
Obtiene toda la información sobre el plugin
*/
function apg_viacompras_plugin( $nombre ) {
	global $apg_viacompras;

	$argumentos = ( object ) array( 
		'slug' => $nombre 
	);
	$consulta = array( 
		'action'	=> 'plugin_information', 
		'timeout'	=> 15, 
		'request'	=> serialize( $argumentos )
	);
	$respuesta = get_transient( 'apg_viacompras_plugin' );
	if ( false === $respuesta ) {
		$respuesta = wp_remote_post( 'http://api.wordpress.org/plugins/info/1.0/', array( 
			'body' => $consulta)
		);
		set_transient( 'apg_viacompras_plugin', $respuesta, 24 * HOUR_IN_SECONDS );
	}
	if ( !is_wp_error( $respuesta ) ) {
		$plugin = get_object_vars( unserialize( $respuesta['body'] ) );
	} else {
		$plugin['rating'] = 100;
	}
	
	$rating = array(
	   'rating'	=> $plugin['rating'],
	   'type'	=> 'percent',
	   'number'	=> $plugin['num_ratings'],
	);
	ob_start();
	wp_star_rating( $rating );
	$estrellas = ob_get_contents();
	ob_end_clean();

	return '<a title="' . sprintf( __( 'Please, rate %s:', 'apg_viacompras' ), $apg_viacompras['plugin'] ) . '" href="' . $apg_viacompras['puntuacion'] . '?rate=5#postform" class="estrellas">' . $estrellas . '</a>';
}

/*
Elimina todo rastro del plugin al desinstalarlo
*/
function apg_viacompras_desinstalar() {
	delete_transient( 'apg_viacompras_plugin' );
	delete_option( 'woocommerce_viacompras_settings' );
}
register_uninstall_hook( __FILE__, 'apg_viacompras_desinstalar' );
