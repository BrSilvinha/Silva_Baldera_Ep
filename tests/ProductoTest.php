<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use src\Producto;
use mysqli;

class ProductoTest extends TestCase {
    private $conexion;
    private $producto;

    protected function setUp(): void {
        // Conectar a la base de datos
        $this->conexion = new mysqli("localhost", "root", "", "calidad_software");
        if ($this->conexion->connect_error) {
            die("Connection failed: " . $this->conexion->connect_error);
        }
        // Inicializar la clase Producto
        $this->producto = new Producto($this->conexion);
    }

    public function testRegistrarProducto() {
        // Probar el registro de un producto
        $resultado = $this->producto->registrar("Test_Producto_Registrado", 10.99);
        $this->assertTrue($resultado, "El producto debería haberse registrado correctamente.");
    }

    public function testModificarProducto() {
        // Registrar un producto para asegurarse de que existe
        $this->producto->registrar("Producto_Para_Modificar", 12.99);
        $ultimoIdProducto = $this->conexion->insert_id; // Obtener el ID del producto recién registrado

        // Modificar el producto registrado
        $resultado = $this->producto->modificar($ultimoIdProducto, "Producto Modificado", 15.99);
        $this->assertTrue($resultado, "El producto debería haberse modificado correctamente.");
    }

    public function testEliminarProducto() {
        // Registrar un producto para asegurarse de que existe
        $this->producto->registrar("Producto_Para_Eliminar", 9.99);
        $ultimoIdProducto = $this->conexion->insert_id; // Obtener el ID del producto recién registrado

        // Eliminar el producto registrado
        $resultado = $this->producto->eliminar($ultimoIdProducto);
        $this->assertTrue($resultado, "El producto debería haberse eliminado correctamente.");
    }

    protected function tearDown(): void {
        // Cerrar la conexión a la base de datos
        $this->conexion->close();
    }
}
