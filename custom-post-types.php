<?php
/*
 * Define Custom Post Types here.
 */
abstract class CustomPostType {
	public
		$name            = 'custom_post_type',
		$plural_name     = 'Custom Posts',
		$singular_name   = 'Custom Post',
		$add_new_item    = 'Add New Custom Post',
		$edit_item       = 'Edit Custom Post',
		$new_item        = 'New Custom Post',
		$public          = True,
		$use_title       = True,
		$use_editor      = True,
		$use_revisions   = True,
		$use_thumbnails  = False,
		$use_order       = False,
		$use_metabox     = False,
		$use_shortcode   = False,
		$taxonomies      = array( 'post_tag' ),
		$built_in        = False,
		$default_orderby = null,
		$default_order   = null;

	public function get_objects( $options=array() ) {
		$defaults = array(
			'numberposts' => -1,
			'orderby'     => 'title',
			'order'       => 'ASC',
			'post_type'   => $this->options( 'name' )
		);

		$options = array_merge( $defaults, $options );
		$objects = get_posts( $options );
		return $objects;
	}

	public function get_objects_as_options( $options=array() ) {
		$objects = $this->get_objects( $options );
		$opt = array();
		foreach($objects as $o) {
			switch(True) {
				case $this->options( 'use_title' ):
					$opt[$o->post_title] = $o->ID;
					break;
				default:
					$opt[$o->ID] = $o->ID;
			}
		}
		return $opt;
	}

	public function options( $key ) {
		$vars = get_object_vars( $this );
		return $vars[$key];
	}

	public function fields() {
		return array();
	}

	public function supports() {
		$supports = array();
		if ( $this->options( 'use_title' ) ) {
			$supports[] = 'title';
		}
		if ( $this->options( 'use_order' ) ) {
			$supports[] = 'page-attributes';
		}
		if ( $this->options( 'use_thumbnails' ) ) {
			$supports[] = 'thumbnail';
		}
		if ( $this->options( 'use_editor' ) ) {
			$supports[] = 'editor';
		}
		if ( $this->options( 'use_revisions' ) ) {
			$supports[] = 'revisions';
		}
		return $supports;
	}

	public function labels() {
		return array(
			'name'          => __( $this->options( 'plural_name' ) ),
			'singular_name' => __( $this->options( 'singular_name' ) ),
			'add_new_item'  => __( $this->options( 'add_new_item' ) ),
			'edit_item'     => __( $this->options( 'edit_item' ) ),
			'new_item'      => __( $this->options( 'new_item' ) ),
		);
	}

	public function register() {
		$registration = array(
			'labels'        => $this->labels(),
			'supports'      => $this->supports(),
			'public'        => $this->options( 'public' ),
			'taxonomies'    => $this->options( 'taxonomies' ),
			'_builtin'      => $this->options( 'built_in' )
		);

		if ( $this->options( 'use_order' ) ) {
			$registration = array_merge( $registration, array( 'hierarchical' => True ) );
		}

		register_post_type( $this->options( 'name' ), $registration );
	}

