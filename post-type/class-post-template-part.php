<?php

namespace NikolayS93\PostTypeHelper;

trait Post_Template_Part {

	public static function template_part() {
		$class = new self;
		get_template_part( 'template-parts/content', $class->slug() );
	}
}
