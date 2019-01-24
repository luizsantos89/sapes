<?php
class Conexao {
    private $servidor_mysql = 'localhost';
    private $nome_banco = 'sapes';
    private $usuario = 'sapes';
    private $senha = 'seti@2018'; 
    private $con;
    
    public function getConexao()
    {
        $this->con = new PDO("mysql:host=$this->servidor_mysql;dbname=$this->nome_banco","$this->usuario", "$this->senha");        
        
        return $this->con;
    }
}
?>