<?php
include 'db.php';

class CRUD{
    private $pdo;

    function __construct($pdo) {
        $this -> pdo = $pdo;
    }

    public function select($table, $columns = [], $where = [],  $limit, $sort){
        $where = $this->where($where);
        $kolonat = $this->columns($columns);
        $limit = ($limit > 0) ? ' LIMIT  ' .$limit  :  ' ';
        $sort = ($sort == '') ? ' ORDER BY id DESC  '  : ' ORDER BY ' . $sort . ' ';
        $sql = "SELECT $kolonat FROM $table $where $sort $limit";
        // print_r($sql);
        // die();

        return $this->pdo->query($sql);
    }

    public function insert($table, $columns=[],$values=[]){

        $kolonat = implode(",", $columns);
        $vlerat = str_repeat("?, ", count($columns));
        $vlerat = rtrim($vlerat,", ");

        $sql = "INSERT INTO $table ($kolonat) VALUES ($vlerat);";
        

        $query = $this->pdo->prepare($sql);

        return $query->execute($values);

    }

    public function search($table, $columns = [],$where = []){
        $kolonat = $this->columns($columns);
        $wherelike = $this->wherelike($where);
        $sql = " SELECT $kolonat FROM $table $wherelike ";
        // echo $sql;
        // die();
        return $this->pdo->query($sql);
        // $query = $this->pdo->prepare($sql);
        // return $query->execute($values);
        // SELECT $kolonat FROM $table where column like %?% and column like %?% ?
    }

    public function update($table, $columns = [], $values = [], $where = []){
        $where = $this->where($where);
        $kolonat = implode("= ? , ", $columns).  " = ?  " ;
        $sql = "UPDATE $table SET $kolonat $where ";
        // echo $sql;
        // die();
        $query = $this->pdo->prepare($sql);
        return $query->execute($values);
        //update from residence set price='test', rooms = '' where id=4;
    }

    // public function delete($table, $columns = [], $values=[]){
    //     //$where = $this->where($where);
    //     $kolonat = implode(" = ?, ", $columns); //id,name,
    //     $vlerat = str_repeat("= ?, ", count($columns));
    //     $vlerat = rtrim($vlerat,", ");


    //     $sql = "DELETE FROM $table WHERE $kolonat $vlerat ";
    //     // echo $sql;
    //     // die();
    //     $query = $this->pdo->prepare($sql);
    //     return $query->execute($values);

    //  //delete from residences where userid=3;   
    // }

    public function delete($table, $column, $value){
        $where_statement = " WHERE $column = ? ";
        $sql = " DELETE FROM $table $where_statement ";
        // print_r($sql);
        // die();
        $query = $this->pdo->prepare($sql);
        return $query->execute([$value]); 

    }

    private function wherelike($where = []){
        $wherelike_statement = '';
        if(count($where)>0){
            $wherelike_statement .= ' WHERE ';
            $counter = 0;
            foreach($where as $column => $value){
                if($counter < count($where) - 1 ){
                    $wherelike_statement .= " $column LIKE '%$value%' OR ";
                }else{
                    $wherelike_statement .= " $column LIKE '%$value%'  ";
                }
                $counter++;
            }

        }
        return $wherelike_statement;
    }


    public function distinctSelect($table, $column){
        $sql = "SELECT DISTINCT ($column) FROM $table "; 
        return $this->pdo->query($sql);       

    }

    // private function where($where = []){
    //     $where_statement = '';

    //     if(count($where) > 0){
    //         $where_statement .= ' WHERE ';
    //         $counter = 0;
    //         foreach($where as $column => $value){
                
    //             if(count($where)-1 > $counter){
    //                 $where_statement .= " $column = '$value' AND ";
    //                 $counter++;
    //             }else{
    //                 $where_statement .= " $column = '$value'  ";   
    //             }
    //         }
    //     }else{

    //     }


        
    //     return $where_statement;
    // } //OSE

    private function where($where = []) {
        $where_statement = '';
    
        if (count($where) > 0) {
            $where_statement .= ' WHERE ';
            $clauses = [];
    
            foreach ($where as $column => $value) {
                $clauses[] = "$column = '$value'";
            }
    
            $where_statement .= implode(' AND ', $clauses);
        }
    
        return $where_statement;
    }
    private function columns($columns = []){
        //$columns_statement = '';
        if(count($columns) == 0){
            return " * ";
        }
        else{
            return implode(", ", $columns);
        }
    }


    // public function getEnumValues($table, $column){
    //     $c
    // }





}