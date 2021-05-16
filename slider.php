<?php

use NikolayS93\PostTypeHelper\Post_Template_Part;
use NikolayS93\PostTypeHelper\Post_Type;
use NikolayS93\PostTypeHelper\Taxonomy;
use NikolayS93\PostTypeHelper\Type_Register;
use NikolayS93\PostTypeHelper\Metabox;

class Slide_Post_Type extends Post_Type {
	use Post_Template_Part;

	private $slug = 'slide';

	public function __construct() {}

	public function args() {
		return array(
			'public'              => true,
			'publicly_queryable'  => null,
			'exclude_from_search' => null,
			'show_ui'             => null,
			'show_in_menu'        => null,
			'show_in_admin_bar'   => null,
			'show_in_nav_menus'   => null,
			'menu_icon'           => 'dashicons-images-alt2',
			'menu_position'       => 15,
			'has_archive'         => true,
			'hierarchical'        => false,
			// 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats'
			'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
			'description'         => '',
			'labels'              => array(
				'name'               => __( 'Слайды', 'textdomain' ),
				'singular_name'      => __( 'Слайд', 'textdomain' ),
				'add_new'            => __( 'Добавить слайд', 'textdomain' ),
				'add_new_item'       => __( 'Добавить слайд', 'textdomain' ),
				'edit_item'          => __( 'Редактировать слайд', 'textdomain' ),
				'new_item'           => __( 'Новый слайд', 'textdomain' ),
				'all_items'          => __( 'Все слайды', 'textdomain' ),
				'view_item'          => __( 'Просмотр слайда на сайте', 'textdomain' ),
				'search_items'       => __( 'Найти слайд', 'textdomain' ),
				'not_found'          => __( 'Слайдов не найдено.', 'textdomain' ),
				'not_found_in_trash' => __( 'В корзине нет слайдов.', 'textdomain' ),
				'menu_name'          => __( 'Слайды', 'textdomain' ),
			),
		);
	}
}

class Slider_Taxonomy extends Taxonomy {

	private static $slug = 'slider';

	public function __construct() {}

	public function args() {
		return array(
			'hierarchical' => false,
			'show_ui'      => true,
			'query_var'    => true,
			'labels'       => array(
				'name'                       => __( 'Слайдер', 'textdomain' ),
				'singular_name'              => __( 'Слайдер', 'textdomain' ),
				'search_items'               => __( 'Найти слайдер', 'textdomain' ),
				'popular_items'              => __( 'Популярные слайдеры', 'textdomain' ),
				'all_items'                  => __( 'Все слайдеры', 'textdomain' ),
				'edit_item'                  => __( 'Изменить слайдер', 'textdomain' ),
				'update_item'                => __( 'Обновить слайдер', 'textdomain' ),
				'add_new_item'               => __( 'Добавить новый слайдер', 'textdomain' ),
				'new_item_name'              => __( 'Новое имя слайдера', 'textdomain' ),
				'separate_items_with_commas' => __( 'Введите слайдеры через запятую', 'textdomain' ),
				'add_or_remove_items'        => __( 'Добавить или удалить слайдер', 'textdomain' ),
				'choose_from_most_used'      => __( 'Выберите из популярных', 'textdomain' ),
				'menu_name'                  => __( 'Слайдер', 'textdomain' ),
			),
		);
	}
}

$register = new Type_Register();
$register->add_post_type( new Slide_Post_Type() );
$register->add_taxonomy( new Slider_Taxonomy() );
$register->add_metabox(
	( new Metabox( 'custom_meta', 'Custom post meta' ) )->add_fields(
		array(
			'custom_meta' => 'Custom meta',
		)
	)
);
$register->register();
