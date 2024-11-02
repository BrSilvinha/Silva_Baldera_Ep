# Pruebas Unitarias con PHPUnit

Este repositorio incluye pruebas unitarias para las clases `Producto` y `Pedido` utilizando PHPUnit. A continuación se presentan los comandos para ejecutar pruebas específicas.

## Comandos para ejecutar pruebas de Producto

Para ejecutar pruebas relacionadas con la clase `Producto`, utiliza los siguientes comandos:

- **Registrar un producto:**
  ```bash
  vendor\bin\phpunit --bootstrap vendor/autoload.php tests/ProductoTest.php --filter testRegistrarProducto

- **Modificar un producto:**
  ```bash
  vendor\bin\phpunit --bootstrap vendor/autoload.php tests/ProductoTest.php --filter testModificarProducto

- **Eliminar un producto:**
  ```bash
    vendor\bin\phpunit --bootstrap vendor/autoload.php tests/ProductoTest.php --filter testEliminarProducto

## Comandos para ejecutar pruebas de PedidoTest
  Para ejecutar las pruebas específicas de `PedidoTest` , utiliza los siguientes comandos:

- **Registrar un pedido con un producto existente:**
    ```bash
    vendor\bin\phpunit --bootstrap vendor/autoload.php tests/PedidoTest.php --filter testRegistrarPedidoConProductoExistente
- **Intentar eliminar un producto de un pedido:**
  ```bash
  vendor\bin\phpunit --bootstrap vendor/autoload.php tests/PedidoTest.php --filter testEliminarProductoDePedido
- **Eliminar un pedido:**
  ```bash
  vendor\bin\phpunit --bootstrap vendor/autoload.php tests/PedidoTest.php --filter testEliminarPedido

#Eliminar todos los datos de todas las tablas (con DELETE)

  ```bash
  DELETE FROM producto;
  DELETE FROM pedido;

