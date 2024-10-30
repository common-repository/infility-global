<?php 

class db{	
	
	public static function get_row_count($table, $where=1){	//返回总记录数
		global $wpdb;
		return $wpdb->query("select * from $table where $where");
	}
	
	public static function get_value($table, $where=1, $field='*'){	//分页返回记录
		global $wpdb;
		$row = $wpdb->get_results("select $field from $table where $where limit 0,1",ARRAY_A);

		return $row[0]?current($row[0]):'';
	}

	public static function get_one($table, $where=1, $field='*',$order=1){	//分页返回记录
		global $wpdb;
		$row = $wpdb->get_results("select $field from $table where $where order by $order limit 0,1",ARRAY_A);

		return $row[0]??[];
	}	

	public static function get_all($table, $where=1, $field='*', $order=1,$key=''){	//返回整个数据表
		global $wpdb;
		$row = $wpdb->get_results("select $field from $table where $where order by $order",ARRAY_A);
		$result=array();

		if ($key) {
			foreach ($row as $k => $v) {
				$result[$row[$key]] = $v;
			}
		}else{
			$result = $row;
		}
		return $result;
	}
	
	public static function get_limit($table, $where=1, $field='*', $order=1, $start_row=0, $row_count=20){	//分页返回记录
		global $wpdb;
		$row = $wpdb->get_results("select $field from $table where $where order by $order limit $start_row, $row_count",ARRAY_A);

		return $row;
	}
	
	public static function get_limit_page($table, $where=1, $field='*', $order=1, $page=1, $page_count=20){	//高级形式分页返回记录
		
		$row_count=self::get_row_count($table, $where);

		$total_pages=ceil($row_count/$page_count);
		($page<1 || $page>$total_pages) && $page=1;
		$start_row=($page-1)*$page_count;
		
		return array(
			self::get_limit($table, $where, $field, $order, $start_row, $page_count),
			$row_count,
			$page,
			$total_pages,
			$start_row
		);
	}

    public static function insert_bat($table, $data){	//批量插入记录
    	global $wpdb;
    	
        $field=implode(',', array_keys($data[0]));
        $value=array();
        foreach($data as $v){
            $value[]="'".implode("','", esc_sql($v))."'";
        }
        $value=implode('),(', $value);

        $sql = ("insert into $table($field) values($value)");
        $wpdb->query($sql);
    }

    public static function update_bat($table, $data, $field){	//批量更新数据表
    	global $wpdb;

        $sql='';
        $keys=array_keys($data[0]);
        foreach($keys as $v){
            if($v==$field){continue;}
            $sql.="$v=case $field";
            foreach($data as $v2){
                $sql.=" when '{$v2[$field]}' then '".esc_sql($v2[$v])."'";
            }
            $sql.=' end,';
        }
        $sql=substr($sql, 0, -1);
        $wpdb->query("update $table set $sql where $field in(".ary::ary_format(ary::array_column($data, $field), 2).')');
    }
	
}
 ?>