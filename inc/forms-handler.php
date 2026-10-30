<?php
/**
 * Forms Processing, Routing & Email Notification System
 * Theme: Pacto 25
 *
 * Strict Agency SOP:
 * - Centralized form processing for Sinistro, Contactos, Simulação & Protocolos
 * - Fully configurable recipients (via ACF or filters), defaulting to teresa.sousa@pactoseguro.com
 * - Strict security: Nonce verification, honeypot anti-spam, and input sanitization
 * - Branded responsive HTML email templates with Reply-To headers
 * - Internal submissions audit log (persisted in DB so no lead is ever lost even if SMTP fails)
 * - Built-in testing tool and WP-CLI diagnostic support
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get the recipient email address for a given form type
 *
 * @param string   $form_type Form identifier (sinistro, contactos, simulacao, protocolos).
 * @param int|null $post_id   Optional post ID for page-specific overrides.
 * @return string Recipient email address.
 */
function pacto_get_form_recipient( $form_type = 'sinistro', $post_id = null ) {
	$target_id = $post_id ?: get_the_ID();
	$default   = 'teresa.sousa@pactoseguro.com';

	switch ( $form_type ) {
		case 'sinistro':
			$recipient = pacto_get_field( 'sinistro_form_recipient', $target_id, $default );
			break;
		case 'contactos':
			$recipient = pacto_get_field( 'contactos_hero_email', $target_id, $default );
			break;
		case 'simulacao':
			$recipient = pacto_get_field( 'seguro_form_recipient', $target_id, $default );
			break;
		case 'protocolos':
			$recipient = pacto_get_field( 'protocolos_form_recipient', $target_id, $default );
			break;
		default:
			$recipient = $default;
			break;
	}

	if ( empty( $recipient ) || ! is_email( $recipient ) ) {
		$recipient = $default;
	}

	/**
	 * Filters the recipient email for a specific form type.
	 *
	 * @param string $recipient Target email.
	 * @param int    $target_id Current post ID.
	 */
	$recipient = apply_filters( "pacto_form_recipient_{$form_type}", $recipient, $target_id );

	/**
	 * Filters any form recipient globally.
	 *
	 * @param string $recipient Target email.
	 * @param string $form_type Form identifier.
	 * @param int    $target_id Current post ID.
	 */
	return apply_filters( 'pacto_form_recipient', $recipient, $form_type, $target_id );
}

/**
 * Log a form submission into the database as a safety net
 *
 * @param string $form_type Form identifier.
 * @param array  $data      Sanitized payload.
 * @param string $recipient Target recipient.
 * @param bool   $sent      Whether wp_mail() succeeded.
 * @param string $error     Error message if any.
 * @return void
 */
function pacto_log_form_submission( $form_type, $data, $recipient, $sent = true, $error = '' ) {
	$log = get_option( 'pacto_form_submissions_log', array() );
	if ( ! is_array( $log ) ) {
		$log = array();
	}

	$entry = array(
		'id'         => uniqid( 'pacto_' . $form_type . '_', true ),
		'timestamp'  => current_time( 'mysql' ),
		'form_type'  => $form_type,
		'recipient'  => $recipient,
		'data'       => $data,
		'mail_sent'  => (bool) $sent,
		'mail_error' => $error,
		'ip'         => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
		'user_agent' => isset( $_SERVER['HTTP_USER_AGENT'] ) ? substr( sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ), 0, 255 ) : '',
	);

	// Prepend and keep latest 250 submissions
	array_unshift( $log, $entry );
	if ( count( $log ) > 250 ) {
		$log = array_slice( $log, 0, 250 );
	}

	update_option( 'pacto_form_submissions_log', $log, false );
}

/**
 * Build a clean, responsive HTML email template for form notifications
 *
 * @param string $title  Form / notification title.
 * @param array  $fields Associative array of [ 'Label' => 'Value' ].
 * @return string HTML email content.
 */
