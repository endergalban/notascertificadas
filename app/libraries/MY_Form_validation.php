<?php

class MY_Form_validation extends CI_Form_validation{

    public function edit_unique($str, $field)
    {
        sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field, $fieldid ,$id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, ''.$fieldid.' !=' => $id))->num_rows() === 0)
            : FALSE;
    }

    public function valid_date($date)
    {
		$day = (int) substr($date, 0, 2);
		$month = (int) substr($date, 3, 2);
		$year = (int) substr($date, 6, 4);
		return checkdate($month, $day, $year);
	}


}
