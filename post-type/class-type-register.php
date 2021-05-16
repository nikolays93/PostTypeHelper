<?php

namespace NikolayS93\PostTypeHelper;

class Type_Register {

	protected $post_type;
	protected $taxonomy;
	protected $metaboxes = array();

	public function add_post_type( Post_Type_Register_Data $post_type ) {
		$this->post_type = $post_type;
	}

	public function add_taxonomy( Taxonomy_Register_Data $taxonomy ) {
		$this->taxonomy = $taxonomy;
	}

	public function add_metabox( Metabox $metabox ) {
		$this->metaboxes[] = $metabox;
	}


	public function register_post_type() {
		if ( $this->post_type ) {
			register_post_type( $this->post_type->slug(), $this->post_type->args() );
		}
	}

	public function register_taxonomy() {
		if ( $this->post_type && $this->taxonomy ) {
			register_taxonomy( $this->taxonomy->slug(), $this->post_type->slug(), $this->taxonomy->args() );
		}
	}

	public function add_meta_boxes() {
		$post_type = $this->post_type->slug();
		foreach ( $this->metaboxes as $meta_box ) {
			$meta_box->register( $post_type );
		}
	}

	public function register() {
		/**
		 * Регистрируем тип записи слайдер "slide"
		 */
		add_action( 'init', array( $this, 'register_post_type' ), 10 );

		/**
		 * Регистрируем таксономию slider (Категории (термины) связывающие слайды (записи) в слайдер)
		 */
		add_action( 'init', array( $this, 'register_taxonomy' ), 10 );

		$post_type = $this->post_type->slug();
		foreach ( $this->metaboxes as $meta_box ) {
			$meta_box->register( $post_type );
		}
	}
}
