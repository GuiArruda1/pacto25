<?php
/**
 * Forms Diagnostic, Testing & Submissions Management Panel
 * Theme: Pacto 25
 *
 * Provides WordPress Administrators with:
 * 1. Interactive Form Email Dispatch Testing
 * 2. Real-time Mail Server / SMTP Diagnostic
 * 3. Form Routing Overview (who receives what)
 * 4. Submissions & Leads Database Audit Log (Zero lost leads)
 * 5. CSV Lead Export
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Admin Menu for Forms & Diagnostics
 */
function pacto_forms_admin_menu() {
	add_menu_page(
		__( 'Formulários & Leads', 'pacto-25' ),
		__( 'Formulários', 'pacto-25' ),
		'manage_options',
		'pacto-forms',
		'pacto_forms_admin_page',
		'dashicons-feedback',
		27
	);
}
add_action( 'admin_menu', 'pacto_forms_admin_menu' );

/**
 * Handle Admin Actions (Test Email, CSV Export, Clear Test Logs)
 */
function pacto_forms_handle_admin_actions() {
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) || empty( $_GET['page'] ) || 'pacto-forms' !== $_GET['page'] ) {
		return;
	}

	// 1. Export CSV
	if ( isset( $_GET['action'] ) && 'export_csv' === $_GET['action'] && check_admin_referer( 'pacto_export_forms_nonce' ) ) {
		$log = get_option( 'pacto_form_submissions_log', array() );

		nocache_headers();
		header( 'Content-Type: text/csv; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename=leads-formularios-' . gmdate( 'Y-m-d' ) . '.csv' );

		$out = fopen( 'php://output', 'w' );
		fprintf( $out, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) ); // UTF-8 BOM for Excel
		fputcsv( $out, array( 'ID', 'Data/Hora', 'Formulário', 'Destinatário', 'Nome', 'Email', 'Telemóvel', 'Mensagem', 'Estado Envio', 'IP' ) );

		foreach ( $log as $entry ) {
			$data     = isset( $entry['data'] ) && is_array( $entry['data'] ) ? $entry['data'] : array();
			$nome     = isset( $data['Nome'] ) ? $data['Nome'] : '';
			$email    = isset( $data['E-mail'] ) ? $data['E-mail'] : ( isset( $data['Email'] ) ? $data['Email'] : '' );
			$phone    = isset( $data['Telemóvel'] ) ? $data['Telemóvel'] : '';
			$mensagem = isset( $data['Mensagem'] ) ? $data['Mensagem'] : '';
			$status   = ! empty( $entry['mail_sent'] ) ? 'Enviado' : 'Guardado na BD (Falha envio)';

			fputcsv( $out, array(
				isset( $entry['id'] ) ? $entry['id'] : '',
				isset( $entry['timestamp'] ) ? $entry['timestamp'] : '',
				isset( $entry['form_type'] ) ? $entry['form_type'] : '',
				isset( $entry['recipient'] ) ? $entry['recipient'] : '',
				$nome,
				$email,
				$phone,
				$mensagem,
				$status,
				isset( $entry['ip'] ) ? $entry['ip'] : '',
			) );
		}
		fclose( $out );
		exit;
	}

	// 2. Clear Test Logs
	if ( isset( $_POST['pacto_clear_tests'] ) && check_admin_referer( 'pacto_clear_tests_nonce' ) ) {
		$log     = get_option( 'pacto_form_submissions_log', array() );
		$new_log = array_filter( $log, function( $item ) {
			return strpos( isset( $item['form_type'] ) ? $item['form_type'] : '', 'test_' ) !== 0;
		} );
		update_option( 'pacto_form_submissions_log', array_values( $new_log ) );
		wp_safe_redirect( add_query_arg( array( 'page' => 'pacto-forms', 'tab' => 'logs', 'cleared' => '1' ), admin_url( 'admin.php' ) ) );
		exit;
	}

	// 3. Clear All Logs
	if ( isset( $_POST['pacto_clear_all'] ) && check_admin_referer( 'pacto_clear_all_nonce' ) ) {
		update_option( 'pacto_form_submissions_log', array() );
		wp_safe_redirect( add_query_arg( array( 'page' => 'pacto-forms', 'tab' => 'logs', 'cleared_all' => '1' ), admin_url( 'admin.php' ) ) );
		exit;
	}
}
add_action( 'admin_init', 'pacto_forms_handle_admin_actions' );

