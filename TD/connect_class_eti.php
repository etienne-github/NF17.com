<?php
    class Connect 
    {
        var $fHost;
        var $fPort;
        var $fDbname;
        var $fUser;
        var $fPassword;
        var $fConn;
        function __construct () {
            $this->fHost="tuxa.sme.utc";
            $this->fPort="5432";
            $this->fDbname="dbnf17p066";
            $this->fUser="nf17p066";
            $this->fPassword="CANUTa7q";
        }
        
function mConnect()
{
$this->fConn = pg_connect("host=$this->fHost port=$this->fPort dbname=$this->fDbname user=$this->fUser password=$this->fPassword") or die(' echec de la connexion:'.pg_last_error());
}

function mClose(){
pg_close($this->fConn);
}
}
?>