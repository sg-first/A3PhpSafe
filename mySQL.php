<?php
//对MySQL进行了一些封装，用函数的方式调用防止潜在的注入风险
class mySQL
{
    private $con;

    function __construct($localhost, $account, $password)
    {
        $this->con = mysql_connect($localhost, $account, $password);
        if (!$this->con)
        {return mysql_error();}
        return true;
    }

    function __destruct()
    {
        mysql_close($this->con);
    }

    public function create_mysql($db)
    {
        if (mysql_query("CREATE DATABASE ".$db,$this->con))
        {return true;}
        else
        {return mysql_error();}
    }

    public function create_table($db, $table_name, $table_item)
    //FORMATION
        /*CREATE TABLE table_name
        (
        column_name1 data_type,
        column_name2 data_type,
        column_name3 data_type,
        .......
        )*/
    //FORMATION
    {
        mysql_select_db($db, $this->con);
        $sql_create_table = "CREATE TABLE " . $table_name . "(" . $table_item . ")";
        mysql_query($sql_create_table, $this->con);
    }

    public function insert_into_mysql($db, $table_name, $colum, $value)
        /*INSERT INTO table_name (column1, column2,...)
        VALUES (value1, value2,....)*/
    {
        mysql_select_db($db, $this->con);
        $result = mysql_query("INSERT INTO " . $table_name . "(" . $colum . ") VALUES (" . $value . ")", $con);
        if (!$result)
        {return mysql_error();}
        else
        {return true;}
    }

    public function mysql_select($db, $table_name)
    {
        mysql_select_db($db, $this->con);
        $result = mysql_query("SELECT * FROM " . $table_name);
        if ($row = mysql_fetch_array($result))
        {return $row;}
        else
        {return false;}
    }

    public function mysql_where($db, $table_name, $column_operator_value)
        /*e.t. $column_operator_value= FirstName="Peter"*/
    {
        mysql_select_db($db, $this->con);
        $result = mysql_query("SELECT * FROM " . $table_name . " WHERE " . $column_operator_value);
        if ($row = mysql_fetch_array($result))
        {return $row;}
        else
        {return false;}
    }

    public function mysql_order_by($db, $table_name,$desc,$bywhat)
        /*SELECT column_name(s)
        FROM table_name
        ORDER BY column_name1, column_name2*/
    {
        mysql_select_db($db, $this->con);
        $sql = "SELECT * FROM " . $table_name . " ORDER BY " . $bywhat;

        if ($desc==false)//升序
        {$result = mysql_query($sql);}
        else
        {$result = mysql_query($sql." DESC");}//降序

        if ($row = mysql_fetch_array($result))
        {return $row;}
        else
        {return false;}
    }

}