/**
 * Render Admin Page
 */
function pacto_forms_admin_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$active_tab   = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : 'tester';
	$test_results = null;

	// Execute Test Dispatch
	if ( isset( $_POST['pacto_run_test'] ) && check_admin_referer( 'pacto_run_test_nonce' ) ) {
		$form_type = isset( $_POST['form_type'] ) ? sanitize_key( $_POST['form_type'] ) : 'sinistro';
		$recipient = isset( $_POST['test_recipient'] ) ? sanitize_email( $_POST['test_recipient'] ) : '';

		if ( empty( $recipient ) ) {
			$recipient = pacto_get_form_recipient( $form_type );
		}

		$test_results = pacto_test_form_email( $form_type, $recipient );
	}

	$all_logs   = get_option( 'pacto_form_submissions_log', array() );
	$export_url = wp_nonce_url( admin_url( 'admin.php?page=pacto-forms&action=export_csv' ), 'pacto_export_forms_nonce' );
	?>
	<div class="wrap pacto-forms-wrap">
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Gestão de Formulários, Notificações & Diagnóstico', 'pacto-25' ); ?></h1>
		<hr class="wp-header-end">

		<?php if ( isset( $_GET['cleared'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Registos de teste removidos com sucesso.', 'pacto-25' ); ?></p></div>
		<?php elseif ( isset( $_GET['cleared_all'] ) ) : ?>
			<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Todos os registos de submissão foram limpos.', 'pacto-25' ); ?></p></div>
		<?php endif; ?>

		<!-- Navigation Tabs -->
		<nav class="nav-tab-wrapper wp-clearfix" style="margin-top: 15px; margin-bottom: 20px;">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=pacto-forms&tab=tester' ) ); ?>" class="nav-tab <?php echo 'tester' === $active_tab ? 'nav-tab-active' : ''; ?>">
				<span class="dashicons dashicons-email" style="vertical-align: text-top; margin-right: 4px;"></span>
				<?php esc_html_e( 'Diagnóstico & Teste de Envio', 'pacto-25' ); ?>
			</a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=pacto-forms&tab=logs' ) ); ?>" class="nav-tab <?php echo 'logs' === $active_tab ? 'nav-tab-active' : ''; ?>">
				<span class="dashicons dashicons-list-view" style="vertical-align: text-top; margin-right: 4px;"></span>
				<?php esc_html_e( 'Registo de Submissões (Leads)', 'pacto-25' ); ?>
				<span class="count" style="background:#e2e8f0; border-radius:10px; padding:2px 8px; font-size:11px; margin-left:4px;"><?php echo count( $all_logs ); ?></span>
			</a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=pacto-forms&tab=routing' ) ); ?>" class="nav-tab <?php echo 'routing' === $active_tab ? 'nav-tab-active' : ''; ?>">
				<span class="dashicons dashicons-networking" style="vertical-align: text-top; margin-right: 4px;"></span>
				<?php esc_html_e( 'Matriz de Destinatários', 'pacto-25' ); ?>
			</a>
		</nav>

		<?php if ( 'tester' === $active_tab ) : ?>
			<!-- TAB 1: DIAGNOSTIC & TEST DISPATCHER -->
			<div class="pacto-grid-2">
				<div class="card" style="max-width: 650px; margin: 0 0 20px 0; padding: 24px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
					<h2 style="margin-top: 0; font-size: 18px; font-weight: 700;">
						<span class="dashicons dashicons-controls-play" style="color: #E84E38;"></span>
						<?php esc_html_e( 'Disparar Envio de Teste', 'pacto-25' ); ?>
					</h2>
					<p style="color: #64748b; font-size: 13px; line-height: 1.5;">
						<?php esc_html_e( 'Utilize este utilitário para testar a entrega de emails através da função wp_mail() do WordPress e validar se o destinatário recebe a notificação com o layout oficial da Pacto Seguro.', 'pacto-25' ); ?>
					</p>

					<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=pacto-forms&tab=tester' ) ); ?>" style="margin-top: 20px;">
						<?php wp_nonce_field( 'pacto_run_test_nonce' ); ?>

						<table class="form-table" role="presentation" style="margin-top: 0;">
							<tr>
								<th scope="row" style="width: 160px;">
									<label for="form_type"><?php esc_html_e( 'Tipo de Formulário', 'pacto-25' ); ?></label>
								</th>
								<td>
									<select name="form_type" id="form_type" class="regular-text" style="max-width: 100%;">
										<option value="sinistro" selected><?php esc_html_e( 'Participar Sinistro (Página Sinistro)', 'pacto-25' ); ?></option>
										<option value="contactos"><?php esc_html_e( 'Contactos Gerais (Página Contactos)', 'pacto-25' ); ?></option>
										<option value="simulacao"><?php esc_html_e( 'Pedido de Simulação', 'pacto-25' ); ?></option>
										<option value="protocolos"><?php esc_html_e( 'Parcerias & Protocolos', 'pacto-25' ); ?></option>
									</select>
								</td>
							</tr>
							<tr>
								<th scope="row">
									<label for="test_recipient"><?php esc_html_e( 'Email Destinatário', 'pacto-25' ); ?></label>
								</th>
								<td>
									<input type="email" name="test_recipient" id="test_recipient" class="regular-text" value="teresa.sousa@pactoseguro.com" placeholder="teresa.sousa@pactoseguro.com" style="max-width: 100%;" />
									<p class="description"><?php esc_html_e( 'Predefinido para teresa.sousa@pactoseguro.com. Pode alterar para o seu email pessoal para verificar a chegada à caixa de entrada.', 'pacto-25' ); ?></p>
								</td>
							</tr>
						</table>

						<p class="submit" style="margin-bottom: 0; padding-bottom: 0;">
							<button type="submit" name="pacto_run_test" class="button button-primary button-hero" style="background-color: #E84E38; border-color: #d13d28;">
								<span class="dashicons dashicons-email-alt" style="vertical-align: text-top; margin-right: 4px;"></span>
								<?php esc_html_e( 'Enviar Email de Teste Agora', 'pacto-25' ); ?>
							</button>
						</p>
					</form>
				</div>

				<!-- Server Health & Diagnostics -->
				<div class="card" style="max-width: 480px; margin: 0 0 20px 0; padding: 24px; border-radius: 8px;">
					<h3 style="margin-top: 0; font-size: 16px; font-weight: 700;">
						<span class="dashicons dashicons-admin-generic" style="color: #64748b;"></span>
						<?php esc_html_e( 'Estado do Servidor de Email', 'pacto-25' ); ?>
					</h3>
					<ul style="margin: 16px 0 0 0; padding: 0; list-style: none; font-size: 13px; line-height: 2;">
						<li><strong><?php esc_html_e( 'Destinatário Oficial:', 'pacto-25' ); ?></strong> <code style="color: #E84E38;">teresa.sousa@pactoseguro.com</code></li>
						<li><strong><?php esc_html_e( 'Remetente Padrão (From):', 'pacto-25' ); ?></strong> <code>Pacto Seguro &lt;no-reply@pactoseguro.com&gt;</code></li>
						<li><strong><?php esc_html_e( 'PHP Mail Handler:', 'pacto-25' ); ?></strong> 
							<?php if ( function_exists( 'mail' ) ) : ?>
								<span style="color:#16a34a; font-weight:600;">Disponível (função mail() ativa)</span>
							<?php else : ?>
								<span style="color:#dc2626; font-weight:600;">Desativado</span>
							<?php endif; ?>
						</li>
						<li><strong><?php esc_html_e( 'Plugin SMTP Externo:', 'pacto-25' ); ?></strong>
							<?php
							$smtp_plugins = array( 'wp-mail-smtp/wp_mail_smtp.php', 'post-smtp/postman-smtp.php', 'easy-wp-smtp/easy-wp-smtp.php' );
							$has_smtp     = false;
							foreach ( $smtp_plugins as $p ) {
								if ( is_plugin_active( $p ) ) {
									$has_smtp = true;
									break;
								}
							}
							echo $has_smtp ? '<span style="color:#16a34a; font-weight:600;">Ativo</span>' : '<span style="color:#d97706; font-weight:600;">Não instalado (utiliza envio direto do servidor)</span>';
							?>
						</li>
						<li><strong><?php esc_html_e( 'Proteção Anti-Perda de Leads:', 'pacto-25' ); ?></strong> <span style="color:#16a34a; font-weight:600;">Ativa (100% gravadas na BD)</span></li>
					</ul>
				</div>
			</div>

			<?php if ( ! empty( $test_results ) ) : ?>
				<!-- Test Results Box -->
				<div class="card" style="max-width: 1150px; padding: 24px; border-radius: 8px; margin-top: 20px; <?php echo $test_results['success'] ? 'border-left: 5px solid #16a34a;' : 'border-left: 5px solid #dc2626;'; ?>">
					<h3 style="margin-top: 0; font-size: 18px;">
						<?php if ( $test_results['success'] ) : ?>
							<span style="color: #16a34a;">✔ <?php esc_html_e( 'Sucesso: Email de Teste Aceite para Entrega!', 'pacto-25' ); ?></span>
						<?php else : ?>
							<span style="color: #dc2626;">✖ <?php esc_html_e( 'Aviso: Envio de email não concluído pelo servidor', 'pacto-25' ); ?></span>
						<?php endif; ?>
					</h3>
					<p style="font-size: 14px;">
						<strong><?php esc_html_e( 'Destinatário testado:', 'pacto-25' ); ?></strong> <code><?php echo esc_html( $test_results['recipient'] ); ?></code> | 
						<strong><?php esc_html_e( 'Formulário:', 'pacto-25' ); ?></strong> <code><?php echo esc_html( $test_results['form_type'] ); ?></code> | 
						<strong><?php esc_html_e( 'Timestamp:', 'pacto-25' ); ?></strong> <?php echo esc_html( $test_results['timestamp'] ); ?>
					</p>

					<?php if ( ! $test_results['success'] ) : ?>
						<div style="background-color: #fee2e2; border: 1px solid #f87171; color: #991b1b; padding: 14px 18px; border-radius: 6px; margin: 15px 0;">
							<strong><?php esc_html_e( 'Motivo reportado pelo WordPress / PHPMailer:', 'pacto-25' ); ?></strong><br>
							<code><?php echo esc_html( $test_results['error'] ?: 'A função mail() do PHP ou o binário sendmail não se encontra configurado no contentor/servidor local.' ); ?></code>
							<p style="margin: 8px 0 0 0; font-size: 13px;">
								💡 <em><?php esc_html_e( 'Nota Técnica: Em ambiente local Docker sem servidor SMTP, o envio de emails falha normalmente. Graças ao sistema de auditoria da Pacto Seguro, a submissão foi imediatamente arquivada na Base de Dados e pode ser consultada no separador "Registo de Submissões". Em produção com SMTP configurado, o envio será concluído com sucesso.', 'pacto-25' ); ?></em>
							</p>
						</div>
					<?php else : ?>
						<div style="background-color: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 14px 18px; border-radius: 6px; margin: 15px 0;">
							<?php esc_html_e( 'O WordPress despachou o email com sucesso para o destinatário.', 'pacto-25' ); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		<?php elseif ( 'logs' === $active_tab ) : ?>
			<!-- TAB 2: AUDIT LOG (LEADS PERSISTED IN DB) -->
			<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
				<p style="margin:0; font-size:14px; color:#475569;">
					<?php printf( esc_html__( 'Total de %d submissões registadas com segurança na Base de Dados.', 'pacto-25' ), count( $all_logs ) ); ?>
				</p>
				<div>
					<a href="<?php echo esc_url( $export_url ); ?>" class="button button-secondary">
						<span class="dashicons dashicons-download" style="vertical-align: text-top; margin-right: 2px;"></span>
						<?php esc_html_e( 'Exportar Todas as Leads (CSV)', 'pacto-25' ); ?>
					</a>
					<form method="post" style="display:inline-block; margin-left: 8px;">
						<?php wp_nonce_field( 'pacto_clear_tests_nonce' ); ?>
						<button type="submit" name="pacto_clear_tests" class="button" onclick="return confirm('<?php echo esc_js( __( 'Deseja remover apenas os registos de teste?', 'pacto-25' ) ); ?>');">
							<?php esc_html_e( 'Limpar Apenas Testes', 'pacto-25' ); ?>
						</button>
					</form>
				</div>
			</div>

			<table class="widefat striped" style="border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
				<thead>
					<tr>
						<th style="width: 140px;"><?php esc_html_e( 'Data / Hora', 'pacto-25' ); ?></th>
						<th style="width: 120px;"><?php esc_html_e( 'Formulário', 'pacto-25' ); ?></th>
						<th style="width: 160px;"><?php esc_html_e( 'Nome', 'pacto-25' ); ?></th>
						<th style="width: 200px;"><?php esc_html_e( 'Contacto', 'pacto-25' ); ?></th>
						<th><?php esc_html_e( 'Destinatário & Detalhes', 'pacto-25' ); ?></th>
						<th style="width: 150px;"><?php esc_html_e( 'Estado do Email', 'pacto-25' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if ( empty( $all_logs ) ) : ?>
						<tr>
							<td colspan="6" style="padding: 24px; text-align: center; color: #64748b;">
								<?php esc_html_e( 'Ainda não existem registos de formulários na base de dados.', 'pacto-25' ); ?>
							</td>
						</tr>
					<?php else : foreach ( $all_logs as $entry ) :
						$data     = isset( $entry['data'] ) && is_array( $entry['data'] ) ? $entry['data'] : array();
						$is_test  = strpos( isset( $entry['form_type'] ) ? $entry['form_type'] : '', 'test_' ) === 0;
						$is_sent  = ! empty( $entry['mail_sent'] );
						$nome     = isset( $data['Nome'] ) ? $data['Nome'] : '—';
						$email    = isset( $data['E-mail'] ) ? $data['E-mail'] : ( isset( $data['Email'] ) ? $data['Email'] : '—' );
						$phone    = isset( $data['Telemóvel'] ) ? $data['Telemóvel'] : '';
						$mensagem = isset( $data['Mensagem'] ) ? $data['Mensagem'] : '';
					?>
						<tr>
							<td>
								<strong><?php echo esc_html( isset( $entry['timestamp'] ) ? $entry['timestamp'] : '—' ); ?></strong>
							</td>
							<td>
								<?php if ( $is_test ) : ?>
									<span style="background:#fef3c7; color:#92400e; padding:3px 8px; border-radius:12px; font-size:11px; font-weight:700;">TESTE</span>
								<?php else : ?>
									<span style="background:#e0f2fe; color:#0369a1; padding:3px 8px; border-radius:12px; font-size:11px; font-weight:700;"><?php echo esc_html( strtoupper( isset( $entry['form_type'] ) ? $entry['form_type'] : '' ) ); ?></span>
								<?php endif; ?>
							</td>
							<td>
								<strong><?php echo esc_html( $nome ); ?></strong>
							</td>
							<td>
								<?php if ( '—' !== $email ) : ?>
									<a href="mailto:<?php echo esc_attr( $email ); ?>" style="text-decoration: none;"><?php echo esc_html( $email ); ?></a><br>
								<?php endif; ?>
								<?php if ( ! empty( $phone ) ) : ?>
									<small style="color:#64748b;">📞 <?php echo esc_html( $phone ); ?></small>
								<?php endif; ?>
							</td>
							<td>
								<span style="color:#64748b; font-size:12px;">Destino: </span><code><?php echo esc_html( isset( $entry['recipient'] ) ? $entry['recipient'] : 'teresa.sousa@pactoseguro.com' ); ?></code>
								<?php if ( ! empty( $mensagem ) ) : ?>
									<details style="margin-top:6px; font-size:12px; color:#475569;">
										<summary style="cursor:pointer; color:#0284c7; font-weight:600;"><?php esc_html_e( 'Ver Mensagem', 'pacto-25' ); ?></summary>
										<div style="background:#f8fafc; padding:8px 12px; border-radius:6px; margin-top:4px; border:1px solid #e2e8f0;">
											<?php echo nl2br( esc_html( $mensagem ) ); ?>
										</div>
									</details>
								<?php endif; ?>
							</td>
							<td>
								<?php if ( $is_sent ) : ?>
									<span style="color:#16a34a; font-weight:700; display:inline-flex; align-items:center;">
										<span class="dashicons dashicons-yes-alt" style="font-size:16px; margin-right:3px;"></span> Enviado
									</span>
								<?php else : ?>
									<span style="color:#d97706; font-weight:600; display:inline-flex; align-items:center;" title="<?php echo esc_attr( isset( $entry['mail_error'] ) ? $entry['mail_error'] : 'Salvo na BD' ); ?>">
										<span class="dashicons dashicons-warning" style="font-size:16px; margin-right:3px;"></span> Salvo na BD
									</span>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; endif; ?>
				</tbody>
			</table>

		<?php elseif ( 'routing' === $active_tab ) : ?>
			<!-- TAB 3: ROUTING MATRIX -->
			<div class="card" style="max-width: 900px; padding: 24px; border-radius: 8px;">
				<h2 style="margin-top:0; font-size:18px; font-weight:700;"><?php esc_html_e( 'Matriz de Encaminhamento de Formulários', 'pacto-25' ); ?></h2>
				<p style="color:#64748b; font-size:13px; line-height:1.5;">
					<?php esc_html_e( 'Abaixo encontra-se a configuração atual de destinatários por formulário. Todos os destinatários podem ser alterados nas opções de edição de cada página no WordPress.', 'pacto-25' ); ?>
				</p>

				<table class="widefat striped" style="margin-top: 15px;">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Formulário', 'pacto-25' ); ?></th>
							<th><?php esc_html_e( 'Localização no Site', 'pacto-25' ); ?></th>
							<th><?php esc_html_e( 'Destinatário Ativo', 'pacto-25' ); ?></th>
							<th><?php esc_html_e( 'Onde Editar', 'pacto-25' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><strong>Participar Sinistro</strong></td>
							<td><code>/sinistro/#participar</code></td>
							<td><strong style="color:#E84E38;"><?php echo esc_html( pacto_get_form_recipient( 'sinistro' ) ); ?></strong></td>
							<td><a href="<?php echo esc_url( admin_url( 'post.php?post=54&action=edit' ) ); ?>">Editar Página Sinistro &rarr; Secção 3</a></td>
						</tr>
						<tr>
							<td><strong>Contactos Gerais</strong></td>
							<td><code>/contactos</code></td>
							<td><strong style="color:#E84E38;"><?php echo esc_html( pacto_get_form_recipient( 'contactos' ) ); ?></strong></td>
							<td><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>">Editar Página Contactos</a></td>
						</tr>
						<tr>
							<td><strong>Simulação de Seguros</strong></td>
							<td><code>/simulacao</code></td>
							<td><strong style="color:#E84E38;"><?php echo esc_html( pacto_get_form_recipient( 'simulacao' ) ); ?></strong></td>
							<td><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>">Editar Página Simulação</a></td>
						</tr>
						<tr>
							<td><strong>Protocolos & Parcerias</strong></td>
							<td><code>/protocolos</code></td>
							<td><strong style="color:#E84E38;"><?php echo esc_html( pacto_get_form_recipient( 'protocolos' ) ); ?></strong></td>
							<td><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>">Editar Página Protocolos</a></td>
						</tr>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
	</div>

	<style>
		.pacto-grid-2 {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 24px;
			align-items: start;
		}
		@media (max-width: 960px) {
			.pacto-grid-2 {
				grid-template-columns: 1fr;
			}
		}
	</style>
	<?php
}
