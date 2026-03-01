<?php
/**
 * Plugin Name: VisionLED - Botón DeUna (QR popup) para Transferencia (BACS)
 * Description: Botón DeUna debajo de los detalles bancarios en pedido recibido (BACS) con popup QR.
 * Version: 1.0.3
 */

if (!defined('ABSPATH')) exit;

/* ===============================
   CONFIG
=================================*/
function vl_deuna_qr_url(){
  return 'https://www.visionled.com.ec/wp-content/uploads/2025/12/qrDeuna_001.jpg';
}

/* ===============================
   HTML BOTÓN + MODAL
=================================*/
function vl_deuna_modal_markup($context = 'bacs'){
  $url = vl_deuna_qr_url();
  if (!$url) return '';

  $id = 'vl-deuna-modal-' . sanitize_key($context);

  return '
  <div class="vl-deuna-wrap">
    <button type="button" class="vl-deuna-btn vl-deuna-open" data-target="'.$id.'">
      <i>DeUna</i>!
    </button>
  </div>

  <div id="'.$id.'" class="vl-deuna-modal" aria-hidden="true">
    <div class="vl-deuna-backdrop" data-close="1"></div>
    <div class="vl-deuna-dialog">
      <button class="vl-deuna-close" data-close="1">×</button>
      <img src="'.$url.'" alt="QR DeUna">
    </div>
  </div>';
}

/* =====================================================
   👇 HOOK CORRECTO (DESPUÉS DE DATOS BANCARIOS)
=====================================================*/
add_action('woocommerce_thankyou_bacs', function($order_id){
  if (!$order_id) return;
  echo vl_deuna_modal_markup('thankyou-bacs');
}, 15);

/* ===============================
   EMAILS (solo link)
=================================*/
add_action('woocommerce_email_before_order_table', function($order, $sent_to_admin, $plain){
  if ($sent_to_admin || !$order) return;
  if ($order->get_payment_method() !== 'bacs') return;

  $url = vl_deuna_qr_url();
  echo $plain
    ? "\nQR DeUna: $url\n"
    : '<p><strong>QR <i>DeUna!</i>:</strong> <a href="'.$url.'" target="_blank">Ver QR</a></p>';
}, 10, 3);

/* ===============================
   CSS + JS
=================================*/
add_action('wp_enqueue_scripts', function(){
  if (!is_checkout() && !is_order_received_page()) return;

  wp_add_inline_style('wp-block-library', '
    .vl-deuna-wrap{margin:15px 0}
    .vl-deuna-btn{
      background:#041E42;color:#fff;
      padding:10px 18px;border-radius:8px;
      border:0;font-weight:700;cursor:pointer
    }
    .vl-deuna-modal{display:none;position:fixed;inset:0;z-index:999999}
    .vl-deuna-modal.is-open{display:block}
    .vl-deuna-backdrop{position:absolute;inset:0;background:rgba(0,0,0,.65)}
    .vl-deuna-dialog{
      background:#fff;max-width:520px;
      margin:10vh auto;padding:15px;
      border-radius:12px;position:relative
    }
    .vl-deuna-dialog img{width:100%}
    .vl-deuna-close{
      position:absolute;top:6px;right:10px;
      font-size:26px;border:0;background:none;cursor:pointer
    }
  ');

  wp_add_inline_script('jquery', "
    document.addEventListener('click',function(e){
      if(e.target.closest('.vl-deuna-open')){
        document.getElementById(e.target.dataset.target).classList.add('is-open');
      }
      if(e.target.dataset.close){
        e.target.closest('.vl-deuna-modal').classList.remove('is-open');
      }
    });
  ");
});
#3F2A56

/*DeUna Styles*/
.vl-deuna-btn {
	background: #3F2A56;
}
.vl-deuna-dialog {
	margin-top: 10px;
}