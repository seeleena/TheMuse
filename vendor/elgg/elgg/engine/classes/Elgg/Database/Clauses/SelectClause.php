<?php

namespace Elgg\Database\Clauses;

use Doctrine\DBAL\Query\Expression\CompositeExpression;
use Elgg\Database\QueryBuilder;

/**
 * Extends QueryBuilder with SELECT clauses
 */
class SelectClause extends Clause {

	/**
	 * @var \Closure|CompositeExpression|string
	 */
	public $expr;

	/**
	 * Constructor
	 *
	 * @param CompositeExpression|\Closure|string $expr Expression
	 */
	public function __construct($expr) {
		$this->expr = $expr;
	}

	/**
	 * {@inheritdoc}
	 */
	public function prepare(QueryBuilder $qb, $table_alias = null) {
		$select = $this->expr;

		if ($this->isCallable($select)) {
			$select = $this->call($this->expr, $qb, $table_alias);
		}

		if ($select instanceof CompositeExpression || is_string($select)) {
			$qb->addSelect($select);
		}
	}
}
