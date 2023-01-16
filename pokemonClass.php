<?php
class Pokemon
{
    private $nombre;
    private $foto;
    private $tipos = [];
    private $habilidades = [];
    private $vida ;

    function __construct($nombre,$foto,$tipos,$habilidades,$vida)
    {
    	$this->nombre = $nombre;
    	$this->foto = $foto;
    	$this->tipos = $tipos;
    	$this->habilidades = $habilidades;
        $this->vida = $vida;
    }

    public function printNombre() 
    {
    	return $this->nombre;
    }

    public function printFoto() 
    {
    	return $this->foto;
    }

    public function printTipos() 
    {
    	return $this->tipos;
    }

    public function printHabilidades() 
    {
    	return $this->habilidades;
    }

    public function printVida() 
    {
    return $this->vida;
    }
}

?>