function pacto_build_html_email( $title, $fields ) {
	$site_title = get_bloginfo( 'name' );
	$site_url   = home_url();

	ob_start();
	?>
	<!DOCTYPE html>
	<html lang="pt">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo esc_html( $title ); ?></title>
	</head>
	<body style="margin:0; padding:0; background-color:#f1f5f9; font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color:#1e293b;">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9; padding:40px 16px;">
			<tr>
				<td align="center">
					<table width="600" border="0" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.08);">
						<!-- Header -->
						<tr>
							<td style="background-color:#E84E38; padding:32px 40px; text-align:center;">
								<h1 style="margin:0; font-size:24px; font-weight:700; color:#ffffff; letter-spacing:-0.5px;">
									Pacto Seguro
								</h1>
								<p style="margin:6px 0 0; font-size:13px; color:rgba(255,255,255,0.9); text-transform:uppercase; letter-spacing:1.5px;">
									<?php echo esc_html( $title ); ?>
								</p>
							</td>
						</tr>

						<!-- Body -->
						<tr>
							<td style="padding:36px 40px;">
								<p style="margin:0 0 20px; font-size:15px; line-height:1.6; color:#475569;">
									Foi recebida uma nova submissão através do website <strong><?php echo esc_html( $site_title ); ?></strong>:
								</p>

								<table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:28px;">
									<?php foreach ( $fields as $label => $value ) : ?>
										<tr>
											<td style="padding:12px 14px; border-bottom:1px solid #e2e8f0; font-size:13px; font-weight:700; color:#64748b; width:34%; vertical-align:top; background-color:#f8fafc;">
												<?php echo esc_html( $label ); ?>:
											</td>
											<td style="padding:12px 14px; border-bottom:1px solid #e2e8f0; font-size:14px; color:#0f172a; vertical-align:top;">
												<?php echo nl2br( esc_html( $value ) ); ?>
											</td>
										</tr>
									<?php endforeach; ?>
								</table>

								<?php if ( ! empty( $fields['E-mail'] ) ) : ?>
									<div style="text-align:center; margin-top:28px;">
										<a href="mailto:<?php echo esc_attr( $fields['E-mail'] ); ?>" style="display:inline-block; background-color:#231F20; color:#ffffff; text-decoration:none; padding:12px 28px; border-radius:9999px; font-size:14px; font-weight:600;">
											Responder a <?php echo esc_html( $fields['Nome'] ?? $fields['E-mail'] ); ?>
										</a>
									</div>
								<?php endif; ?>
							</td>
						</tr>

						<!-- Footer -->
						<tr>
							<td style="background-color:#f8fafc; padding:20px 40px; text-align:center; border-top:1px solid #e2e8f0; font-size:12px; color:#94a3b8;">
								<p style="margin:0 0 4px;">
									Mensagem gerada automaticamente pelo website <a href="<?php echo esc_url( $site_url ); ?>" style="color:#E84E38; text-decoration:none;"><?php echo esc_html( $site_url ); ?></a>.
								</p>
								<p style="margin:0;">
									Pacto Seguro — 25 Anos ao seu lado.
								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
	</html>
	<?php
	return ob_get_clean();
}

/**
 * Handle "Participar Sinistro" Form Submission (AJAX and Standard POST)
 */
