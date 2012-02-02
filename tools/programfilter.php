<?php 
require('connectdb.php');

// used to filter programs on organization or level
class ProgramFilterList {
    private $filters = array();
    
    public function addFilter($column, $value) {
        $this->filters[$column] = $value;
    }
    
    public function getArray($groupIndex, $idIndex) {
        global $dbcon;
        $query = $this->getQuery();
        $result = mysql_query($this->getQuery(), $dbcon);
        if (!$result)
            return false;
        
        $values = array();
        while ($row = mysql_fetch_row($result)) {
            $values[$row[$groupIndex]][$row[$idIndex]] = $row;
        }
        return $values;
    }
    
    // returns the query that matches the filters
    private function getQuery() {
        $query = "SELECT programs.id, programs.name, orgs.id, orgs.name, programs.level\n".
            "FROM programs JOIN orgs ON (programs.org_id=orgs.id)\nWHERE ";
        foreach ($this->filters as $col => $val) {
            $query .= "$col='$val' &&\n";
        }
        $query = rtrim($query, "&\n");
        
        return $query;
    }
}

?>