	public function register_fields() {
		$options = array(
			'id'       => $this->options( 'name' ).'_fields',
			'title'    => __( $this->options( 'singular_name' ).' Fields' ),
			'fields'   => array(),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => $this->options( 'name' ),
						'order_no' => 0,
						'group_no' => 0
					)
				)
			),
			'options' => array(
				'position' => 'normal',
				'layout'   => 'default'
			),
			'menu_order' => 0,
		);

		foreach($this->fields() as $field) {
			$opts = array(
				'key'           => $field['id'],
				'label'         => $field['name'],
				'name'          => $field['id'],
				'instructions'  => $field['desc'],
				'required'      => $field['required'] ? $field['required'] : false
			);

			switch( $field['type'] ) {
				case 'text':
					$opts = array_merge( $opts, 
						array(
							'type'          => 'text',
							'default_value' => $field['default'] ? $field['default'] : '',
							'placeholder'   => $field['placeholder'] ? $field['placeholder'] : '',
							'formatting'    => 'html'
						)
					);
					$options['fields'][] = $opts;
					break;
				case 'textarea':
					$opts = array_merge( $opts, 
						array(
							'type'          => 'textarea',
							'default_value' => $field['default'] ? $field['default'] : '',
							'placeholder'   => $field['placeholder'] ? $field['placeholder'] : '',
							'formatting'    => 'html'
						)
					);
					$options['fields'][] = $opts;
					break;
				case 'number':
					$opts = array_merge(
						array(
							'type'          => 'number',
							'default_value' => $field['default'] ? $field['default'] : '',
							'placeholder'   => $field['placeholder'] ? $field['placeholder'] : '',
							'min'           => $field['min'] ? $field['min'] : null,
							'max'           => $field['max'] ? $field['max'] : null
						)
					);
					$options['fields'][] = $opts;
					break;
				case 'email':
					$opts = array_merge(
						array(
							'type'          => 'email',
							'default_value' => $field['default'] ? $field['default'] : '',
							'placeholder'   => $field['placeholder'] ? $field['placeholder'] : '',
						)
					);
					$options['fields'][] = $opts;
					break;
				case 'image':
					$opts = array_merge(
						array(
							'type'          => 'image',
							'save_format'   => $field['save_as'] ? $field['save_as'] : 'object',
							'library'       => $field['library'] ? $field['library'] : 'all',
						)
					);
					$options['fields'][] = $opts;
					break;
				case 'file':
					$opts = array_merge(
						array(
							'type'          => 'file',
							'save_format'   => $field['save_as'] ? $field['save_as'] : 'object',
							'library'       => $field['library'] ? $field['library'] : 'all',
						)

					);
					$options['fields'][] = $opts;
					break;
				case 'select':
					$opts = array_merge( $opts,
						array(
							'type'          => 'select',
							'choices'       => $field['choices'],
							'default_value' => $field['default'] ? $field['default'] : null,
							'allow_null'    => $field['allow_null'] ? $field['allow_null'] : 0,
							'multiple'      => $field['multiple'] ? $field['multiple'] : 0
						)
					);
					$options['fields'][] = $opts;
					break;
				case 'checkbox-list':
					$opts = array_merge( $opts,
						array(
							'type'          => 'checkbox',
							'choices'       => $field['choices'],
							'default_value' => $field['default'] ? $field['default'] : null,
							'layout'        => $field['layout'] ? $field['layout'] : 'vertical'
						)
					);
					$options['fields'][] = $opts;
					break;
				case 'radio':
					$opts = array_merge( $opts,
						array(
							'type'          => 'radio',
							'choices'       => $field['choices'],
							'default_value' => $field['default'] ? $field['default'] : null,
							'layout'        => $field['layout'] ? $field['layout'] : 'vertical'
						)
					);
					$options['fields'][] = $opts;
					break;
				case 'checkbox':
					$opts = array_merge( $opts,
						array(
							'type'          => 'true_false',
							'message'       => $field['name'],
							'default_value' => $field['default'] ? $field['default'] : 0
						)
					);
					$options['fields'][] = $opts;
					break;
			}
		}

		if ( function_exists("register_field_group") ) {
			register_field_group( $options );
		}
	}
}

class Event extends CustomPostType {
	public
		$name          = 'event',
		$plural_name   = 'Events',
		$singular_name = 'Event',
		$add_new_item  = 'Add New Event',
		$edit_item     = 'Edit Event',
		$new_item      = 'New Event',
		$public        = True,
		$use_editor    = True,
		$use_thumbnail = True,
		$use_order     = False,
		$use_title     = True,
		$use_metabox   = True;

	public function fields() {
		$prefix = $this->options('name').'_';
		return array(
			array(
				'name' => 'Test Text',
				'desc' => 'The starting date of the event',
				'id'   => $prefix.'start_date',
				'type' => 'text'
			),
			array(
				'name' => 'Test Text Area',
				'desc' => 'The ending date of the event',
				'id'   => $prefix.'end_date',
				'type' => 'textarea'
			),
			array(
				'name' => 'Test File Field',
				'desc' => 'This is a file field.',
				'id'   => $prefix.'file',
				'type' => 'file'
			),
			array(
				'name' => 'Test Image Field',
				'desc' => 'This is an image field.',
				'id'   => $prefix.'image',
				'type' => 'image'
			),
			array(
				'name' => 'Test Checkbox List',
				'desc' => 'This is a checkbox list.',
				'id'   => $prefix.'checkbox-list',
				'type' => 'checkbox-list',
				'choices' => array(
					'choice1',
					'choice2'
				)
			),
			array(
				'name' => 'Test Select',
				'desc' => 'This is a test select field.',
				'id'   => $prefix.'select',
				'type' => 'select',
				'choices' => array(
					'choice1',
					'choice2'
				)
			),
			array(
				'name' => 'Test Radio',
				'desc' => 'This is a test radio field.',
				'id'   => $prefix.'radio',
				'type' => 'radio',
				'choices' => array(
					'choice1',
					'choice2'
				)
			),
			array(
				'name' => 'Test Checkbox',
				'desc' => 'This is a test checkbox.',
				'id'   => $prefix.'checkbox',
				'type' => 'checkbox'
			)
		);
	}

	public function register_fields() {
		parent::register_fields();
	}
}

?>