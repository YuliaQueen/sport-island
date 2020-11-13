<?php

$widgets = [
	'widget-text.php',
	'widget-contacts.php',
	'widget-social-links.php',
	'widget-iframe.php',
	'widget-info.php',
];


foreach ( $widgets as $w ) {
	require_once( __DIR__ . '/inc/' . $w );
}

add_action( 'after_setup_theme', 'si_setup' );
add_action( 'wp_enqueue_scripts', 'si_scripts' );
add_action( 'widgets_init', 'si_register' );
add_action( 'init', 'si_register_types' );
add_action( 'add_meta_boxes', 'si_meta_boxes' );
add_action( 'save_post', 'si_save_likes_meta' );

add_shortcode( 'si-past-link', 'si_past_link' );

add_filter( 'si_widget_text', 'do_shortcode' );


function _si_assets_path( $path ) {
	return get_template_directory_uri() . '/assets/' . $path;
}

function si_setup() {
	register_nav_menu( 'menu-header', 'Меню в шапке' );
	register_nav_menu( 'menu-footer', 'Меню в подвале' );

	add_theme_support( 'custom-logo' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
}

function si_scripts() {
	wp_enqueue_script(
		'js',
		_si_assets_path( 'js/js.js' ),
		[],
		'1.0',
		true
	);
	wp_enqueue_style(
		'si-style',
		_si_assets_path( 'css/styles.css' ),
		[],
		'1.0',
		'all'
	);
}

function si_register() {
	register_sidebar(
		[
			'name'          => 'Контакты в шапке сайта',
			'id'            => 'si-header',
			'before_widget' => null,
			'after_widget'  => null
		]
	);
	register_sidebar(
		[
			'name'          => 'Контакты в подвале сайта',
			'id'            => 'si-footer',
			'before_widget' => null,
			'after_widget'  => null
		]
	);
	register_sidebar(
		[
			'name'          => 'Подвал-колонка 1',
			'id'            => 'si-footer-column-1',
			'before_widget' => null,
			'after_widget'  => null
		]
	);
	register_sidebar(
		[
			'name'          => 'Подвал-колонка 2',
			'id'            => 'si-footer-column-2',
			'before_widget' => null,
			'after_widget'  => null
		]
	);
	register_sidebar(
		[
			'name'          => 'Подвал-колонка 3',
			'id'            => 'si-footer-column-3',
			'before_widget' => null,
			'after_widget'  => null
		]
	);
	register_sidebar(
		[
			'name'          => 'Карта',
			'id'            => 'map',
			'before_widget' => null,
			'after_widget'  => null
		]
	);
	register_sidebar(
		[
			'name'          => 'Контакты под картой',
			'id'            => 'contacts-after-map',
			'before_widget' => null,
			'after_widget'  => null
		]
	);

	register_widget( 'si_widget_text' );
	register_widget( 'si_widget_contacts' );
	register_widget( 'si_social_links' );
	register_widget( 'si_widget_iframe' );
	register_widget( 'si_widget_info' );
}

function si_register_types() {
	register_post_type( 'services',
	                    [
		                    'label'         => null,
		                    'labels'        => [
			                    'name'               => 'Услуги',
			                    // основное название для типа записи
			                    'singular_name'      => 'Услуги',
			                    // название для одной записи этого типа
			                    'add_new'            => 'Добавить новую услугу',
			                    // для добавления новой записи
			                    'add_new_item'       => 'Добавить новую услугу',
			                    // заголовка у вновь создаваемой записи в админ-панели.
			                    'edit_item'          => 'Редактирование услуги',
			                    // для редактирования типа записи
			                    'new_item'           => 'Новая услуга',
			                    // текст новой записи
			                    'view_item'          => 'Смотреть услуги',
			                    // для просмотра записи этого типа.
			                    'search_items'       => 'Искать услуги',
			                    // для поиска по этим типам записи
			                    'not_found'          => 'Не найдено',
			                    // если в результате поиска ничего не было найдено
			                    'not_found_in_trash' => 'Не найдено в корзине',
			                    // если не было найдено в корзине
			                    'parent_item_colon'  => '',
			                    // для родителей (у древовидных типов)
			                    'menu_name'          => 'Услуги',
			                    // название меню
		                    ],
		                    'description'   => '',
		                    'public'        => true,
		                    // 'publicly_queryable'  => null, // зависит от public
		                    // 'exclude_from_search' => null, // зависит от public
		                    // 'show_ui'             => null, // зависит от public
		                    // 'show_in_nav_menus'   => null, // зависит от public
		                    'show_in_menu'  => null,
		                    // показывать ли в меню адмнки
		                    // 'show_in_admin_bar'   => null, // зависит от show_in_menu
		                    'show_in_rest'  => null,
		                    // добавить в REST API. C WP 4.7
		                    'rest_base'     => null,
		                    // $post_type. C WP 4.7
		                    'menu_position' => 20,
		                    'menu_icon'     => 'dashicons-smiley',
		                    'hierarchical'  => false,
		                    'supports'      => [ 'title' ],
		                    // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		                    'taxonomies'    => [],
		                    'has_archive'   => true,
		                    'rewrite'       => true,
		                    'query_var'     => true,
	                    ] );
	register_post_type( 'trainers',
	                    [
		                    'label'         => null,
		                    'labels'        => [
			                    'name'               => 'Тренеры',
			                    // основное название для типа записи
			                    'singular_name'      => 'Тренеры',
			                    // название для одной записи этого типа
			                    'add_new'            => 'Добавить нового тренера',
			                    // для добавления новой записи
			                    'add_new_item'       => 'Добавить нового тренера',
			                    // заголовка у вновь создаваемой записи в админ-панели.
			                    'edit_item'          => 'Редактирование тренера',
			                    // для редактирования типа записи
			                    'new_item'           => 'Новый тренер',
			                    // текст новой записи
			                    'view_item'          => 'Смотреть тренера',
			                    // для просмотра записи этого типа.
			                    'search_items'       => 'Искать тренера',
			                    // для поиска по этим типам записи
			                    'not_found'          => 'Не найдено',
			                    // если в результате поиска ничего не было найдено
			                    'not_found_in_trash' => 'Не найдено в корзине',
			                    // если не было найдено в корзине
			                    'parent_item_colon'  => '',
			                    // для родителей (у древовидных типов)
			                    'menu_name'          => 'Тренеры',
			                    // название меню
		                    ],
		                    'description'   => '',
		                    'public'        => true,
		                    // 'publicly_queryable'  => null, // зависит от public
		                    // 'exclude_from_search' => null, // зависит от public
		                    // 'show_ui'             => null, // зависит от public
		                    // 'show_in_nav_menus'   => null, // зависит от public
		                    'show_in_menu'  => null,
		                    // показывать ли в меню адмнки
		                    // 'show_in_admin_bar'   => null, // зависит от show_in_menu
		                    'show_in_rest'  => null,
		                    // добавить в REST API. C WP 4.7
		                    'rest_base'     => null,
		                    // $post_type. C WP 4.7
		                    'menu_position' => 20,
		                    'menu_icon'     => 'dashicons-groups',
		                    'hierarchical'  => false,
		                    'supports'      => [ 'title' ],
		                    // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		                    'taxonomies'    => [],
		                    'has_archive'   => true,
		                    'rewrite'       => true,
		                    'query_var'     => true,
	                    ] );
	register_post_type( 'schedule',
	                    [
		                    'label'         => null,
		                    'labels'        => [
			                    'name'               => 'Занятия',
			                    // основное название для типа записи
			                    'singular_name'      => 'Занятия',
			                    // название для одной записи этого типа
			                    'add_new'            => 'Добавить новое занятие',
			                    // для добавления новой записи
			                    'add_new_item'       => 'Добавить новое занятие',
			                    // заголовка у вновь создаваемой записи в админ-панели.
			                    'edit_item'          => 'Редактирование занятия',
			                    // для редактирования типа записи
			                    'new_item'           => 'Новое занятие',
			                    // текст новой записи
			                    'view_item'          => 'Смотреть занятие',
			                    // для просмотра записи этого типа.
			                    'search_items'       => 'Искать занятие',
			                    // для поиска по этим типам записи
			                    'not_found'          => 'Не найдено занятие',
			                    // если в результате поиска ничего не было найдено
			                    'not_found_in_trash' => 'Не найдено в корзине',
			                    // если не было найдено в корзине
			                    'parent_item_colon'  => '',
			                    // для родителей (у древовидных типов)
			                    'menu_name'          => 'Занятия',
			                    // название меню
		                    ],
		                    'description'   => '',
		                    'public'        => true,
		                    // 'publicly_queryable'  => null, // зависит от public
		                    // 'exclude_from_search' => null, // зависит от public
		                    // 'show_ui'             => null, // зависит от public
		                    // 'show_in_nav_menus'   => null, // зависит от public
		                    'show_in_menu'  => null,
		                    // показывать ли в меню адмнки
		                    // 'show_in_admin_bar'   => null, // зависит от show_in_menu
		                    'show_in_rest'  => null,
		                    // добавить в REST API. C WP 4.7
		                    'rest_base'     => null,
		                    // $post_type. C WP 4.7
		                    'menu_position' => 20,
		                    'menu_icon'     => 'dashicons-pressthis',
		                    'hierarchical'  => false,
		                    'supports'      => [ 'title' ],
		                    // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		                    'taxonomies'    => [],
		                    'has_archive'   => true,
		                    'rewrite'       => true,
		                    'query_var'     => true,
	                    ] );
	register_taxonomy( 'schedule_days',
	                   [ 'schedule' ],
	                   [
		                   'label'        => '',
		                   // определяется параметром $labels->name
		                   'labels'       => [
			                   'name'          => 'Дни недели',
			                   'singular_name' => 'Дни недели',
			                   'search_items'  => 'Поиск дня недели',
			                   'all_items'     => 'Все дни',
			                   'view_item '    => 'Посмотреть день недели',
			                   'edit_item'     => 'Редактировать дни недели',
			                   'update_item'   => 'Обновить дни недели',
			                   'add_new_item'  => 'Добавить день недели',
			                   'new_item_name' => 'Новый день недели',
			                   'menu_name'     => 'Дни недели',
		                   ],
		                   'description'  => '',
		                   'public'       => true,
		                   'hierarchical' => true,
	                   ] );
	register_taxonomy( 'places',
	                   [ 'schedule' ],
	                   [
		                   'label'        => '',
		                   // определяется параметром $labels->name
		                   'labels'       => [
			                   'name'          => 'Залы',
			                   'singular_name' => 'Залы',
			                   'search_items'  => 'Поиск зала',
			                   'all_items'     => 'Все залы',
			                   'view_item '    => 'Посмотреть залы',
			                   'edit_item'     => 'Редактировать зал',
			                   'update_item'   => 'Обновить залы',
			                   'add_new_item'  => 'Добавить зал',
			                   'new_item_name' => 'Новый зал',
			                   'menu_name'     => 'Залы',
		                   ],
		                   'description'  => '',
		                   'public'       => true,
		                   'hierarchical' => true,
	                   ] );
	register_post_type( 'prices',
	                    [
		                    'label'         => null,
		                    'labels'        => [
			                    'name'               => 'Прайсы',
			                    // основное название для типа записи
			                    'singular_name'      => 'Прайсы',
			                    // название для одной записи этого типа
			                    'add_new'            => 'Добавить новый прайс',
			                    // для добавления новой записи
			                    'add_new_item'       => 'Добавить новый прайс',
			                    // заголовка у вновь создаваемой записи в админ-панели.
			                    'edit_item'          => 'Редактирование прайса',
			                    // для редактирования типа записи
			                    'new_item'           => 'Новый прайс',
			                    // текст новой записи
			                    'view_item'          => 'Смотреть прайс',
			                    // для просмотра записи этого типа.
			                    'search_items'       => 'Искать прайс',
			                    // для поиска по этим типам записи
			                    'not_found'          => 'Не найдено прайса',
			                    // если в результате поиска ничего не было найдено
			                    'not_found_in_trash' => 'Не найдено в корзине',
			                    // если не было найдено в корзине
			                    'parent_item_colon'  => '',
			                    // для родителей (у древовидных типов)
			                    'menu_name'          => 'Цены',
			                    // название меню
		                    ],
		                    'description'   => '',
		                    'public'        => true,
		                    // 'publicly_queryable'  => null, // зависит от public
		                    // 'exclude_from_search' => null, // зависит от public
		                    // 'show_ui'             => null, // зависит от public
		                    // 'show_in_nav_menus'   => null, // зависит от public
		                    'show_in_menu'  => null,
		                    // показывать ли в меню адмнки
		                    // 'show_in_admin_bar'   => null, // зависит от show_in_menu
		                    'show_in_rest'  => null,
		                    // добавить в REST API. C WP 4.7
		                    'rest_base'     => null,
		                    // $post_type. C WP 4.7
		                    'menu_position' => 20,
		                    'menu_icon'     => 'dashicons-money-alt',
		                    'hierarchical'  => false,
		                    'supports'      => [ 'title' ],
		                    // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		                    'taxonomies'    => [],
		                    'has_archive'   => true,
		                    'rewrite'       => true,
		                    'query_var'     => true,
	                    ] );
	register_post_type( 'cards',
	                    [
		                    'label'         => null,
		                    'labels'        => [
			                    'name'               => 'Карты',
			                    // основное название для типа записи
			                    'singular_name'      => 'Карта',
			                    // название для одной записи этого типа
			                    'add_new'            => 'Добавить новую карту',
			                    // для добавления новой записи
			                    'add_new_item'       => 'Добавить новую карту',
			                    // заголовка у вновь создаваемой записи в админ-панели.
			                    'edit_item'          => 'Редактирование карты',
			                    // для редактирования типа записи
			                    'new_item'           => 'Новая карта',
			                    // текст новой записи
			                    'view_item'          => 'Смотреть карту',
			                    // для просмотра записи этого типа.
			                    'search_items'       => 'Искать карту',
			                    // для поиска по этим типам записи
			                    'not_found'          => 'Не найдено карты',
			                    // если в результате поиска ничего не было найдено
			                    'not_found_in_trash' => 'Не найдено в корзине',
			                    // если не было найдено в корзине
			                    'parent_item_colon'  => '',
			                    // для родителей (у древовидных типов)
			                    'menu_name'          => 'Клубные карты',
			                    // название меню
		                    ],
		                    'description'   => '',
		                    'public'        => true,
		                    // 'publicly_queryable'  => null, // зависит от public
		                    // 'exclude_from_search' => null, // зависит от public
		                    // 'show_ui'             => null, // зависит от public
		                    // 'show_in_nav_menus'   => null, // зависит от public
		                    'show_in_menu'  => null,
		                    // показывать ли в меню адмнки
		                    // 'show_in_admin_bar'   => null, // зависит от show_in_menu
		                    'show_in_rest'  => null,
		                    // добавить в REST API. C WP 4.7
		                    'rest_base'     => null,
		                    // $post_type. C WP 4.7
		                    'menu_position' => 20,
		                    'menu_icon'     => 'dashicons-tickets-alt',
		                    'hierarchical'  => false,
		                    'supports'      => [ 'title' ],
		                    // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		                    'taxonomies'    => [],
		                    'has_archive'   => false,
		                    'rewrite'       => true,
		                    'query_var'     => true,
	                    ] );
}

function si_past_link( $attr ) {
	$params         = shortcode_atts( [
		                                  'link' => '',
		                                  'text' => '',
		                                  'type' => 'link'
	                                  ],
	                                  $attr );
	$params['text'] = $params['text'] ? $params['text'] : $params['link'];

	if ( $params['link'] ) {
		$protocol = '';
		switch ( $params['type'] ) {
			case 'email':
				$protocol = 'mailto:';
				break;
			case 'phone';
				$protocol       = 'tel:';
				$params['link'] = preg_replace( '/[^+0-9]/', '', $params['link'] );
				break;
			default:
				$protocol = '';
				break;
		}
		$link = $protocol . $params['link'];
		$text = $params['text'];

		return "<a href=\"{$link}\"> {$text} </a>";
	} else {
		return '';
	}
}

function si_meta_boxes() {
	add_meta_box(
		'si-like',
		'Количество лайков:',
		'si_meta_like_cb',
		'post'
	);
}

function si_meta_like_cb( $post_obj ) {
	$likes = get_post_meta( $post_obj->ID, 'si-like', true );
	$likes = $likes ? $likes : 0;
	echo "<input type='text' name='si-like' value=\"{$likes}\">";
//	echo '<p>' . $likes . '</p>';
}

function si_save_likes_meta( $post_id ) {
	if ( isset( $_POST['si-like'] ) ) {
		update_post_meta( $post_id, 'si-like', $_POST['si-like'] );
	}
}