function pacto_handle_sinistro_submission() {
	// 1. Verify Nonce
	$nonce = isset( $_POST['sinistro_form_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['sinistro_form_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'pacto_sinistro_form_action' ) ) {
		if ( wp_doing_ajax() ) {
			wp_send_json_error( array( 'message' => __( 'Sessão expirada. Por favor recarregue a página.', 'pacto-25' ) ), 403 );
		}
		wp_die( esc_html__( 'Sessão expirada. Por favor recarregue a página.', 'pacto-25' ) );
	}

	// 2. Honeypot check (Bots fill this, humans cannot see it)
	if ( ! empty( $_POST['sinistro_website'] ) ) {
		if ( wp_doing_ajax() ) {
			wp_send_json_success( array( 'message' => __( 'Participação enviada com sucesso.', 'pacto-25' ) ) );
		}
		wp_safe_redirect( add_query_arg( 'sinistro_status', 'success', wp_get_referer() ?: home_url( '/sinistro/#participar' ) ) );
		exit;
	}

	// 3. Sanitize inputs
	$nome      = isset( $_POST['nome'] ) ? sanitize_text_field( wp_unslash( $_POST['nome'] ) ) : '';
	$email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$telefone  = isset( $_POST['telefone'] ) ? sanitize_text_field( wp_unslash( $_POST['telefone'] ) ) : '';
	$tipo_raw  = isset( $_POST['tipo_sinistro'] ) ? sanitize_text_field( wp_unslash( $_POST['tipo_sinistro'] ) ) : '';
	$mensagem  = isset( $_POST['mensagem'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mensagem'] ) ) : '';
	$consent   = ! empty( $_POST['consent'] );

	// 4. Validate required fields
	if ( empty( $nome ) || empty( $email ) || ! is_email( $email ) || empty( $telefone ) ) {
		$error_msg = __( 'Por favor preencha todos os campos obrigatórios (nome, email e telemóvel).', 'pacto-25' );
		if ( wp_doing_ajax() ) {
			wp_send_json_error( array( 'message' => $error_msg ), 422 );
		}
		wp_safe_redirect( add_query_arg( 'sinistro_status', 'error_fields', wp_get_referer() ?: home_url( '/sinistro/#participar' ) ) );
		exit;
	}

	if ( ! $consent ) {
		$error_msg = __( 'Deve aceitar a Política de Privacidade para submeter a participação.', 'pacto-25' );
		if ( wp_doing_ajax() ) {
			wp_send_json_error( array( 'message' => $error_msg ), 422 );
		}
		wp_safe_redirect( add_query_arg( 'sinistro_status', 'error_consent', wp_get_referer() ?: home_url( '/sinistro/#participar' ) ) );
		exit;
	}

	// Friendly label for claim type
	$tipos_map = array(
		'automovel'    => 'Automóvel',
		'saude'        => 'Saúde',
		'multirriscos' => 'Multirriscos Casa',
		'acidentes'    => 'Acidentes Pessoais',
		'outro'        => 'Outro',
	);
	$tipo_label = $tipos_map[ $tipo_raw ] ?? ( ! empty( $tipo_raw ) ? ucfirst( $tipo_raw ) : 'Não especificado' );

	// 5. Determine Recipient (ACF override with fallback to teresa.sousa@pactoseguro.com)
	$page_id   = isset( $_POST['page_id'] ) ? absint( $_POST['page_id'] ) : get_queried_object_id();
	$recipient = pacto_get_form_recipient( 'sinistro', $page_id );

	// 6. Build and Send Email
	$subject = sprintf( '[Pacto Seguro] Nova Participação de Sinistro — %s (%s)', $nome, $tipo_label );
	$fields  = array(
		'Nome'             => $nome,
		'E-mail'           => $email,
		'Telemóvel'        => $telefone,
		'Tipo de Sinistro' => $tipo_label,
		'Mensagem'         => ! empty( $mensagem ) ? $mensagem : '(Sem mensagem adicional)',
		'Data e Hora'      => current_time( 'd/m/Y H:i' ),
	);

	$html_body = pacto_build_html_email( 'Participação de Sinistro', $fields );

	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		sprintf( 'From: Pacto Seguro <%s>', 'no-reply@pactoseguro.com' ),
		sprintf( 'Reply-To: %s <%s>', $nome, $email ),
	);

	// Capture errors if wp_mail fails
	$mail_error = '';
	add_action( 'wp_mail_failed', function( $wp_error ) use ( &$mail_error ) {
		if ( is_wp_error( $wp_error ) ) {
			$mail_error = $wp_error->get_error_message();
		}
	} );

	$sent = wp_mail( $recipient, $subject, $html_body, $headers );

	// 7. Safety Net Audit Log in Database
	pacto_log_form_submission( 'sinistro', $fields, $recipient, $sent, $mail_error );

	// 8. Custom success message from ACF
	$success_msg = pacto_get_field(
		'sinistro_form_success_message',
		$page_id,
		__( 'Obrigado! A sua participação de sinistro foi enviada com sucesso para a nossa equipa. Entraremos em contacto consigo com a máxima brevidade.', 'pacto-25' )
	);

	if ( wp_doing_ajax() ) {
		wp_send_json_success( array(
			'message'   => $success_msg,
			'recipient' => $recipient,
		) );
	}

	$redirect_url = add_query_arg( 'sinistro_status', 'success', wp_get_referer() ?: home_url( '/sinistro/#participar' ) );
	wp_safe_redirect( $redirect_url );
	exit;
}
add_action( 'wp_ajax_pacto_submit_sinistro', 'pacto_handle_sinistro_submission' );
add_action( 'wp_ajax_nopriv_pacto_submit_sinistro', 'pacto_handle_sinistro_submission' );
add_action( 'admin_post_pacto_submit_sinistro', 'pacto_handle_sinistro_submission' );
add_action( 'admin_post_nopriv_pacto_submit_sinistro', 'pacto_handle_sinistro_submission' );

/**
 * Enqueue Frontend Script for Form Submissions (AJAX enhancement)
 */
function pacto_enqueue_forms_client_script() {
	if ( ! is_page_template( 'page-sinistro.php' ) && ! is_page( 'sinistro' ) && ! is_page( 'contactos' ) && ! is_page_template( 'page-contactos.php' ) ) {
		return;
	}
	?>
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		var form = document.querySelector('.sinistro-claim-form');
		if (!form) return;

		var feedback = document.querySelector('.sinistro-form-feedback');
		var btn = form.querySelector('.sinistro-form-btn');
		var originalBtnText = btn ? btn.innerHTML : 'submeter';

		form.addEventListener('submit', function(e) {
			if (!window.fetch) return; // Fallback to normal POST

			e.preventDefault();

			if (feedback) {
				feedback.style.display = 'none';
				feedback.className = 'sinistro-form-feedback';
				feedback.innerHTML = '';
			}

			if (btn) {
				btn.disabled = true;
				btn.innerHTML = '<span>a enviar...</span>';
			}

			var formData = new FormData(form);
			formData.append('action', 'pacto_submit_sinistro');

			fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
				method: 'POST',
				body: formData
			})
			.then(function(res) { return res.json(); })
			.then(function(data) {
				if (btn) {
					btn.disabled = false;
					btn.innerHTML = originalBtnText;
				}
				if (feedback) {
					feedback.style.display = 'block';
					if (data.success) {
						feedback.className = 'sinistro-form-feedback sinistro-form-feedback--success';
						feedback.innerHTML = '<p>' + (data.data && data.data.message ? data.data.message : 'Participação enviada com sucesso!') + '</p>';
						form.reset();
					} else {
						feedback.className = 'sinistro-form-feedback sinistro-form-feedback--error';
						feedback.innerHTML = '<p>' + (data.data && data.data.message ? data.data.message : 'Ocorreu um erro ao enviar. Por favor tente novamente.') + '</p>';
					}
					feedback.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
				}
			})
			.catch(function(err) {
				if (btn) {
					btn.disabled = false;
					btn.innerHTML = originalBtnText;
				}
				if (feedback) {
					feedback.style.display = 'block';
					feedback.className = 'sinistro-form-feedback sinistro-form-feedback--error';
					feedback.innerHTML = '<p>Ocorreu um erro de ligação. Por favor tente novamente.</p>';
				}
			});
		});
	});
	</script>
	<style>
		.sinistro-form-feedback {
			border-radius: 12px;
			padding: 14px 18px;
			margin-bottom: 16px;
			font-size: 14px;
			line-height: 1.5;
			display: none;
		}
		.sinistro-form-feedback p { margin: 0; }
		.sinistro-form-feedback--success {
			background-color: rgba(255, 255, 255, 0.95);
			color: #15803d;
			border: 2px solid #86efac;
			box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
		}
		.sinistro-form-feedback--error {
			background-color: rgba(255, 255, 255, 0.95);
			color: #b91c1c;
			border: 2px solid #fca5a5;
		}
	</style>
	<?php
}
add_action( 'wp_footer', 'pacto_enqueue_forms_client_script', 30 );

