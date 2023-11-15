<?php
class SingleColumnFilter implements PHPExcel_Reader_IReadFilter 
{ 
    private $requestedColumn;

    public function __construct($column) {
        $this->requestedColumn = $column;
    }

    public function readCell($column, $row, $worksheetName = '') { 
        if ($column == $this->requestedColumn) { 
            return true; 
        } 
        return false; 
    } 
} 