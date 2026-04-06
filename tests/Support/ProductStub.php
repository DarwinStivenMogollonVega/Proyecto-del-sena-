<?php
namespace Tests\Support;

class ProductStub
{
    public $id;
    public $nombre;
    public $imagen;
    public $precio;
    public $descuento = 0;
    public $cantidad = 0;
    public $resenas_avg_puntuacion = 0;
    public $resenas_count = 0;
    public $categoria;
    public $formato;
    public $artista;
    public $proveedor;
    public $descripcion = '';
    public $codigo = 'SKU-1';
    public $anio_lanzamiento = null;
    public $resenas = [];

    public function __construct($id = 1)
    {
        $this->id = $id;
        $this->nombre = 'Producto ' . $id;
        $this->precio = 10.00;
    }

    public function getKey()
    {
        return $this->id;
    }
}
