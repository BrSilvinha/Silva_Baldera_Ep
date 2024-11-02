<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use src\Pedido;
use src\Producto;
use mysqli;

class PedidoTest extends TestCase {
    private $conexion;
    private $pedido;
    private $producto;

    protected function setUp(): void {
        $this->conexion = new mysqli("localhost", "root", "", "calidad_software");
        // Verificar la conexión
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }

        $this->pedido = new Pedido($this->conexion);
        $this->producto = new Producto($this->conexion);
    }

    // Registrar un pedido con un producto existente
    public function testRegistrarPedidoConProductoExistente() {
        // Registrar un producto
        $this->producto->registrar("Test_Pedido_Con_Producto", 12.99);
        $ultimoIdProducto = $this->conexion->insert_id;

        // Registrar un pedido con el producto existente
        $resultado = $this->pedido->registrar($ultimoIdProducto);
        $this->assertTrue($resultado, "El pedido debería haberse registrado correctamente.");
    }

    // Intentar eliminar un producto que está asociado a un pedido
    public function testEliminarProductoDePedido() {
        // Registrar un producto y un pedido
        $this->producto->registrar("Test_Eliminar_Producto", 15.99);
        $ultimoIdProducto = $this->conexion->insert_id;
        $this->pedido->registrar($ultimoIdProducto);
        $ultimoIdPedido = $this->conexion->insert_id; // Obtener ID del pedido registrado

        // Intentar eliminar el producto
        try {
            $resultado = $this->producto->eliminar($ultimoIdProducto); // Método que debería fallar
            $this->assertFalse($resultado, "El producto no debería poder eliminarse mientras esté asociado a un pedido.");
        } catch (\mysqli_sql_exception $e) {
            $this->assertStringContainsString('Cannot delete or update a parent row', $e->getMessage());
        }

        // Limpiar: primero elimina el pedido
        $this->pedido->eliminar($ultimoIdPedido); // Eliminar el pedido

        // Luego intenta eliminar el producto
        $resultado = $this->producto->eliminar($ultimoIdProducto);
        $this->assertTrue($resultado, "El producto debería haberse eliminado correctamente.");
    }

    // Eliminar un pedido
    public function testEliminarPedido() {
        // Registrar un producto y un pedido
        $this->producto->registrar("Test_Pedido_Eliminar", 19.99);
        $ultimoIdProducto = $this->conexion->insert_id;
        $this->pedido->registrar($ultimoIdProducto);
        $ultimoIdPedido = $this->conexion->insert_id; // Obtener ID del pedido registrado

        // Eliminar el pedido
        $resultado = $this->pedido->eliminar($ultimoIdPedido);
        $this->assertTrue($resultado, "El pedido debería haberse eliminado correctamente.");
    }

    protected function tearDown(): void {
        // Limpiar la conexión
        $this->conexion->close();
    }
}
