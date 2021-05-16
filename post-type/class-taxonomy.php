<?php

namespace NikolayS93\PostTypeHelper;

class Taxonomy implements Taxonomy_Register_Data {

	private $slug = '';
	private $args = array();

	public function __construct( $slug, array $args ) {
		$this->slug = $slug;
		$this->args = $args;
	}

	public function slug() {
		return $this->slug;
	}

	public function args() {
		return $this->args;
	}
}
