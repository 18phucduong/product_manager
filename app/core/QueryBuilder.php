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

	public static function table( $tableName ) {
		$db = self::getInstance();
		$db->table = $tableName;
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
            'value'      => sqlValueFormatting($value),
            'connect'    => 'AND' 
        ];
		return $this;
	}
	public function orWhere( $column, $operator, $value) {
		$this->wheres[] = [ 
            'col'        => $column, 
            'operator'   => $operator, 
            'value'      => sqlValueFormatting($value),
            'connect'    => 'OR' 
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
		if( !isset( $this->table ) || empty( $this->table )) {
			return false;
		}

		$sql = $this->distinct ? "SELECT distinct " : "SELECT ";

		if( isset( $this->columns ) && is_array( $this->columns ) ) {
			$sql .= implode(' ,', $this->columns );
		}else {
			$sql .= " $this->columns";
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

				if( $where_key > 0 ) {
					$sql .=  $where['connect'];
				}
				$sql .= " $col $operator $value ";
			}
		}

		if( isset( $this->orderBy  ) ) { 
			$oderBy =  $this->orderBy['col'];
			$oder =  $this->orderBy['order'];
			$sql .= " ORDER BY $oderBy $oder ";
		}

		if( isset( $this->limit ) ) {
			$sql .= " LIMIT $this->limit";
		}

		if( isset( $this->offset ) ) {
			$sql .= " OFFSET $this->offset";
		}
		$result = $this->query($sql);
		$this->resetQueryProperties();
		if ($result->num_rows > 0) {
		  while($row = $result->fetch_assoc()) {
		    $data[] = $row;
		  }
		  return $data;
		} else {
		  return 'false';
		}
	}
	public function delete() {
		if( !isset( $this->table ) || empty( $this->table )) {
			return false;
		}
		$sql = "DELETE FROM $this->table ";

		if( isset( $this->wheres ) && is_array( $this->wheres ) ) {
			$sql .= " WHERE ";
			foreach ($this->wheres as $where_key => $where) {
				$col =  $where['col'];
				$operator =  $where['operator'];
				$value =  $where['value'];

				if( $where_key > 0 ) {
					$sql .=  $where['connect'];
				}
				$sql .= " $col $operator $value ";
			}
		}
		$result = $this->query($sql);

		$this->resetQueryProperties();
		return $result;
	}
	public function insert($insertData, $multiple = false) {
		$insertData = array_filter($insertData);
		$sql = '';
		
		if( !$multiple) {
			$sql .= $this->createInsertSql($insertData);
		}else {
			foreach($insertData as $insertItem) {
				$sql .= $this->createInsertSql($insertItem);
			}
		}
        $result = $this->query($sql);

		$this->resetQueryProperties();
        return $result;
    }
	public function all() {
        return $this->select('*')->get();
    }

    public function findById($id) {
        return $this->select('*')->where('id', '=', $id)->get();
    }

	public function inDataBase($colName, $value){
        $result = $this->select('*')->where($colName, '=', $value)->get();
        return $result != false;
    }

	public function findByCol($colName, $value) {
		return $this->select('*')->where($colName, '=', $value)->get();
	}
	public function newest() {
		return $this->select('*')->limit(1)->get()[0];
	}

	private function resetQueryProperties() {
		$this->table = null;
		$this->wheres = null;
		$this->district = null;
		$this->select = null;
		$this->joins = null;
		$this->limit = null;
		$this->orderBy = null;
		$this->offset = null;
	}
	function createInsertSql($data) {
		
        $tableCols = array_keys($data);
        $tableColsValue = array_values($data);
        $tableColsText = '';

        for( $i=0; $i < count($tableCols); $i++ ) {
            if($i < count($tableCols) -1 ) {
                $tableColsText .= $tableCols[$i] . ', ';
            }else{
                $tableColsText .= $tableCols[$i];
            }
        }
        $tableColsValue_text = '';
        for( $i=0; $i < count($tableColsValue); $i++ ) {
            $value = sqlValueFormatting($tableColsValue[$i]);

            $tableColsValue_text .= ($i < count($tableColsValue) -1 ) ?  ( $value . ', ') : $value;
        }
        return  "INSERT INTO $this->table ( $tableColsText )
        VALUES ( $tableColsValue_text );";
	}

	public function pagination($postPerPages = null, $currentPage = 1) {
		$table = $this->table;

		$postPerPages = !empty( $postPerPages ) ? $postPerPages : 5;
		$pageOffset = ($currentPage - 1) * $postPerPages;
		$items =  $this->select(' *')->orderBy('id', 'DESC')->limit($postPerPages)->offset($pageOffset)->get();
		$this->table = $table;
		$totalItem = $this->select(' COUNT(id)')->get()[0]['COUNT(id)'];
		$totalPage = ceil($totalItem/$postPerPages);
		return [
			'perPage' => $postPerPages,
			'page'    => $currentPage,
			'pages'    => $totalPage,
			'items'   => $items
		];
	}
}

