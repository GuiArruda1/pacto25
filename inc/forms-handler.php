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
			$recipient = pacto_get_field( 'contactos_form_recipient', $target_id );
			if ( empty( $recipient ) ) {
				$recipient = pacto_get_field( 'contactos_hero_email', $target_id, $default );
			}
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
 * Persist lead / submission into database options audit log
 *
 * @param string $form_type  Form type (sinistro, contactos, simulacao, protocolos).
 * @param array  $fields     Submission data.
 * @param string $recipient  Target email.
 * @param bool   $sent       Whether wp_mail succeeded.
 * @param string $mail_error Any error message from PHPMailer.
 */
function pacto_log_form_submission( $form_type, $fields, $recipient, $sent = false, $mail_error = '' ) {
	$log_entry = array(
		'id'         => uniqid( 'pacto_' . sanitize_key( $form_type ) . '_', true ),
		'timestamp'  => current_time( 'mysql' ),
		'form_type'  => sanitize_key( $form_type ),
		'recipient'  => sanitize_email( $recipient ),
		'data'       => array_map( 'sanitize_text_field', $fields ),
		'mail_sent'  => (bool) $sent,
		'mail_error' => sanitize_text_field( $mail_error ),
		'ip'         => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '127.0.0.1',
		'user_agent' => isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : 'Unknown',
	);

	$existing_logs = get_option( 'pacto_form_submissions_log', array() );
	if ( ! is_array( $existing_logs ) ) {
		$existing_logs = array();
	}

	// Prepend new submission
	array_unshift( $existing_logs, $log_entry );

	// Keep last 250 entries to prevent option bloat
	if ( count( $existing_logs ) > 250 ) {
		$existing_logs = array_slice( $existing_logs, 0, 250 );
	}

	update_option( 'pacto_form_submissions_log', $existing_logs, false );
}

/**
 * Generate branded responsive HTML email template
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

								<div style="background-color:#f8fafc; border-left:4px solid #E84E38; padding:16px 20px; border-radius:4px; font-size:13px; color:#64748b; line-height:1.6;">
									<strong>Nota de Segurança:</strong> Esta mensagem foi gerada automaticamente pelo formulário oficial em <a href="<?php echo esc_url( $site_url ); ?>" style="color:#E84E38; text-decoration:none;"><?php echo esc_html( $site_url ); ?></a>. Pode responder diretamente a este email para contactar o cliente.
								</div>
							</td>
						</tr>

						<!-- Footer -->
						<tr>
							<td style="background-color:#0f172a; padding:24px 40px; text-align:center; font-size:12px; color:#94a3b8; line-height:1.6;">
								<p style="margin:0 0 4px;">
									© <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $site_title ); ?>. Todos os direitos reservados.
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
 * --------------------------------------------------------------------------
 * 1. FORM HANDLER: Participar Sinistro
 * --------------------------------------------------------------------------
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

	// 2. Honeypot check
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

	$tipos_map = array(
		'automovel'    => 'Automóvel',
		'saude'        => 'Saúde',
		'multirriscos' => 'Multirriscos Casa',
		'acidentes'    => 'Acidentes Pessoais',
		'outro'        => 'Outro',
	);
	$tipo_label = $tipos_map[ $tipo_raw ] ?? ( ! empty( $tipo_raw ) ? ucfirst( $tipo_raw ) : 'Não especificado' );

	$page_id   = isset( $_POST['page_id'] ) ? absint( $_POST['page_id'] ) : get_queried_object_id();
	$recipient = pacto_get_form_recipient( 'sinistro', $page_id );

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
	$headers   = array(
		'Content-Type: text/html; charset=UTF-8',
		sprintf( 'From: Pacto Seguro <%s>', 'no-reply@pactoseguro.com' ),
		sprintf( 'Reply-To: %s <%s>', $nome, $email ),
	);

	$mail_error = '';
	add_action( 'wp_mail_failed', function( $wp_error ) use ( &$mail_error ) {
		if ( is_wp_error( $wp_error ) ) {
			$mail_error = $wp_error->get_error_message();
		}
	} );

	$sent = wp_mail( $recipient, $subject, $html_body, $headers );
	pacto_log_form_submission( 'sinistro', $fields, $recipient, $sent, $mail_error );

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
 * --------------------------------------------------------------------------
 * 2. FORM HANDLER: Contactos Gerais
 * --------------------------------------------------------------------------
 */
