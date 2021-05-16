<?php

namespace NikolayS93\PostTypeHelper;

class Metabox {
	private $nonce_key = 'CSQUrdh78GLKgyF';
	private $fields    = array();
	private $id;
	private $label;
	private $callback;
	private $context;
	private $priority;

	public function __construct( $id, $label, $context = 'advanced', $priority = 'high' ) {
		$this->id       = $id;
		$this->label    = $label;
		$this->callback = array( $this, 'callback' );
		$this->context  = $context;
		$this->priority = $priority;
	}

	public function set_nonce_key( $key ) {
		$this->nonce_key = $key;

		return $this;
	}

	public function add_field( $key, $label ) {
		$this->fields[ $key ] = $label;

		return $this;
	}

	public function add_fields( $fields ) {
		foreach ( $fields as $key => $label ) {
			$this->add_field( $key, $label );
		}

		return $this;
	}

	public function callback( $post, $meta ) {
		// Используем nonce для верификации.
		wp_nonce_field( basename( __FILE__ ), $this->nonce_key );

		if ( isset( $meta['args']['fields'] ) && is_array( $meta['args']['fields'] ) ) {
			foreach ( $meta['args']['fields'] as $field_name => $field_label ) {
				// Значение поля.
				$meta_value = get_post_meta( $post->ID, $field_name, true );

				?>
				<label>
					<p class="label"><?php echo esc_html( $field_label ); ?></p>
					<input type="text" name="<?php echo esc_attr( $field_name ); ?>" value="<?php echo esc_attr( $meta_value ); ?>" size="25" />
				</label>
				<?php
			}
		}
	}

	public function save_post( $post_id ) {
		$nonce = isset( $_POST[ $this->nonce_key ] ) ? wp_unslash( $_POST[ $this->nonce_key ] ) : '';

		// Проверка безопасности.
		if ( ! wp_verify_nonce( $nonce, basename( __FILE__ ) ) ) {
			return false;
		}
		// Проверка автосохранения.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return false;
		}
		// Проверка прав текущего пользователя.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return false;
		}

		foreach ( $this->fields as $field_name => $field_label ) {
			$value = isset( $_POST[ $field_name ] ) ? wp_unslash( $_POST[ $field_name ] ) : false;

			if ( $value ) {
				update_post_meta( $post_id, $field_name, sanitize_text_field( $value ) );
			}
		}
	}

	public function register( $post_type ) {
		add_action(
			'add_meta_boxes',
			function () use ( $post_type ) {
				add_meta_box( $this->id, $this->label, $this->callback, $post_type, $this->context, $this->priority, array( 'fields' => $this->fields ) );
			}
		);

		add_action(
			'init',
			function() {
				add_action( 'save_post', array( $this, 'save_post' ), 10, 1 );
			}
		);
	}
}
