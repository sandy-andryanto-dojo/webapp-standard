<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Database_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }

    public function sync_index(){
        $sql_index = "
			select index_schema,
				index_name,
				group_concat(column_name order by seq_in_index) as index_columns,
				index_type,
				case non_unique
					when 1 then 'Not Unique'
					else 'Unique'
					end as is_unique,
				table_name
			from information_schema.statistics
			where index_schema = '".$this->db->database."' AND index_name !='PRIMARY'
			group by index_schema,
					index_name,
					index_type,
					non_unique,
					table_name
			order by index_schema,
					index_name;
		";
		$result_index =  $this->db->query($sql_index)->result_array();
		if(count($result_index) > 0){
			foreach($result_index as $row){
				$index_name = $row["index_name"];
				$table_name = $row["table_name"];
				$this->db->query("DROP INDEX ".$index_name." ON ".$this->db->database.".".$table_name.";  ");
			}
		}


        $sql = "
		select 
			b.TABLE_NAME,
			a.COLUMN_NAME,
			a.DATA_TYPE,
			b.TABLE_TYPE
		from information_schema.columns  as a
			INNER JOIN information_schema.TABLES as b ON b.TABLE_SCHEMA = a.TABLE_SCHEMA
			WHERE a.TABLE_SCHEMA = '".$this->db->database."'
			AND a.DATA_TYPE IN ('bigint','datetime','varchar','smallint','timestamp','int','tinyint','char')
			AND a.COLUMN_NAME != 'id'
			AND b.TABLE_TYPE != 'VIEW'
			AND a.TABLE_NAME = b.TABLE_NAME
        ";
        $result =  $this->db->query($sql)->result_array();
        if(count($result) > 0){
            foreach($result as $row){
                $table_name = $row["TABLE_NAME"];
                $column_name = $row["COLUMN_NAME"];
                $data_type = $row["DATA_TYPE"];
                $index_name = strtolower($table_name)."_".strtolower($column_name)."_idx";
                $this->db->query("CREATE INDEX ".$index_name." ON ".$table_name."(".$column_name.") USING BTREE;");
            }
        }
    }

}