function pacto_handle_contactos_submission() {
	// 1. Verify Nonce
	$nonce = isset( $_POST['contactos_form_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['contactos_form_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'pacto_contactos_form_action' ) ) {
		if ( wp_doing_ajax() ) {
			wp_send_json_error( array( 'message' => __( 'Sessão expirada. Por favor recarregue a página.', 'pacto-25' ) ), 403 );
		}
		wp_die( esc_html__( 'Sessão expirada. Por favor recarregue a página.', 'pacto-25' ) );
	}

	// 2. Honeypot check
	if ( ! empty( $_POST['contactos_website'] ) ) {
		if ( wp_doing_ajax() ) {
			wp_send_json_success( array( 'message' => __( 'Mensagem enviada com sucesso.', 'pacto-25' ) ) );
		}
		wp_safe_redirect( add_query_arg( 'contactos_status', 'success', wp_get_referer() ?: home_url( '/contactos/#formulario' ) ) );
		exit;
	}

	// 3. Sanitize inputs
	$nome      = isset( $_POST['nome'] ) ? sanitize_text_field( wp_unslash( $_POST['nome'] ) ) : '';
	$email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$telefone  = isset( $_POST['telemovel'] ) ? sanitize_text_field( wp_unslash( $_POST['telemovel'] ) ) : '';
	$assunto   = isset( $_POST['assunto'] ) ? sanitize_text_field( wp_unslash( $_POST['assunto'] ) ) : '';
	$mensagem  = isset( $_POST['mensagem'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mensagem'] ) ) : '';
	$consent   = ! empty( $_POST['consent'] );

	if ( empty( $nome ) || empty( $email ) || ! is_email( $email ) || empty( $telefone ) ) {
		$error_msg = __( 'Por favor preencha todos os campos obrigatórios (nome, email e telemóvel).', 'pacto-25' );
		if ( wp_doing_ajax() ) {
			wp_send_json_error( array( 'message' => $error_msg ), 422 );
		}
		wp_safe_redirect( add_query_arg( 'contactos_status', 'error_fields', wp_get_referer() ?: home_url( '/contactos/#formulario' ) ) );
		exit;
	}

	if ( ! $consent ) {
		$error_msg = __( 'Deve aceitar a Política de Privacidade para enviar a mensagem.', 'pacto-25' );
		if ( wp_doing_ajax() ) {
			wp_send_json_error( array( 'message' => $error_msg ), 422 );
		}
		wp_safe_redirect( add_query_arg( 'contactos_status', 'error_consent', wp_get_referer() ?: home_url( '/contactos/#formulario' ) ) );
		exit;
	}

	$assuntos_map = array(
		'geral'        => 'Informações Gerais',
		'particulares' => 'Seguros Particulares',
		'empresas'     => 'Seguros Empresas',
		'sinistros'    => 'Sinistros',
		'protocolos'   => 'Protocolos',
		'outro'        => 'Outro',
	);
	$assunto_label = $assuntos_map[ $assunto ] ?? ( ! empty( $assunto ) ? ucfirst( $assunto ) : 'Geral' );

	$page_id   = isset( $_POST['page_id'] ) ? absint( $_POST['page_id'] ) : get_queried_object_id();
	$recipient = pacto_get_form_recipient( 'contactos', $page_id );

	$subject = sprintf( '[Pacto Seguro] Novo Contacto Geral — %s (%s)', $nome, $assunto_label );
	$fields  = array(
		'Nome'        => $nome,
		'E-mail'      => $email,
		'Telemóvel'   => $telefone,
		'Assunto'     => $assunto_label,
		'Mensagem'    => ! empty( $mensagem ) ? $mensagem : '(Sem mensagem adicional)',
		'Data e Hora' => current_time( 'd/m/Y H:i' ),
	);

	$html_body = pacto_build_html_email( 'Contacto Geral do Website', $fields );
	$headers   = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: Pacto Seguro <no-reply@pactoseguro.com>',
		sprintf( 'Reply-To: %s <%s>', $nome, $email ),
	);

	$mail_error = '';
	add_action( 'wp_mail_failed', function( $wp_error ) use ( &$mail_error ) {
		if ( is_wp_error( $wp_error ) ) {
			$mail_error = $wp_error->get_error_message();
		}
	} );

	$sent = wp_mail( $recipient, $subject, $html_body, $headers );
	pacto_log_form_submission( 'contactos', $fields, $recipient, $sent, $mail_error );

	$success_msg = pacto_get_field(
		'contactos_form_success_message',
		$page_id,
		__( 'Obrigado pelo seu contacto! A sua mensagem foi enviada com sucesso para a nossa equipa. Entraremos em contacto consigo com a máxima brevidade.', 'pacto-25' )
	);

	if ( wp_doing_ajax() ) {
		wp_send_json_success( array(
			'message'   => $success_msg,
			'recipient' => $recipient,
		) );
	}

	$redirect_url = add_query_arg( 'contactos_status', 'success', wp_get_referer() ?: home_url( '/contactos/#formulario' ) );
	wp_safe_redirect( $redirect_url );
	exit;
}
add_action( 'wp_ajax_pacto_submit_contactos', 'pacto_handle_contactos_submission' );
add_action( 'wp_ajax_nopriv_pacto_submit_contactos', 'pacto_handle_contactos_submission' );
add_action( 'admin_post_pacto_submit_contactos', 'pacto_handle_contactos_submission' );
add_action( 'admin_post_nopriv_pacto_submit_contactos', 'pacto_handle_contactos_submission' );

/**
 * --------------------------------------------------------------------------
 * 3. FORM HANDLER: Pedido de Simulação de Seguros
 * --------------------------------------------------------------------------
 */
function pacto_handle_simulacao_submission() {
	// 1. Verify Nonce
	$nonce = isset( $_POST['seguro_simulacao_nonce_field'] ) ? sanitize_text_field( wp_unslash( $_POST['seguro_simulacao_nonce_field'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'pacto_simulacao_form_action' ) ) {
		if ( wp_doing_ajax() ) {
			wp_send_json_error( array( 'message' => __( 'Sessão expirada. Por favor recarregue a página.', 'pacto-25' ) ), 403 );
		}
		wp_die( esc_html__( 'Sessão expirada. Por favor recarregue a página.', 'pacto-25' ) );
	}

	// 2. Honeypot check
	if ( ! empty( $_POST['simulacao_website'] ) ) {
		if ( wp_doing_ajax() ) {
			wp_send_json_success( array( 'message' => __( 'Pedido de simulação enviado com sucesso.', 'pacto-25' ) ) );
		}
		wp_safe_redirect( add_query_arg( 'simulacao_status', 'success', wp_get_referer() ?: home_url( '#simulacao' ) ) );
		exit;
	}

	// 3. Sanitize inputs
	$nome         = isset( $_POST['nome'] ) ? sanitize_text_field( wp_unslash( $_POST['nome'] ) ) : '';
	$email        = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$telefone     = isset( $_POST['telemovel'] ) ? sanitize_text_field( wp_unslash( $_POST['telemovel'] ) ) : '';
	$seguro_nome  = isset( $_POST['seguro_nome'] ) ? sanitize_text_field( wp_unslash( $_POST['seguro_nome'] ) ) : 'Seguro';
	$mensagem     = isset( $_POST['mensagem'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mensagem'] ) ) : '';
	$consent      = ! empty( $_POST['privacy_consent'] );

	if ( empty( $nome ) || empty( $email ) || ! is_email( $email ) || empty( $telefone ) ) {
		$error_msg = __( 'Por favor preencha todos os campos obrigatórios (nome, email e telemóvel).', 'pacto-25' );
		if ( wp_doing_ajax() ) {
			wp_send_json_error( array( 'message' => $error_msg ), 422 );
		}
		wp_safe_redirect( add_query_arg( 'simulacao_status', 'error_fields', wp_get_referer() ?: home_url( '#simulacao' ) ) );
		exit;
	}

	if ( ! $consent ) {
		$error_msg = __( 'Deve aceitar a Política de Privacidade para submeter a simulação.', 'pacto-25' );
		if ( wp_doing_ajax() ) {
			wp_send_json_error( array( 'message' => $error_msg ), 422 );
		}
		wp_safe_redirect( add_query_arg( 'simulacao_status', 'error_consent', wp_get_referer() ?: home_url( '#simulacao' ) ) );
		exit;
	}

	$post_id   = isset( $_POST['post_id'] ) ? absint( $_POST['post_id'] ) : get_queried_object_id();
	$recipient = pacto_get_form_recipient( 'simulacao', $post_id );

	$subject = sprintf( '[Pacto Seguro] Novo Pedido de Simulação — %s (%s)', $seguro_nome, $nome );
	$fields  = array(
		'Seguro Pretendido' => $seguro_nome,
		'Nome'              => $nome,
		'E-mail'            => $email,
		'Telemóvel'         => $telefone,
		'Mensagem'          => ! empty( $mensagem ) ? $mensagem : '(Sem mensagem adicional)',
		'Data e Hora'       => current_time( 'd/m/Y H:i' ),
	);

	$html_body = pacto_build_html_email( 'Pedido de Simulação de Seguro', $fields );
	$headers   = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: Pacto Seguro <no-reply@pactoseguro.com>',
		sprintf( 'Reply-To: %s <%s>', $nome, $email ),
	);

	$mail_error = '';
	add_action( 'wp_mail_failed', function( $wp_error ) use ( &$mail_error ) {
		if ( is_wp_error( $wp_error ) ) {
			$mail_error = $wp_error->get_error_message();
		}
	} );

	$sent = wp_mail( $recipient, $subject, $html_body, $headers );
	pacto_log_form_submission( 'simulacao', $fields, $recipient, $sent, $mail_error );

	$success_msg = pacto_get_field(
		'seguro_form_success_message',
		$post_id,
		__( 'Obrigado! O seu pedido de simulação foi enviado com sucesso. Entraremos em contacto consigo com a máxima brevidade.', 'pacto-25' )
	);

	if ( wp_doing_ajax() ) {
		wp_send_json_success( array(
			'message'   => $success_msg,
			'recipient' => $recipient,
		) );
	}

	$redirect_url = add_query_arg( 'simulacao_status', 'success', wp_get_referer() ?: home_url( '#simulacao' ) );
	wp_safe_redirect( $redirect_url );
	exit;
}
add_action( 'wp_ajax_pacto_submit_simulacao', 'pacto_handle_simulacao_submission' );
add_action( 'wp_ajax_nopriv_pacto_submit_simulacao', 'pacto_handle_simulacao_submission' );
add_action( 'admin_post_pacto_submit_simulacao', 'pacto_handle_simulacao_submission' );
add_action( 'admin_post_nopriv_pacto_submit_simulacao', 'pacto_handle_simulacao_submission' );

/**
 * --------------------------------------------------------------------------
 * 4. FORM HANDLER: Protocolos e Parcerias
 * --------------------------------------------------------------------------
 */
function pacto_handle_protocolos_submission() {
	// 1. Verify Nonce
	$nonce = isset( $_POST['protocolos_form_nonce_field'] ) ? sanitize_text_field( wp_unslash( $_POST['protocolos_form_nonce_field'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'pacto_protocolos_form_action' ) ) {
		if ( wp_doing_ajax() ) {
			wp_send_json_error( array( 'message' => __( 'Sessão expirada. Por favor recarregue a página.', 'pacto-25' ) ), 403 );
		}
		wp_die( esc_html__( 'Sessão expirada. Por favor recarregue a página.', 'pacto-25' ) );
	}

	// 2. Honeypot check
	if ( ! empty( $_POST['protocolos_website'] ) ) {
		if ( wp_doing_ajax() ) {
			wp_send_json_success( array( 'message' => __( 'Pedido enviado com sucesso.', 'pacto-25' ) ) );
		}
		wp_safe_redirect( add_query_arg( 'protocolos_status', 'success', wp_get_referer() ?: home_url( '/protocolos/#formulario-protocolos' ) ) );
		exit;
	}

	// 3. Sanitize inputs
	$nome      = isset( $_POST['nome'] ) ? sanitize_text_field( wp_unslash( $_POST['nome'] ) ) : '';
	$email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$telefone  = isset( $_POST['telemovel'] ) ? sanitize_text_field( wp_unslash( $_POST['telemovel'] ) ) : '';
	$mensagem  = isset( $_POST['mensagem'] ) ? sanitize_textarea_field( wp_unslash( $_POST['mensagem'] ) ) : '';
	$consent   = ! empty( $_POST['privacy_consent'] );

	if ( empty( $nome ) || empty( $email ) || ! is_email( $email ) || empty( $telefone ) ) {
		$error_msg = __( 'Por favor preencha todos os campos obrigatórios (nome, email e telemóvel).', 'pacto-25' );
		if ( wp_doing_ajax() ) {
			wp_send_json_error( array( 'message' => $error_msg ), 422 );
		}
		wp_safe_redirect( add_query_arg( 'protocolos_status', 'error_fields', wp_get_referer() ?: home_url( '/protocolos/#formulario-protocolos' ) ) );
		exit;
	}

	if ( ! $consent ) {
		$error_msg = __( 'Deve aceitar a Política de Privacidade para submeter o pedido.', 'pacto-25' );
		if ( wp_doing_ajax() ) {
			wp_send_json_error( array( 'message' => $error_msg ), 422 );
		}
		wp_safe_redirect( add_query_arg( 'protocolos_status', 'error_consent', wp_get_referer() ?: home_url( '/protocolos/#formulario-protocolos' ) ) );
		exit;
	}

	$page_id   = isset( $_POST['page_id'] ) ? absint( $_POST['page_id'] ) : get_queried_object_id();
	$recipient = pacto_get_form_recipient( 'protocolos', $page_id );

	$subject = sprintf( '[Pacto Seguro] Pedido de Protocolo / Parceria — %s', $nome );
	$fields  = array(
		'Nome'        => $nome,
		'E-mail'      => $email,
		'Telemóvel'   => $telefone,
		'Mensagem'    => ! empty( $mensagem ) ? $mensagem : '(Sem mensagem adicional)',
		'Data e Hora' => current_time( 'd/m/Y H:i' ),
	);

	$html_body = pacto_build_html_email( 'Pedido de Protocolo & Parceria', $fields );
	$headers   = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: Pacto Seguro <no-reply@pactoseguro.com>',
		sprintf( 'Reply-To: %s <%s>', $nome, $email ),
	);

	$mail_error = '';
	add_action( 'wp_mail_failed', function( $wp_error ) use ( &$mail_error ) {
		if ( is_wp_error( $wp_error ) ) {
			$mail_error = $wp_error->get_error_message();
		}
	} );

	$sent = wp_mail( $recipient, $subject, $html_body, $headers );
	pacto_log_form_submission( 'protocolos', $fields, $recipient, $sent, $mail_error );

	$success_msg = pacto_get_field(
		'protocolos_form_success_message',
		$page_id,
		__( 'Obrigado! O seu pedido de informação sobre protocolos foi enviado com sucesso. Entraremos em contacto brevemente.', 'pacto-25' )
	);

	if ( wp_doing_ajax() ) {
		wp_send_json_success( array(
			'message'   => $success_msg,
			'recipient' => $recipient,
		) );
	}

	$redirect_url = add_query_arg( 'protocolos_status', 'success', wp_get_referer() ?: home_url( '/protocolos/#formulario-protocolos' ) );
	wp_safe_redirect( $redirect_url );
	exit;
}
add_action( 'wp_ajax_pacto_submit_protocolos', 'pacto_handle_protocolos_submission' );
add_action( 'wp_ajax_nopriv_pacto_submit_protocolos', 'pacto_handle_protocolos_submission' );
add_action( 'admin_post_pacto_submit_protocolos', 'pacto_handle_protocolos_submission' );
add_action( 'admin_post_nopriv_pacto_submit_protocolos', 'pacto_handle_protocolos_submission' );

/**
 * --------------------------------------------------------------------------
 * Universal Frontend Script for All Forms (AJAX enhancements + Fallbacks)
 * --------------------------------------------------------------------------
 */
function pacto_enqueue_forms_client_script() {
	?>
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		var formsConfig = [
			{ selector: '.sinistro-claim-form', action: 'pacto_submit_sinistro', feedbackSel: '.sinistro-form-feedback', btnSel: '.sinistro-form-btn' },
			{ selector: '.contactos-inquiry-form', action: 'pacto_submit_contactos', feedbackSel: '.contactos-form-feedback', btnSel: '.contactos-form-btn' },
			{ selector: '.seguro-simulacao-form', action: 'pacto_submit_simulacao', feedbackSel: '.seguro-form-feedback', btnSel: '.seguro-form-submit-btn' },
			{ selector: '.protocolos-form', action: 'pacto_submit_protocolos', feedbackSel: '.protocolos-form-feedback', btnSel: '.protocolos-form-btn' }
		];

		formsConfig.forEach(function(cfg) {
			var formEl = document.querySelector(cfg.selector);
			if (!formEl) return;

			var feedbackEl = document.querySelector(cfg.feedbackSel);
			var btnEl = formEl.querySelector(cfg.btnSel);
			var originalBtnText = btnEl ? btnEl.innerHTML : 'submeter';

			formEl.addEventListener('submit', function(e) {
				if (!window.fetch) return; // Fallback to normal POST

				e.preventDefault();

				if (feedbackEl) {
					feedbackEl.style.display = 'none';
					feedbackEl.className = 'pacto-form-feedback ' + cfg.feedbackSel.replace('.', '');
					feedbackEl.innerHTML = '';
				}

				if (btnEl) {
					btnEl.disabled = true;
					btnEl.innerHTML = '<span>a enviar...</span>';
				}

				var formData = new FormData(formEl);
				formData.append('action', cfg.action);

				fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {
					method: 'POST',
					body: formData
				})
				.then(function(res) { return res.json(); })
				.then(function(data) {
					if (btnEl) {
						btnEl.disabled = false;
						btnEl.innerHTML = originalBtnText;
					}
					if (feedbackEl) {
						feedbackEl.style.display = 'block';
						if (data.success) {
							feedbackEl.className = 'pacto-form-feedback pacto-form-feedback--success ' + cfg.feedbackSel.replace('.', '');
							feedbackEl.innerHTML = '<p>' + (data.data && data.data.message ? data.data.message : 'Mensagem enviada com sucesso!') + '</p>';
							formEl.reset();
						} else {
							feedbackEl.className = 'pacto-form-feedback pacto-form-feedback--error ' + cfg.feedbackSel.replace('.', '');
							feedbackEl.innerHTML = '<p>' + (data.data && data.data.message ? data.data.message : 'Ocorreu um erro ao enviar. Por favor tente novamente.') + '</p>';
						}
						feedbackEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
					}
				})
				.catch(function(err) {
					if (btnEl) {
						btnEl.disabled = false;
						btnEl.innerHTML = originalBtnText;
					}
					if (feedbackEl) {
						feedbackEl.style.display = 'block';
						feedbackEl.className = 'pacto-form-feedback pacto-form-feedback--error ' + cfg.feedbackSel.replace('.', '');
						feedbackEl.innerHTML = '<p>Ocorreu um erro de ligação. Por favor tente novamente.</p>';
					}
				});
			});
		});
	});
	</script>
	<style>
		.pacto-form-feedback,
		.sinistro-form-feedback,
		.contactos-form-feedback,
		.seguro-form-feedback,
		.protocolos-form-feedback {
			border-radius: 12px;
			padding: 14px 18px;
			margin-bottom: 18px;
			font-size: 14px;
			line-height: 1.5;
			display: none;
		}
		.pacto-form-feedback p,
		.sinistro-form-feedback p,
		.contactos-form-feedback p,
		.seguro-form-feedback p,
		.protocolos-form-feedback p { margin: 0; }
		.pacto-form-feedback--success {
			background-color: rgba(255, 255, 255, 0.95);
			color: #15803d;
			border: 2px solid #86efac;
			box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
		}
		.pacto-form-feedback--error {
			background-color: rgba(255, 255, 255, 0.95);
			color: #b91c1c;
			border: 2px solid #fca5a5;
			box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
		}
	</style>
	<?php
}
add_action( 'wp_footer', 'pacto_enqueue_forms_client_script', 30 );

