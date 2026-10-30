<?php
/**
 * Native WordPress Meta Box Repeaters for Seguros, Sinistro & Protocolos
 * Theme: Pacto 25
 *
 * Strict Agency Standard (wp-native-repeaters skill):
 * - 100% Core WordPress APIs (add_meta_box, wp.media, jquery-ui-sortable)
 * - Replaces fixed-slot numbered fields and ACF Pro repeaters with native sortable repeaters
 * - Deletes underscore-prefixed ACF reference keys on save to prevent PHP 8 TypeError
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper: Check if post is a Single Seguro or Modelo Seguro Landing Page
 *
 * @param WP_Post|null $post Post object.
 * @return bool
 */
function pacto_is_seguro_repeater_screen( $post ) {
	if ( ! $post instanceof WP_Post ) {
		return false;
	}
	if ( in_array( $post->post_type, array( 'seguro_particular', 'seguro_empresa' ), true ) ) {
		return true;
	}
	if ( 'page' === $post->post_type ) {
		$tpl = get_post_meta( $post->ID, '_wp_page_template', true );
		if ( 'page-landing.php' === $tpl || in_array( $post->post_name, array( 'landing', 'modelo-seguro' ), true ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Helper: Check if post is Em Caso de Sinistro page
 *
 * @param WP_Post|null $post Post object.
 * @return bool
 */
function pacto_is_sinistro_repeater_screen( $post ) {
	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return false;
	}
	$tpl = get_post_meta( $post->ID, '_wp_page_template', true );
	if ( 'page-sinistro.php' === $tpl || in_array( $post->post_name, array( 'sinistro', 'sinistros', 'em-caso-de-sinistro' ), true ) ) {
		return true;
	}
	return false;
}

/**
 * Helper: Check if post is Protocolos page
 *
 * @param WP_Post|null $post Post object.
 * @return bool
 */
function pacto_is_protocolos_repeater_screen( $post ) {
	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return false;
	}
	$tpl = get_post_meta( $post->ID, '_wp_page_template', true );
	if ( 'page-protocolos.php' === $tpl || in_array( $post->post_name, array( 'protocolos', 'protocolo' ), true ) ) {
		return true;
	}
	return false;
}

/**
 * Register Native Repeater Meta Boxes
 *
 * @param string       $post_type Current post type.
 * @param WP_Post|null $post      Current post object.
 */
function pacto_register_native_repeater_metaboxes( $post_type = '', $post = null ) {
	if ( ! $post instanceof WP_Post ) {
		$current_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : ( isset( $_POST['post_ID'] ) ? (int) $_POST['post_ID'] : 0 ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( $current_id ) {
			$post = get_post( $current_id );
		}
	}
	if ( ! $post instanceof WP_Post ) {
		return;
	}

	$screen_type = $post->post_type;

	if ( pacto_is_seguro_repeater_screen( $post ) ) {
		add_meta_box(
			'pacto_seguro_steps_repeater_metabox',
			__( '👣 Passos para Subscrição (Arrastar, Adicionar e Remover)', 'pacto-25' ),
			'pacto_render_seguro_steps_repeater_metabox',
			$screen_type,
			'normal',
			'high'
		);

		add_meta_box(
			'pacto_seguro_docs_repeater_metabox',
			__( '📄 Documentos Legais PDF (Arrastar, Adicionar e Remover)', 'pacto-25' ),
			'pacto_render_seguro_docs_repeater_metabox',
			$screen_type,
			'normal',
			'high'
		);

		add_meta_box(
			'pacto_seguro_faq_repeater_metabox',
			__( '❓ Questões Mais Frequentes — FAQs (Arrastar, Adicionar e Remover)', 'pacto-25' ),
			'pacto_render_seguro_faq_repeater_metabox',
			$screen_type,
			'normal',
			'high'
		);
	}

	if ( pacto_is_sinistro_repeater_screen( $post ) ) {
		add_meta_box(
			'pacto_sinistro_repeaters_metabox',
			__( '📋 Em Caso de Sinistro — Passos & Documentos Necessários PDF (Arrastar, Adicionar e Remover)', 'pacto-25' ),
			'pacto_render_sinistro_repeaters_metabox',
			$screen_type,
			'normal',
			'high'
		);

		add_meta_box(
			'pacto_seguro_faq_repeater_metabox',
			__( '❓ Questões Mais Frequentes — FAQs (Arrastar, Adicionar e Remover)', 'pacto-25' ),
			'pacto_render_seguro_faq_repeater_metabox',
			$screen_type,
			'normal',
			'high'
		);
	}

	if ( pacto_is_protocolos_repeater_screen( $post ) ) {
		add_meta_box(
			'pacto_protocolos_repeaters_metabox',
			__( '🏛️ Protocolos — Lista de Ordens/Associações & Vantagens (Arrastar, Adicionar e Remover)', 'pacto-25' ),
			'pacto_render_protocolos_repeaters_metabox',
			$screen_type,
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'pacto_register_native_repeater_metaboxes', 10, 2 );

/**
 * Enqueue Media and Sortable scripts on relevant edit screens
 *
 * @param string $hook Current admin page hook.
 */
function pacto_native_repeaters_admin_scripts( $hook ) {
	if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
		return;
	}
	wp_enqueue_media();
	wp_enqueue_script( 'jquery-ui-sortable' );
}
add_action( 'admin_enqueue_scripts', 'pacto_native_repeaters_admin_scripts' );

/**
 * Shared CSS & JS helper for Native Repeaters (rendered once per page)
 */
function pacto_render_native_repeaters_shared_assets() {
	static $rendered = false;
	if ( $rendered ) {
		return;
	}
	$rendered = true;
	?>
	<style>
		.pacto-nr-box { padding: 8px 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
		.pacto-nr-banner { background: #fff5f5; border-left: 4px solid #E84E38; padding: 10px 14px; margin-bottom: 14px; border-radius: 4px; font-size: 13px; color: #334155; }
		.pacto-nr-list { display: flex; flex-direction: column; gap: 12px; }
		.pacto-nr-item { background: #fff; border: 1px solid #cbd5e1; border-radius: 10px; padding: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
		.pacto-nr-item.ui-sortable-helper { box-shadow: 0 10px 25px rgba(0,0,0,0.15); border-color: #E84E38; }
		.pacto-nr-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; padding-bottom: 8px; border-bottom: 1px solid #f1f5f9; cursor: grab; }
		.pacto-nr-badge { background: #E84E38; color: #fff; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px; }
		.pacto-nr-remove { color: #dc2626; background: #fef2f2; border: 1px solid #fecaca; border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 600; cursor: pointer; }
		.pacto-nr-remove:hover { background: #dc2626; color: #fff; }
		.pacto-nr-grid-photo { display: grid; grid-template-columns: 110px 1fr; gap: 16px; align-items: start; }
		.pacto-nr-photo-circle { width: 84px; height: 84px; border-radius: 50%; border: 3px solid #E84E38; overflow: hidden; margin: 0 auto 8px; background: #f8fafc; display: flex; align-items: center; justify-content: center; }
		.pacto-nr-photo-circle img { width: 100%; height: 100%; object-fit: cover; display: block; }
		.pacto-nr-field { margin-bottom: 8px; }
		.pacto-nr-field label { display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 4px; }
		.pacto-nr-field input[type="text"], .pacto-nr-field textarea { width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 7px 10px; font-size: 13px; }
		.pacto-nr-file-row { display: flex; gap: 8px; align-items: center; }
		.pacto-nr-file-row input[type="text"] { flex: 1; }
		.pacto-nr-actions { margin-top: 14px; padding-top: 12px; border-top: 1px dashed #cbd5e1; display: flex; justify-content: space-between; align-items: center; }
	</style>
	<script>
	jQuery(document).ready(function($) {
		function reindexNrList($list) {
			var prefix = $list.data('prefix');
			var label  = $list.data('label') || 'Item';
			$list.find('.pacto-nr-item').each(function(idx) {
				var $item = $(this);
				$item.find('.pacto-nr-badge').text('☰ ' + label + ' #' + (idx + 1));
				$item.find('input, textarea, select').each(function() {
					var name = $(this).attr('name');
					if (name && prefix) {
						var regex = new RegExp(prefix + '\\[\\d+\\]');
						$(this).attr('name', name.replace(regex, prefix + '[' + idx + ']'));
					}
				});
			});
		}

		if ($.fn.sortable) {
			$('.pacto-nr-list').each(function() {
				var $list = $(this);
				$list.sortable({
					handle: '.pacto-nr-header',
					cursor: 'grabbing',
					opacity: 0.85,
					tolerance: 'pointer',
					update: function() {
						reindexNrList($list);
					}
				});
			});
		}

		// Add item
		$(document).on('click', '.pacto-nr-add-btn', function(e) {
			e.preventDefault();
			var targetList = $('#' + $(this).data('list'));
			var tplHtml    = $('#' + $(this).data('template')).html();
			var nextIdx    = targetList.find('.pacto-nr-item').length;
			var nextNum    = nextIdx + 1;
			tplHtml        = tplHtml.replace(/__INDEX__/g, nextIdx).replace(/__NUM__/g, nextNum);
			targetList.append(tplHtml);
			reindexNrList(targetList);
		});

		// Remove item
		$(document).on('click', '.pacto-nr-remove', function(e) {
			e.preventDefault();
			var $list = $(this).closest('.pacto-nr-list');
			if ($list.find('.pacto-nr-item').length <= 1) {
				alert('Deve manter pelo menos 1 item na lista.');
				return;
			}
			if (confirm('Tem a certeza que pretende remover este item?')) {
				$(this).closest('.pacto-nr-item').fadeOut(180, function() {
					$(this).remove();
					reindexNrList($list);
				});
			}
		});

		// Image picker for steps
		$(document).on('click', '.pacto-nr-img-btn', function(e) {
			e.preventDefault();
			var $item = $(this).closest('.pacto-nr-item');
			var frame = wp.media({
				title: 'Selecionar Foto Circular',
				button: { text: 'Usar esta foto' },
				multiple: false,
				library: { type: 'image' }
			});
			frame.on('select', function() {
				var att = frame.state().get('selection').first().toJSON();
				var url = att.sizes && att.sizes.medium ? att.sizes.medium.url : att.url;
				$item.find('.pacto-nr-img-url').val(url);
				$item.find('.pacto-nr-img-id').val(att.id);
				$item.find('.pacto-nr-photo-circle').html('<img src="' + url + '" alt="" />');
			});
			frame.open();
		});

		// File/PDF picker for documents
		$(document).on('click', '.pacto-nr-file-btn', function(e) {
			e.preventDefault();
			var $row = $(this).closest('.pacto-nr-file-row');
			var frame = wp.media({
				title: 'Selecionar Ficheiro PDF / Documento',
				button: { text: 'Usar este ficheiro' },
				multiple: false
			});
			frame.on('select', function() {
				var att = frame.state().get('selection').first().toJSON();
				$row.find('.pacto-nr-file-input').val(att.url);
			});
			frame.open();
		});
	});
	</script>
	<?php
}

/**
 * 1. Render Single Seguro Steps Repeater (`seguro_steps_list`)
 *
 * @param WP_Post $post Current post.
 */
function pacto_render_seguro_steps_repeater_metabox( $post ) {
	wp_nonce_field( 'pacto_native_repeaters_save', 'pacto_native_repeaters_nonce' );
	pacto_render_native_repeaters_shared_assets();

	$steps = get_post_meta( $post->ID, 'seguro_steps_list', true );
	if ( ! is_array( $steps ) || empty( $steps ) ) {
		$steps = array();
		for ( $i = 1; $i <= 3; $i++ ) {
			$t   = get_post_meta( $post->ID, "seguro_step_{$i}_title", true ) ?: "{$i}º Passo";
			$d   = get_post_meta( $post->ID, "seguro_step_{$i}_desc", true ) ?: 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.';
			$img = get_post_meta( $post->ID, "seguro_step_{$i}_image", true );
			$url = pacto_get_image_url( $img, 'medium', get_template_directory_uri() . "/assets/images/single-seguro/passos/passo-{$i}.png" );
			$steps[] = array(
				'title'       => $t,
				'description' => $d,
				'image'       => $url,
				'image_id'    => is_numeric( $img ) ? (int) $img : 0,
			);
		}
	}
	?>
	<div class="pacto-nr-box">
		<div class="pacto-nr-banner">
			<strong><?php esc_html_e( '👣 Passos para Subscrição:', 'pacto-25' ); ?></strong>
			<?php esc_html_e( 'Arraste os passos para reordenar, altere as fotos circulares ou adicione/remova passos.', 'pacto-25' ); ?>
		</div>

		<div class="pacto-nr-list" id="pacto-seguro-steps-list" data-prefix="pacto_seguro_steps" data-label="Passo">
			<?php foreach ( array_values( $steps ) as $idx => $step ) :
				$s_title = isset( $step['title'] ) ? $step['title'] : '';
				$s_desc  = isset( $step['description'] ) ? $step['description'] : '';
				$s_img   = ! empty( $step['image'] ) ? $step['image'] : get_template_directory_uri() . '/assets/images/single-seguro/passos/passo-' . ( ( $idx % 3 ) + 1 ) . '.png';
				$s_id    = isset( $step['image_id'] ) ? (int) $step['image_id'] : 0;
			?>
				<div class="pacto-nr-item">
					<div class="pacto-nr-header">
						<span class="pacto-nr-badge">☰ <?php echo esc_html( sprintf( __( 'Passo #%d', 'pacto-25' ), $idx + 1 ) ); ?></span>
						<button type="button" class="pacto-nr-remove">✕ <?php esc_html_e( 'Remover', 'pacto-25' ); ?></button>
					</div>
					<div class="pacto-nr-grid-photo">
						<div style="text-align:center;">
							<div class="pacto-nr-photo-circle">
								<img src="<?php echo esc_url( $s_img ); ?>" alt="" />
							</div>
							<input type="hidden" class="pacto-nr-img-url" name="pacto_seguro_steps[<?php echo esc_attr( $idx ); ?>][image]" value="<?php echo esc_attr( $s_img ); ?>" />
							<input type="hidden" class="pacto-nr-img-id" name="pacto_seguro_steps[<?php echo esc_attr( $idx ); ?>][image_id]" value="<?php echo esc_attr( $s_id ); ?>" />
							<button type="button" class="button button-small pacto-nr-img-btn"><?php esc_html_e( 'Escolher Foto', 'pacto-25' ); ?></button>
						</div>
						<div>
							<div class="pacto-nr-field">
								<label><?php esc_html_e( 'Título do Passo', 'pacto-25' ); ?></label>
								<input type="text" name="pacto_seguro_steps[<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $s_title ); ?>" />
							</div>
							<div class="pacto-nr-field" style="margin-bottom:0;">
								<label><?php esc_html_e( 'Descrição do Passo', 'pacto-25' ); ?></label>
								<textarea name="pacto_seguro_steps[<?php echo esc_attr( $idx ); ?>][description]" rows="2"><?php echo esc_textarea( $s_desc ); ?></textarea>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="pacto-nr-actions">
			<button type="button" class="button button-primary pacto-nr-add-btn" data-list="pacto-seguro-steps-list" data-template="pacto-seguro-step-tpl">
				+ <?php esc_html_e( 'Adicionar Passo', 'pacto-25' ); ?>
			</button>
		</div>

		<script type="text/html" id="pacto-seguro-step-tpl">
			<div class="pacto-nr-item">
				<div class="pacto-nr-header">
					<span class="pacto-nr-badge">☰ Passo #__NUM__</span>
					<button type="button" class="pacto-nr-remove">✕ <?php esc_html_e( 'Remover', 'pacto-25' ); ?></button>
				</div>
				<div class="pacto-nr-grid-photo">
					<div style="text-align:center;">
						<div class="pacto-nr-photo-circle">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/single-seguro/passos/passo-1.png' ); ?>" alt="" />
						</div>
						<input type="hidden" class="pacto-nr-img-url" name="pacto_seguro_steps[__INDEX__][image]" value="" />
						<input type="hidden" class="pacto-nr-img-id" name="pacto_seguro_steps[__INDEX__][image_id]" value="0" />
						<button type="button" class="button button-small pacto-nr-img-btn"><?php esc_html_e( 'Escolher Foto', 'pacto-25' ); ?></button>
					</div>
					<div>
						<div class="pacto-nr-field">
							<label><?php esc_html_e( 'Título do Passo', 'pacto-25' ); ?></label>
							<input type="text" name="pacto_seguro_steps[__INDEX__][title]" value="__NUM__º Passo" />
						</div>
						<div class="pacto-nr-field" style="margin-bottom:0;">
							<label><?php esc_html_e( 'Descrição do Passo', 'pacto-25' ); ?></label>
							<textarea name="pacto_seguro_steps[__INDEX__][description]" rows="2"></textarea>
						</div>
					</div>
				</div>
			</div>
		</script>
	</div>
	<?php
}

/**
 * 2. Render Single Seguro Documents Repeater (`seguro_docs_list`)
 *
 * @param WP_Post $post Current post.
 */
function pacto_render_seguro_docs_repeater_metabox( $post ) {
	wp_nonce_field( 'pacto_native_repeaters_save', 'pacto_native_repeaters_nonce' );
	pacto_render_native_repeaters_shared_assets();

	$docs = get_post_meta( $post->ID, 'seguro_docs_list', true );
	if ( ! is_array( $docs ) || empty( $docs ) ) {
		$docs = array(
			array( 'name' => 'Nome do Documento (2010-2023)', 'file' => '#' ),
			array( 'name' => 'Nome do Documento (2010-2023)', 'file' => '#' ),
			array( 'name' => 'Nome do Documento (2010-2023)', 'file' => '#' ),
			array( 'name' => 'Nome do Documento (2010-2023)', 'file' => '#' ),
		);
	}
	?>
	<div class="pacto-nr-box">
		<div class="pacto-nr-banner">
			<strong><?php esc_html_e( '📄 Documentos Legais (PDF):', 'pacto-25' ); ?></strong>
			<?php esc_html_e( 'Adicione, remova ou reordene os documentos para download na secção Documentos Legais.', 'pacto-25' ); ?>
		</div>

		<div class="pacto-nr-list" id="pacto-seguro-docs-list" data-prefix="pacto_seguro_docs" data-label="Documento">
			<?php foreach ( array_values( $docs ) as $idx => $doc ) :
				$d_name = isset( $doc['name'] ) ? $doc['name'] : '';
				$d_file = isset( $doc['file'] ) ? ( is_array( $doc['file'] ) && isset( $doc['file']['url'] ) ? $doc['file']['url'] : $doc['file'] ) : '';
			?>
				<div class="pacto-nr-item">
					<div class="pacto-nr-header">
						<span class="pacto-nr-badge">☰ <?php echo esc_html( sprintf( __( 'Documento #%d', 'pacto-25' ), $idx + 1 ) ); ?></span>
						<button type="button" class="pacto-nr-remove">✕ <?php esc_html_e( 'Remover', 'pacto-25' ); ?></button>
					</div>
					<div style="display:grid; grid-template-columns: 1fr 1fr; gap: 12px;">
						<div class="pacto-nr-field" style="margin-bottom:0;">
							<label><?php esc_html_e( 'Nome do Documento', 'pacto-25' ); ?></label>
							<input type="text" name="pacto_seguro_docs[<?php echo esc_attr( $idx ); ?>][name]" value="<?php echo esc_attr( $d_name ); ?>" />
						</div>
						<div class="pacto-nr-field" style="margin-bottom:0;">
							<label><?php esc_html_e( 'Ficheiro PDF / URL', 'pacto-25' ); ?></label>
							<div class="pacto-nr-file-row">
								<input type="text" class="pacto-nr-file-input" name="pacto_seguro_docs[<?php echo esc_attr( $idx ); ?>][file]" value="<?php echo esc_attr( $d_file ); ?>" placeholder="https://..." />
								<button type="button" class="button pacto-nr-file-btn"><?php esc_html_e( 'Escolher PDF', 'pacto-25' ); ?></button>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="pacto-nr-actions">
			<button type="button" class="button button-primary pacto-nr-add-btn" data-list="pacto-seguro-docs-list" data-template="pacto-seguro-doc-tpl">
				+ <?php esc_html_e( 'Adicionar Documento PDF', 'pacto-25' ); ?>
			</button>
		</div>

		<script type="text/html" id="pacto-seguro-doc-tpl">
			<div class="pacto-nr-item">
				<div class="pacto-nr-header">
					<span class="pacto-nr-badge">☰ Documento #__NUM__</span>
					<button type="button" class="pacto-nr-remove">✕ <?php esc_html_e( 'Remover', 'pacto-25' ); ?></button>
				</div>
				<div style="display:grid; grid-template-columns: 1fr 1fr; gap: 12px;">
					<div class="pacto-nr-field" style="margin-bottom:0;">
						<label><?php esc_html_e( 'Nome do Documento', 'pacto-25' ); ?></label>
						<input type="text" name="pacto_seguro_docs[__INDEX__][name]" value="" placeholder="Ex: Condições Gerais (PDF)" />
					</div>
					<div class="pacto-nr-field" style="margin-bottom:0;">
						<label><?php esc_html_e( 'Ficheiro PDF / URL', 'pacto-25' ); ?></label>
						<div class="pacto-nr-file-row">
							<input type="text" class="pacto-nr-file-input" name="pacto_seguro_docs[__INDEX__][file]" value="" placeholder="https://..." />
							<button type="button" class="button pacto-nr-file-btn"><?php esc_html_e( 'Escolher PDF', 'pacto-25' ); ?></button>
						</div>
					</div>
				</div>
			</div>
		</script>
	</div>
	<?php
}

/**
 * 3. Render FAQs Repeater (`seguro_faq_list`)
 *
 * @param WP_Post $post Current post.
 */
function pacto_render_seguro_faq_repeater_metabox( $post ) {
	wp_nonce_field( 'pacto_native_repeaters_save', 'pacto_native_repeaters_nonce' );
	pacto_render_native_repeaters_shared_assets();

	$faqs = get_post_meta( $post->ID, 'seguro_faq_list', true );
	if ( ! is_array( $faqs ) || empty( $faqs ) ) {
		$faqs = array(
			array(
				'question' => 'Que elementos terei de apresentar para subscrever o seguro multirriscos para o imóvel?',
				'answer'   => 'Para subscrever o seguro multirriscos, necessitará de apresentar o documento de identificação, NIF, comprovativo de morada do imóvel e a caderneta predial ou certidão do registo predial atualizada.',
			),
			array(
				'question' => 'Como posso calcular o valor do meu recheio para o seguro multirriscos?',
				'answer'   => 'O cálculo do recheio deve contemplar o valor de substituição em novo de todos os bens mobiliários, eletrodomésticos, equipamentos eletrónicos e objetos de uso pessoal presentes no imóvel.',
			),
			array(
				'question' => 'Devo descriminar os objetos especiais?',
				'answer'   => 'Sim, objetos de valor especial tais como joias, obras de arte, coleções ou relógios de elevado valor devem ser discriminados na apólice com a respetiva avaliação para garantia de cobertura total.',
			),
			array(
				'question' => 'Qual deve ser o capital seguro relativo ao imóvel?',
				'answer'   => 'O capital seguro para o edifício deve corresponder ao custo de reconstrução do imóvel (excluindo o valor do terreno), tendo em conta a área bruta de construção e a respetiva localização geográfica.',
			),
		);
	}
	?>
	<div class="pacto-nr-box">
		<div class="pacto-nr-banner">
			<strong><?php esc_html_e( '❓ Questões Mais Frequentes (FAQs):', 'pacto-25' ); ?></strong>
			<?php esc_html_e( 'Adicione, remova ou arraste as perguntas e respostas para reordenar o acordeão de FAQs.', 'pacto-25' ); ?>
		</div>

		<div class="pacto-nr-list" id="pacto-seguro-faq-list" data-prefix="pacto_seguro_faqs" data-label="Pergunta">
			<?php foreach ( array_values( $faqs ) as $idx => $faq ) :
				$q = isset( $faq['question'] ) ? $faq['question'] : '';
				$a = isset( $faq['answer'] ) ? $faq['answer'] : '';
			?>
				<div class="pacto-nr-item">
					<div class="pacto-nr-header">
						<span class="pacto-nr-badge">☰ <?php echo esc_html( sprintf( __( 'Pergunta #%d', 'pacto-25' ), $idx + 1 ) ); ?></span>
						<button type="button" class="pacto-nr-remove">✕ <?php esc_html_e( 'Remover', 'pacto-25' ); ?></button>
					</div>
					<div class="pacto-nr-field">
						<label><?php esc_html_e( 'Pergunta', 'pacto-25' ); ?></label>
						<input type="text" name="pacto_seguro_faqs[<?php echo esc_attr( $idx ); ?>][question]" value="<?php echo esc_attr( $q ); ?>" />
					</div>
					<div class="pacto-nr-field" style="margin-bottom:0;">
						<label><?php esc_html_e( 'Resposta', 'pacto-25' ); ?></label>
						<textarea name="pacto_seguro_faqs[<?php echo esc_attr( $idx ); ?>][answer]" rows="2"><?php echo esc_textarea( $a ); ?></textarea>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="pacto-nr-actions">
			<button type="button" class="button button-primary pacto-nr-add-btn" data-list="pacto-seguro-faq-list" data-template="pacto-seguro-faq-tpl">
				+ <?php esc_html_e( 'Adicionar Pergunta FAQ', 'pacto-25' ); ?>
			</button>
		</div>

		<script type="text/html" id="pacto-seguro-faq-tpl">
			<div class="pacto-nr-item">
				<div class="pacto-nr-header">
					<span class="pacto-nr-badge">☰ Pergunta #__NUM__</span>
					<button type="button" class="pacto-nr-remove">✕ <?php esc_html_e( 'Remover', 'pacto-25' ); ?></button>
				</div>
				<div class="pacto-nr-field">
					<label><?php esc_html_e( 'Pergunta', 'pacto-25' ); ?></label>
					<input type="text" name="pacto_seguro_faqs[__INDEX__][question]" value="" placeholder="Escreva a pergunta..." />
				</div>
				<div class="pacto-nr-field" style="margin-bottom:0;">
					<label><?php esc_html_e( 'Resposta', 'pacto-25' ); ?></label>
					<textarea name="pacto_seguro_faqs[__INDEX__][answer]" rows="2" placeholder="Escreva a resposta..."></textarea>
				</div>
			</div>
		</script>
	</div>
	<?php
}

/**
 * 4. Render Em Caso de Sinistro Repeaters (`sinistro_steps_list` & `sinistro_docs_list`)
 *
 * @param WP_Post $post Current post.
 */
function pacto_render_sinistro_repeaters_metabox( $post ) {
	wp_nonce_field( 'pacto_native_repeaters_save', 'pacto_native_repeaters_nonce' );
	pacto_render_native_repeaters_shared_assets();

	$steps = get_post_meta( $post->ID, 'sinistro_steps_list', true );
	if ( ! is_array( $steps ) || empty( $steps ) ) {
		$steps = array(
			array( 'text' => '1. Contacte a Pacto Seguro: 229 039 777 ou teresa.sousa@pactoseguro.com' ),
			array( 'text' => '2. Envie a documentação necessária' ),
			array( 'text' => '3. Analisamos a participação' ),
			array( 'text' => '4. Acompanhamos todo o processo junto da seguradora' ),
			array( 'text' => '5. Mantemos o acompanhamento até à resolução' ),
		);
	}

	$docs = get_post_meta( $post->ID, 'sinistro_docs_list', true );
	if ( ! is_array( $docs ) || empty( $docs ) ) {
		$docs = array(
			array( 'name' => 'Nome do Documento (2010-2023)', 'file' => '#' ),
			array( 'name' => 'Nome do Documento (2010-2023)', 'file' => '#' ),
			array( 'name' => 'Nome do Documento (2010-2023)', 'file' => '#' ),
			array( 'name' => 'Nome do Documento (2010-2023)', 'file' => '#' ),
		);
	}
	?>
	<div class="pacto-nr-box">
		<h4 style="margin: 0 0 10px; font-size: 14px; font-weight: 700; color: #1e293b;">
			<?php esc_html_e( '1. Passos "Como Participar um Sinistro"', 'pacto-25' ); ?>
		</h4>
		<div class="pacto-nr-list" id="pacto-sinistro-steps-list" data-prefix="pacto_sinistro_steps" data-label="Passo">
			<?php foreach ( array_values( $steps ) as $idx => $s ) :
				$txt = isset( $s['text'] ) ? $s['text'] : '';
			?>
				<div class="pacto-nr-item">
					<div class="pacto-nr-header">
						<span class="pacto-nr-badge">☰ <?php echo esc_html( sprintf( __( 'Passo #%d', 'pacto-25' ), $idx + 1 ) ); ?></span>
						<button type="button" class="pacto-nr-remove">✕ <?php esc_html_e( 'Remover', 'pacto-25' ); ?></button>
					</div>
					<div class="pacto-nr-field" style="margin-bottom:0;">
						<input type="text" name="pacto_sinistro_steps[<?php echo esc_attr( $idx ); ?>][text]" value="<?php echo esc_attr( $txt ); ?>" />
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="pacto-nr-actions" style="margin-bottom:24px;">
			<button type="button" class="button button-secondary pacto-nr-add-btn" data-list="pacto-sinistro-steps-list" data-template="pacto-sinistro-step-tpl">
				+ <?php esc_html_e( 'Adicionar Passo de Sinistro', 'pacto-25' ); ?>
			</button>
		</div>

		<h4 style="margin: 0 0 10px; font-size: 14px; font-weight: 700; color: #1e293b;">
			<?php esc_html_e( '2. Documentos Necessários (PDF)', 'pacto-25' ); ?>
		</h4>
		<div class="pacto-nr-list" id="pacto-sinistro-docs-list" data-prefix="pacto_sinistro_docs" data-label="Documento">
			<?php foreach ( array_values( $docs ) as $idx => $doc ) :
				$d_name = isset( $doc['name'] ) ? $doc['name'] : '';
				$d_file = isset( $doc['file'] ) ? ( is_array( $doc['file'] ) && isset( $doc['file']['url'] ) ? $doc['file']['url'] : $doc['file'] ) : '';
			?>
				<div class="pacto-nr-item">
					<div class="pacto-nr-header">
						<span class="pacto-nr-badge">☰ <?php echo esc_html( sprintf( __( 'Documento #%d', 'pacto-25' ), $idx + 1 ) ); ?></span>
						<button type="button" class="pacto-nr-remove">✕ <?php esc_html_e( 'Remover', 'pacto-25' ); ?></button>
					</div>
					<div style="display:grid; grid-template-columns: 1fr 1fr; gap: 12px;">
						<div class="pacto-nr-field" style="margin-bottom:0;">
							<label><?php esc_html_e( 'Nome do Documento', 'pacto-25' ); ?></label>
							<input type="text" name="pacto_sinistro_docs[<?php echo esc_attr( $idx ); ?>][name]" value="<?php echo esc_attr( $d_name ); ?>" />
						</div>
						<div class="pacto-nr-field" style="margin-bottom:0;">
							<label><?php esc_html_e( 'Ficheiro PDF / URL', 'pacto-25' ); ?></label>
							<div class="pacto-nr-file-row">
								<input type="text" class="pacto-nr-file-input" name="pacto_sinistro_docs[<?php echo esc_attr( $idx ); ?>][file]" value="<?php echo esc_attr( $d_file ); ?>" />
								<button type="button" class="button pacto-nr-file-btn"><?php esc_html_e( 'Escolher PDF', 'pacto-25' ); ?></button>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="pacto-nr-actions">
			<button type="button" class="button button-primary pacto-nr-add-btn" data-list="pacto-sinistro-docs-list" data-template="pacto-sinistro-doc-tpl">
				+ <?php esc_html_e( 'Adicionar Documento PDF', 'pacto-25' ); ?>
			</button>
		</div>

		<script type="text/html" id="pacto-sinistro-step-tpl">
			<div class="pacto-nr-item">
				<div class="pacto-nr-header">
					<span class="pacto-nr-badge">☰ Passo #__NUM__</span>
					<button type="button" class="pacto-nr-remove">✕ <?php esc_html_e( 'Remover', 'pacto-25' ); ?></button>
				</div>
				<div class="pacto-nr-field" style="margin-bottom:0;">
					<input type="text" name="pacto_sinistro_steps[__INDEX__][text]" value="" placeholder="Descrição do passo..." />
				</div>
			</div>
		</script>

		<script type="text/html" id="pacto-sinistro-doc-tpl">
			<div class="pacto-nr-item">
				<div class="pacto-nr-header">
					<span class="pacto-nr-badge">☰ Documento #__NUM__</span>
					<button type="button" class="pacto-nr-remove">✕ <?php esc_html_e( 'Remover', 'pacto-25' ); ?></button>
				</div>
				<div style="display:grid; grid-template-columns: 1fr 1fr; gap: 12px;">
					<div class="pacto-nr-field" style="margin-bottom:0;">
						<label><?php esc_html_e( 'Nome do Documento', 'pacto-25' ); ?></label>
						<input type="text" name="pacto_sinistro_docs[__INDEX__][name]" value="" placeholder="Ex: Declaração Amigável (PDF)" />
					</div>
					<div class="pacto-nr-field" style="margin-bottom:0;">
						<label><?php esc_html_e( 'Ficheiro PDF / URL', 'pacto-25' ); ?></label>
						<div class="pacto-nr-file-row">
							<input type="text" class="pacto-nr-file-input" name="pacto_sinistro_docs[__INDEX__][file]" value="" placeholder="https://..." />
							<button type="button" class="button pacto-nr-file-btn"><?php esc_html_e( 'Escolher PDF', 'pacto-25' ); ?></button>
						</div>
					</div>
				</div>
			</div>
		</script>
	</div>
	<?php
}

/**
 * 5. Render Protocolos Repeaters (`protocolos_cond_list` & `protocolos_vantagens_list`)
 *
 * @param WP_Post $post Current post.
 */
function pacto_render_protocolos_repeaters_metabox( $post ) {
	wp_nonce_field( 'pacto_native_repeaters_save', 'pacto_native_repeaters_nonce' );
	pacto_render_native_repeaters_shared_assets();

	$cond_list = get_post_meta( $post->ID, 'protocolos_cond_list', true );
	if ( ! is_array( $cond_list ) || empty( $cond_list ) ) {
		$cond_list = array(
			array( 'item' => 'Ordens dos Médicos, Médicos Dentistas e Enfermeiros;' ),
			array( 'item' => 'Ordens dos Engenheiros e Engenheiros Técnicos;' ),
			array( 'item' => 'Ordem dos Biólogos;' ),
			array( 'item' => 'Ordem dos Arquitetos;' ),
			array( 'item' => 'Ordem dos Economistas;' ),
			array( 'item' => 'Ordem dos Farmaceuticos;' ),
			array( 'item' => 'Ordem dos Psicologos;' ),
			array( 'item' => 'Ordem dos Ordem dos Solicitadores e Agentes de Execução;' ),
			array( 'item' => 'Sindicato Nacional dos Médicos Veterinários;' ),
			array( 'item' => 'Associação Sindical dos Juízes Portugueses.' ),
		);
	}

	$vantagens_list = get_post_meta( $post->ID, 'protocolos_vantagens_list', true );
	if ( ! is_array( $vantagens_list ) || empty( $vantagens_list ) ) {
		$vantagens_list = array(
			array( 'item' => 'Condições exclusivas;' ),
			array( 'item' => 'Coberturas diferenciadas;' ),
			array( 'item' => 'Preços preferenciais;' ),
			array( 'item' => 'Acompanhamento especializado;' ),
			array( 'item' => 'Soluções adaptadas à profissão.' ),
		);
	}
	?>
	<div class="pacto-nr-box">
		<div style="display:grid; grid-template-columns: 1fr 1fr; gap: 24px;">
			<div>
				<h4 style="margin: 0 0 10px; font-size: 14px; font-weight: 700; color: #1e293b;">
					<?php esc_html_e( '1. Lista de Ordens e Associações', 'pacto-25' ); ?>
				</h4>
				<div class="pacto-nr-list" id="pacto-protocolos-cond-list" data-prefix="pacto_protocolos_cond" data-label="Entidade">
					<?php foreach ( array_values( $cond_list ) as $idx => $row ) :
						$val = isset( $row['item'] ) ? $row['item'] : '';
					?>
						<div class="pacto-nr-item">
							<div class="pacto-nr-header">
								<span class="pacto-nr-badge">☰ <?php echo esc_html( sprintf( __( 'Entidade #%d', 'pacto-25' ), $idx + 1 ) ); ?></span>
								<button type="button" class="pacto-nr-remove">✕</button>
							</div>
							<div class="pacto-nr-field" style="margin-bottom:0;">
								<input type="text" name="pacto_protocolos_cond[<?php echo esc_attr( $idx ); ?>][item]" value="<?php echo esc_attr( $val ); ?>" />
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="pacto-nr-actions">
					<button type="button" class="button button-secondary pacto-nr-add-btn" data-list="pacto-protocolos-cond-list" data-template="pacto-protocolos-cond-tpl">
						+ <?php esc_html_e( 'Adicionar Ordem / Associação', 'pacto-25' ); ?>
					</button>
				</div>
			</div>

			<div>
				<h4 style="margin: 0 0 10px; font-size: 14px; font-weight: 700; color: #1e293b;">
					<?php esc_html_e( '2. Vantagens dos Protocolos (Círculo Vermelho)', 'pacto-25' ); ?>
				</h4>
				<div class="pacto-nr-list" id="pacto-protocolos-vant-list" data-prefix="pacto_protocolos_vant" data-label="Vantagem">
					<?php foreach ( array_values( $vantagens_list ) as $idx => $row ) :
						$val = isset( $row['item'] ) ? $row['item'] : '';
					?>
						<div class="pacto-nr-item">
							<div class="pacto-nr-header">
								<span class="pacto-nr-badge">☰ <?php echo esc_html( sprintf( __( 'Vantagem #%d', 'pacto-25' ), $idx + 1 ) ); ?></span>
								<button type="button" class="pacto-nr-remove">✕</button>
							</div>
							<div class="pacto-nr-field" style="margin-bottom:0;">
								<input type="text" name="pacto_protocolos_vant[<?php echo esc_attr( $idx ); ?>][item]" value="<?php echo esc_attr( $val ); ?>" />
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="pacto-nr-actions">
					<button type="button" class="button button-primary pacto-nr-add-btn" data-list="pacto-protocolos-vant-list" data-template="pacto-protocolos-vant-tpl">
						+ <?php esc_html_e( 'Adicionar Vantagem', 'pacto-25' ); ?>
					</button>
				</div>
			</div>
		</div>

		<script type="text/html" id="pacto-protocolos-cond-tpl">
			<div class="pacto-nr-item">
				<div class="pacto-nr-header">
					<span class="pacto-nr-badge">☰ Entidade #__NUM__</span>
					<button type="button" class="pacto-nr-remove">✕</button>
				</div>
				<div class="pacto-nr-field" style="margin-bottom:0;">
					<input type="text" name="pacto_protocolos_cond[__INDEX__][item]" value="" placeholder="Nome da Ordem ou Associação..." />
				</div>
			</div>
		</script>

		<script type="text/html" id="pacto-protocolos-vant-tpl">
			<div class="pacto-nr-item">
				<div class="pacto-nr-header">
					<span class="pacto-nr-badge">☰ Vantagem #__NUM__</span>
					<button type="button" class="pacto-nr-remove">✕</button>
				</div>
				<div class="pacto-nr-field" style="margin-bottom:0;">
					<input type="text" name="pacto_protocolos_vant[__INDEX__][item]" value="" placeholder="Descrição da vantagem..." />
				</div>
			</div>
		</script>
	</div>
	<?php
}

/**
 * Save Handler for All Native Repeaters in this file
 *
 * @param int $post_id Post ID.
 */
function pacto_save_native_repeaters_meta( $post_id ) {
	if ( ! isset( $_POST['pacto_native_repeaters_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pacto_native_repeaters_nonce'] ) ), 'pacto_native_repeaters_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// 1. Single Seguro Steps
	if ( isset( $_POST['pacto_seguro_steps'] ) && is_array( $_POST['pacto_seguro_steps'] ) ) {
		$clean_steps = array();
		foreach ( wp_unslash( $_POST['pacto_seguro_steps'] ) as $raw ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$t   = isset( $raw['title'] ) ? sanitize_text_field( $raw['title'] ) : '';
			$d   = isset( $raw['description'] ) ? sanitize_textarea_field( $raw['description'] ) : '';
			$img = isset( $raw['image'] ) ? esc_url_raw( $raw['image'] ) : '';
			$id  = isset( $raw['image_id'] ) ? absint( $raw['image_id'] ) : 0;
			if ( '' !== $t || '' !== $d ) {
				$clean_steps[] = array(
					'title'       => $t,
					'description' => $d,
					'image'       => $img,
					'image_id'    => $id,
				);
			}
		}
		update_post_meta( $post_id, 'seguro_steps_list', $clean_steps );
		delete_post_meta( $post_id, '_seguro_steps_list' );
		foreach ( $clean_steps as $i => $step ) {
			$slot = $i + 1;
			if ( $slot <= 3 ) {
				update_post_meta( $post_id, "seguro_step_{$slot}_title", $step['title'] );
				update_post_meta( $post_id, "seguro_step_{$slot}_desc", $step['description'] );
				if ( ! empty( $step['image_id'] ) ) {
					update_post_meta( $post_id, "seguro_step_{$slot}_image", $step['image_id'] );
				}
			}
		}
	}

	// 2. Single Seguro Docs
	if ( isset( $_POST['pacto_seguro_docs'] ) && is_array( $_POST['pacto_seguro_docs'] ) ) {
		$clean_docs = array();
		foreach ( wp_unslash( $_POST['pacto_seguro_docs'] ) as $raw ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$name = isset( $raw['name'] ) ? sanitize_text_field( $raw['name'] ) : '';
			$file = isset( $raw['file'] ) ? sanitize_text_field( $raw['file'] ) : '';
			if ( '' !== $name || '' !== $file ) {
				$clean_docs[] = array(
					'name' => $name,
					'file' => $file,
				);
			}
		}
		update_post_meta( $post_id, 'seguro_docs_list', $clean_docs );
		delete_post_meta( $post_id, '_seguro_docs_list' );
	}

	// 3. FAQs (`seguro_faq_list`)
	if ( isset( $_POST['pacto_seguro_faqs'] ) && is_array( $_POST['pacto_seguro_faqs'] ) ) {
		$clean_faqs = array();
		foreach ( wp_unslash( $_POST['pacto_seguro_faqs'] ) as $raw ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$q = isset( $raw['question'] ) ? sanitize_text_field( $raw['question'] ) : '';
			$a = isset( $raw['answer'] ) ? sanitize_textarea_field( $raw['answer'] ) : '';
			if ( '' !== $q || '' !== $a ) {
				$clean_faqs[] = array(
					'question' => $q,
					'answer'   => $a,
				);
			}
		}
		update_post_meta( $post_id, 'seguro_faq_list', $clean_faqs );
		delete_post_meta( $post_id, '_seguro_faq_list' );
	}

	// 4. Sinistro Steps (`sinistro_steps_list`)
	if ( isset( $_POST['pacto_sinistro_steps'] ) && is_array( $_POST['pacto_sinistro_steps'] ) ) {
		$clean_s_steps = array();
		foreach ( wp_unslash( $_POST['pacto_sinistro_steps'] ) as $raw ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$txt = isset( $raw['text'] ) ? sanitize_text_field( $raw['text'] ) : '';
			if ( '' !== $txt ) {
				$clean_s_steps[] = array( 'text' => $txt );
			}
		}
		update_post_meta( $post_id, 'sinistro_steps_list', $clean_s_steps );
		delete_post_meta( $post_id, '_sinistro_steps_list' );
	}

	// 5. Sinistro Docs (`sinistro_docs_list`)
	if ( isset( $_POST['pacto_sinistro_docs'] ) && is_array( $_POST['pacto_sinistro_docs'] ) ) {
		$clean_s_docs = array();
		foreach ( wp_unslash( $_POST['pacto_sinistro_docs'] ) as $raw ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$name = isset( $raw['name'] ) ? sanitize_text_field( $raw['name'] ) : '';
			$file = isset( $raw['file'] ) ? sanitize_text_field( $raw['file'] ) : '';
			if ( '' !== $name || '' !== $file ) {
				$clean_s_docs[] = array(
					'name' => $name,
					'file' => $file,
				);
			}
		}
		update_post_meta( $post_id, 'sinistro_docs_list', $clean_s_docs );
		delete_post_meta( $post_id, '_sinistro_docs_list' );
	}

	// 6. Protocolos Cond List (`protocolos_cond_list`)
	if ( isset( $_POST['pacto_protocolos_cond'] ) && is_array( $_POST['pacto_protocolos_cond'] ) ) {
		$clean_cond = array();
		foreach ( wp_unslash( $_POST['pacto_protocolos_cond'] ) as $raw ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$item = isset( $raw['item'] ) ? sanitize_text_field( $raw['item'] ) : '';
			if ( '' !== $item ) {
				$clean_cond[] = array( 'item' => $item );
			}
		}
		update_post_meta( $post_id, 'protocolos_cond_list', $clean_cond );
		delete_post_meta( $post_id, '_protocolos_cond_list' );
	}

	// 7. Protocolos Vantagens List (`protocolos_vantagens_list`)
	if ( isset( $_POST['pacto_protocolos_vant'] ) && is_array( $_POST['pacto_protocolos_vant'] ) ) {
		$clean_vant = array();
		foreach ( wp_unslash( $_POST['pacto_protocolos_vant'] ) as $raw ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			$item = isset( $raw['item'] ) ? sanitize_text_field( $raw['item'] ) : '';
			if ( '' !== $item ) {
				$clean_vant[] = array( 'item' => $item );
			}
		}
		update_post_meta( $post_id, 'protocolos_vantagens_list', $clean_vant );
		delete_post_meta( $post_id, '_protocolos_vantagens_list' );
	}
}
add_action( 'save_post', 'pacto_save_native_repeaters_meta', 20 );

