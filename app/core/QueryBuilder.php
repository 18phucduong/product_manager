<?php
namespace app\core;

trait QueryBuilder {
	
	protected $columns;
	protected $table;
	protected $distinct = false;
	protected $wheres;
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
    public function orderBy( $column, $oder = 'ASC' ) {
		$this->orderBy = ['col' => $column, 'order' => $oder];
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
				switch ( $join['type'] ) {
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
				$table = $join['table'];
				$first = $join['first'];
				$operator = $join['operator'];
				$second = $join['second'];
				$sql .=  " ON $table  $first $operator $second";
			}
		}

		if( isset( $this->wheres ) && is_array( $this->wheres ) ) {
			$sql .= " WHERE ";
			foreach ($this->wheres as $where_key => $where) {
				$col =  $where['col'];
				$operator =  $where['operator'];
				$value =  $where['value'];
				$sql .= " $col $operator $value";

				if( $where_key < count( $this->wheres ) -1 ) {
					$sql .= strtolower( $where['connect'] ) === 'and' ? ' AND' : ' OR';
				}
			}
		}

		if( isset( $this->orderBy  ) ) { 
			$oderBy =  $this->orderBy['column'];
			$oder =  $this->orderBy['order'];
			$sql .= " ORDER BY $oderBy $oder ";
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