/**
 * --------------------------------------------------------------------------
 * Diagnostic & Testing Helper (WP-CLI & Admin Tester)
 * --------------------------------------------------------------------------
 * Can be run via WP-CLI:
 * wp eval "pacto_test_form_email('contactos', 'teresa.sousa@pactoseguro.com');"
 *
 * @param string $form_type Form identifier (sinistro, contactos, simulacao, protocolos).
 * @param string $to        Target test recipient.
 * @return array Test results with status, recipient and log.
 */
function pacto_test_form_email( $form_type = 'sinistro', $to = '' ) {
	$recipient = ! empty( $to ) ? sanitize_email( $to ) : pacto_get_form_recipient( $form_type );

	switch ( $form_type ) {
		case 'sinistro':
			$title        = 'Participação de Sinistro (Diagnóstico)';
			$test_payload = array(
				'Nome'             => 'Teste Diagnóstico Antigravity',
				'E-mail'           => 'teste@pactoseguro.com',
				'Telemóvel'        => '912 345 678',
				'Tipo de Sinistro' => 'Automóvel (Teste)',
				'Mensagem'         => 'Este é um teste automático de verificação de entrega de emails para ' . $recipient . '.',
				'Data e Hora'      => current_time( 'd/m/Y H:i:s' ),
			);
			break;
		case 'contactos':
			$title        = 'Contacto Geral (Diagnóstico)';
			$test_payload = array(
				'Nome'        => 'Teste Diagnóstico Antigravity',
				'E-mail'      => 'teste@pactoseguro.com',
				'Telemóvel'   => '912 345 678',
				'Assunto'     => 'Informações Gerais (Teste)',
				'Mensagem'    => 'Este é um teste automático de formulário de contacto para ' . $recipient . '.',
				'Data e Hora' => current_time( 'd/m/Y H:i:s' ),
			);
			break;
		case 'simulacao':
			$title        = 'Pedido de Simulação (Diagnóstico)';
			$test_payload = array(
				'Seguro Pretendido' => 'Multirriscos Habitação (Teste)',
				'Nome'              => 'Teste Diagnóstico Antigravity',
				'E-mail'            => 'teste@pactoseguro.com',
				'Telemóvel'         => '912 345 678',
				'Mensagem'          => 'Este é um teste automático de pedido de simulação para ' . $recipient . '.',
				'Data e Hora'       => current_time( 'd/m/Y H:i:s' ),
			);
			break;
		case 'protocolos':
			$title        = 'Pedido de Protocolos (Diagnóstico)';
			$test_payload = array(
				'Nome'        => 'Teste Diagnóstico Antigravity',
				'E-mail'      => 'teste@pactoseguro.com',
				'Telemóvel'   => '912 345 678',
				'Mensagem'    => 'Este é um teste automático de pedido de protocolos para ' . $recipient . '.',
				'Data e Hora' => current_time( 'd/m/Y H:i:s' ),
			);
			break;
		default:
			$title        = 'Teste de Formulário (Diagnóstico)';
			$test_payload = array(
				'Nome'        => 'Teste Diagnóstico Antigravity',
				'E-mail'      => 'teste@pactoseguro.com',
				'Telemóvel'   => '912 345 678',
				'Mensagem'    => 'Este é um teste automático para ' . $recipient . '.',
				'Data e Hora' => current_time( 'd/m/Y H:i:s' ),
			);
			break;
	}

	$subject   = sprintf( '[TESTE] Diagnóstico de Envio — Formulário %s', strtoupper( $form_type ) );
	$html_body = pacto_build_html_email( $title, $test_payload );

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
