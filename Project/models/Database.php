<?php
class Database
{
    protected $db_host = '';
    protected $db_user = '';
    protected $db_password = '';
    protected $db_name = '';
    protected $db_link = '';
    protected $result = 0;

    function __construct($db_host = '', $db_user = '', $db_password = '', $db_name = '')
    {
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_password = $db_password;
        $this->db_name = $db_name;
    }

    function open()
    {
        $this->db_link = mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_name);
    }

    function execute($query = "")
    {
        $this->result = mysqli_query($this->db_link, $query);

        return $this->result;
    }

    function executePrepared($query, $types = "", $params = [])
    {
        $stmt = mysqli_prepare($this->db_link, $query);
        if ($types !== "") {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        $success = mysqli_stmt_execute($stmt);
        // false untuk INSERT/UPDATE/DELETE, mysqli_result untuk SELECT
        $this->result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        return $success;
    }

    function getResult()
    {
        return mysqli_fetch_array($this->result);
    }

    function close()
    {
        mysqli_close($this->db_link);
    }
}

?>