/**
 * Diagnostic & Testing helper function
 *
 * Can be run via WP-CLI:
 * wp eval "pacto_test_form_email('sinistro', 'teresa.sousa@pactoseguro.com');"
 *
 * @param string $form_type Form identifier.
 * @param string $to        Target test recipient.
 * @return array Test results with status, recipient and log.
 */
function pacto_test_form_email( $form_type = 'sinistro', $to = '' ) {
	$recipient = ! empty( $to ) ? sanitize_email( $to ) : pacto_get_form_recipient( $form_type );

	$test_payload = array(
		'Nome'             => 'Teste Diagnóstico Antigravity',
		'E-mail'           => 'teste@pactoseguro.com',
		'Telemóvel'        => '912 345 678',
		'Tipo de Sinistro' => 'Automóvel (Teste)',
		'Mensagem'         => 'Este é um teste automático de verificação de entrega de emails para ' . $recipient . '.',
		'Data e Hora'      => current_time( 'd/m/Y H:i:s' ),
	);

	$subject   = sprintf( '[TESTE] Diagnóstico de Envio — Formulário %s', strtoupper( $form_type ) );
	$html_body = pacto_build_html_email( 'Teste de Diagnóstico de Formulário', $test_payload );

	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: Pacto Seguro <no-reply@pactoseguro.com>',
	);

	$mail_error = '';
	add_action( 'wp_mail_failed', function( $wp_error ) use ( &$mail_error ) {
		if ( is_wp_error( $wp_error ) ) {
			$mail_error = $wp_error->get_error_message();
		}
	} );

	$sent = wp_mail( $recipient, $subject, $html_body, $headers );

	pacto_log_form_submission( 'test_' . $form_type, $test_payload, $recipient, $sent, $mail_error );

	return array(
		'success'   => $sent,
		'recipient' => $recipient,
		'form_type' => $form_type,
		'error'     => $mail_error,
		'timestamp' => current_time( 'mysql' ),
	);
}
