<?php
namespace app\core;

trait QueryBuilder {
	
	protected $columns;
	protected $table;
	protected $distinct = false;
	protected $wheres;
	protected $order;
	protected $orderBy;
    protected $joins;
	protected $limit;
	protected $offset;

	public static function table( $table_name ) {
		$db = new self;
		$db->table = $table_name;
		return $db;
	}

	public function select( $columns ) {
		$this->columns = is_array( $columns ) ? $columns : [$columns];
		return $this;
	}

	public function distinct() {
		$this->distinct = true;
		return $this;
	}

	public function where( $column, $operator, $value) {
		$this->wheres[] = [ 
            'col'        => $column, 
            'operator'   => $operator, 
            'value'      => $value,
            'connect'    => 'and' 
        ];
		return $this;
	}
    public function order( $column, $oderBy = 'ASC' ) {
		$this->order = ['order' => $column, 'orderBy' => $oderBy];
		return $this;
	}
    
	public function join( $table, $first, $operator, $second, $type = 'inner' ) {
		$this->joins = [ 
            'table'     => $table,
            'first'     => $first,
            'operator'  => $operator,
            'second'    => $second,
            'type'      => $type 
        ];
		return $this;
	}

	public function leftJoin( $table, $first, $operator, $second ) {
		return $this->join( $table, $first, $operator, $second, 'left' );
	}

	public function rightJoin( $table, $first, $operator, $second ) {
		return $this->join( $table, $first, $operator, $second, 'right' );
	}		

	public function limit( $limit ) {
		$this->limit = $limit;
		return $this;
	}

	public function offset( $offset ) {
		$this->offset = $offset;
		return $this;
	}

	public function get() {

		return $this->table;

		if( !isset( $this->table ) || empty( $this->table )) {
			return false;
		}

		$sql = $this->distinct ? "SELECT distinct " : "SELECT ";

		if( isset( $this->columns ) && is_array( $this->columns ) ) {
			$sql .= implode(' ,', $this->columns );
		}else {
			$sql .= " *";
		}

		$sql .= " FROM ". $this->table;

		if( isset( $this->joins ) && is_array( $this->joins ) ) {
			foreach ( $this->joins as $join ) {
				switch ( end($join) ) {
					case 'inner':
						$sql.= " INNER JOIN";
						break;
					case 'left':
						$sql.= " LEFT JOIN";
						break;
					case 'right':
						$sql.= " RIGHT JOIN";
						break;
					default:
						$sql.= " INNER JOIN";
						break;
				}
				$sql .= " $join[0] ON $join[1] $join[2] $join[3]";
			}
		}

		if( isset( $this->wheres ) && is_array( $this->wheres ) ) {
			$sql .= " WHERE ";
			foreach ($this->wheres as $where_key => $where) {
				$sql .= " $where[0] $where[1] $where[2]";
				if( $where_key < count( $this->wheres ) -1 ) {
					$sql .= strtolower( $where[3] ) === 'and' ? ' AND' : ' OR';
				}
			}
		}

		if( isset( $this->groups ) && is_array( $this->groups ) ) {
			$sql .= " GROUP BY" .implode( ' ,', $this->groups );
		}

		if( isset( $this->havings ) && is_array( $this->havings ) ) {
			$sql .= " HAVING";
			foreach ($this->havings as $having_key => $having) {
				$sql .= " $having[0] $having[1] $having[2]";
				if( $where_key < count( $this->havings ) -1 ) {
					$sql .= strtolower( $having[3] ) === 'and' ? ' AND' : ' OR';
				}
			}
		}

		if( isset( $this->orders ) && is_array( $this->orders ) ) { 
			$sql .= " ORDER BY";
			foreach ($this->orders as $order_key => $order) {
				$sql .= " $order[0] $order[1]";
				if( $where_key < count( $this->havings ) -1 ) {
					$sql .= " ,";
				}
			}
		}

		if( isset( $this->limit ) ) {
			$sql .= " LIMIT $this->limit";
		}

		if( isset( $this->offset ) ) {
			$sql .= " OFFSET $this->offset";
		}

		

		$result = $this->query( $sql );

		$data = [];
		if ($result->num_rows > 0) {
		  while($row = $result->fetch_assoc()) {
		    $data[] = $row;
		  }
		  return $data;
		} else {
		  return "0 results";
		}

	}
}