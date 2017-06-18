<?php

/**
 * Node visitor class.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */

namespace WP_Deprecated_Code_Scanner;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

/**
 * A node visitor that searches for deprecated elements.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */
class NodeVisitor extends NodeVisitorAbstract {

	/**
	 * The collection of deprecated elements discovered.
	 *
	 * @since 0.1.0
	 *
	 * @var Collector
	 */
	protected $collector;

	/**
	 * The functions that we are searching for that indicate a deprecated element.
	 *
	 * @since 0.1.0
	 *
	 * @var array[]
	 */
	protected $functions;

	/**
	 * The current function definition that we are in.
	 *
	 * @since 0.1.0
	 *
	 * @var Node\Stmt\Function_
	 */
	protected $current_function;

	/**
	 * The current class definition that we are in.
	 *
	 * @since 0.1.0
	 *
	 * @var Node\Stmt\Function_
	 */
	protected $current_class;

	/**
	 * The current method definition that we are in.
	 *
	 * @since 0.1.0
	 *
	 * @var Node\Stmt\Function_
	 */
	protected $current_method;

	/**
	 * @since 0.1.0
	 *
	 * @param Collector $collector The collector to collect deprecated elements in.
	 * @param Config    $config    The scanner config.
	 */
	public function __construct( Collector $collector, Config $config ) {
		$this->collector = $collector;
		$this->functions = $config->get_functions();
	}

	/**
	 * @since 0.1.0
	 */
	public function enterNode( Node $node ) {

		// Check if we are entering a particular scope.
		if ( $node instanceof Node\Stmt\Function_ ) {
			$this->current_function = $node;
			return;
		}

		if ( $node instanceof Node\Stmt\Class_ ) {
			$this->current_class = $node;
			return;
		}

		if ( $node instanceof Node\Stmt\ClassMethod ) {
			$this->current_method = $node;
			return;
		}

		// Otherwise, if this isn't a function call we don't care about it.
		if ( ! $node instanceof Node\Expr\FuncCall ) {
			return;
		}

		// If we can't get the function name, don't bother continuing.
		if ( ! method_exists( $node->name, 'toString' ) ) {
			return;
		}

		$function_name = $node->name->toString();

		// Check if this is a function that indicates an element is deprecated.
		if ( ! isset( $this->functions[ $function_name ] ) ) {
			return;
		}

		$type = $this->functions[ $function_name ]['type'];

		// Get the element name.
		if ( $this->current_function ) {
			$element = $this->current_function->name;
		} elseif ( $this->current_class && $this->current_method ) {
			$element = "{$this->current_class->name}::{$this->current_method->name}";
			$type = 'method';
		} else {
			return;
		}

		$function_data = $this->functions[ $function_name ];

		// Get the version number.
		if ( ! isset( $node->args[ $function_data['version_arg'] ] ) ) {
			return;
		}

		$version_arg = $node->args[ $function_data['version_arg'] ];

		if (
			$version_arg->value instanceof Node\Scalar\String_
			|| $version_arg->value instanceof Node\Scalar\LNumber
			|| $version_arg->value instanceof Node\Scalar\DNumber
		) {

			$version = (string) $version_arg->value->value;

		} else {

			$version = '?';
		}

		// Get the alternative to this element.
		$alt = null;

		if ( isset( $node->args[ $function_data['alt_arg'] ] ) ) {

			$alt_arg = $node->args[ $function_data['alt_arg'] ];

			if ( $alt_arg->value instanceof Node\Scalar\String_ ) {
				$alt = $alt_arg->value->value;
			}
		}

		$this->collector->add( $element, $type, $version, $alt );
	}

	/**
	 * @since 0.1.0
	 */
	public function leaveNode( Node $node ) {

		if ( $node instanceof Node\Stmt\Function_ ) {
			$this->current_function = null;
		} elseif ( $node instanceof Node\Stmt\ClassMethod ) {
			$this->current_method = null;
		} elseif ( $node instanceof Node\Stmt\Class_ ) {
			$this->current_class = null;
		}
	}
}

// EOF
