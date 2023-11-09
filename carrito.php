<?php require_once "config/conexion.php";
require_once "config/config.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Carrito de Compras</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/devstec.ico" />
    <!-- Bootstrap icons-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" /> -->
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/estilos.css" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <!-- <div class="container text-center">
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">
            <img src="assets/peru.webp" alt="devs tec" width="150">
        </a>
                  
    </nav>
    </div> -->
    <!-- Header-->
    <header class="bg-primary py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bold">Detalle de Compra</h1>
                <p class="lead fw-normal text-white-50 mb-4">Tus Productos Agregados</p>
                <!-- <a href="#" class="btn btn-light btn-lg explore-link">Explora Ahora</a> -->
            </div>
        </div>
    </header>
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Imagen</th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody id="tblCarrito">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-5 ms-auto">
                    <h4>Total a Pagar: <span id="total_pagar">0.00</span></h4>
                    <div class="d-grid gap-2">
                        <div id="paypal-button-container" class="centrar"></div>
                        <button class="btn btn-warning" type="button" id="btnVaciar">Vaciar Carrito</button>
                    </div>
                    <!-- Agrega este botón a tu página HTML donde desees que aparezca -->


                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-3 bg-primary">
        <div class="container">
            <p class="m-2 text-center text-white">Copyright &copy; Your DevTec 2023</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <!-- <script src="https://www.paypal.com/sdk/js?client-id=<?php //echo CLIENT_ID; 
                                                                ?>&locale=<?php //echo LOCALE; 
                                                                            ?>"></script> -->
    <script src="assets/js/scripts.js"></script>
    <script>    

        mostrarCarrito();

        function mostrarCarrito() {
            if (localStorage.getItem("productos") != null) {
                let array = JSON.parse(localStorage.getItem('productos'));
                if (array.length > 0) {
                    $.ajax({
                        url: 'ajax.php',
                        type: 'POST',
                        async: true,
                        data: {
                            action: 'buscar',
                            data: array
                        },
                        success: function(response) {
                            // Manejar la respuesta del servidor
                            try {
                                const res = JSON.parse(response);

                                // Construir la tabla de productos
                                let html = `
                                <table>
                                    <thead>
                                        <tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                            `;
                                res.datos.forEach(element => {
                                    html += `
                                    <tr>
                                        <td>${element.id}</td>
                                        <td><img src="assets/img/${element.imagen}" alt="Imagen 1" width="30" height="30"></td>
                                        <td>${element.nombre}</td>
                                        <td>${element.precio}</td>
                                        <td>cantidad</td>
                                        <td>${element.precio}</td>
                                    </tr>
                                `;
                                });
                                html += `</tbody></table>`;
                                $('#tblCarrito').html(html);

                                // Mostrar el total a pagar
                                $('#total_pagar').text(res.total);

                                // Agregar un botón para enviar por WhatsApp
                                $('#paypal-button-container').html(`
                                <button id="btnEnviarWhatsApp" class="btn btn-success">    Enviar carrito por WhatsApp     </button>
                            `);

                                // Agregar un controlador de eventos al botón de WhatsApp
                                $('#btnEnviarWhatsApp').click(function() {
                                    enviarPorWhatsApp(res);
                                });
                            } catch (error) {
                                console.error("Error al procesar la respuesta del servidor", error);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error en la solicitud AJAX", error);
                        }
                    });
                }
            }
        }

        function enviarPorWhatsApp(carrito) {
            let mensajeWhatsApp = '*DESEO COMPRAR ESTOS PRODUCTOS*:\n\n';

            // Agregar una tabla con encabezados
            mensajeWhatsApp += 'Producto    ||    Precio\n';
            mensajeWhatsApp += '-------------------------------------\n';

            // Agregar los detalles de los productos a la tabla
            carrito.datos.forEach(element => {
                mensajeWhatsApp += `${element.nombre}  ||  *Precio*: ${element.precio}\n`;
            });
            mensajeWhatsApp += '-------------------------------------\n';
            mensajeWhatsApp += '-------------------------------------\n';

            mensajeWhatsApp += `*Total a pagar:* ${carrito.total}`;

            // Generar el enlace de WhatsApp con el mensaje
            const enlaceWhatsApp = `https://wa.me/+51996068659/?text=${encodeURIComponent(mensajeWhatsApp)}`;

            // Redirigir al usuario a WhatsApp
            window.location.href = enlaceWhatsApp;
        }
    </script>


</body>

</html>