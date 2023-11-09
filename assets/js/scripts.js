$(document).ready(function () {
    let productos = [];  // Una matriz para almacenar los productos seleccionados

    mostrar();  // Llama a la función para actualizar el contador del carrito
    $('.navbar-nav .nav-link[category="all"]').addClass('active');  // Establece 'all' como la categoría activa inicial

    $('.nav-link').click(function () {
        let categoria = $(this).attr('category');  // Obtiene la categoría del elemento en el que se hizo clic

        $('.nav-link').removeClass('active');  // Quita la clase 'active' de todos los elementos de navegación
        $(this).addClass('active');  // Agrega la clase 'active' al elemento en el que se hizo clic

        $('.productos').css('transform', 'scale(0)');  // Escala los elementos de productos para ocultarlos

        function ocultar() {
            $('.productos').hide();  // Oculta los elementos de productos después de un retraso
        }
        setTimeout(ocultar, 400);

        function mostrar() {
            // Muestra los elementos de productos de la categoría seleccionada y los escala para mostrarlos
            $('.productos[category="' + categoria + '"]').show();
            $('.productos[category="' + categoria + '"]').css('transform', 'scale(1)');
        }
        setTimeout(mostrar, 400);  // Muestra los productos después de un retraso
    });

    $('.nav-link[category="all"]').click(function () {
        function mostrarTodo() {
            // Muestra todos los elementos de productos y los escala para mostrarlos
            $('.productos').show();
            $('.productos').css('transform', 'scale(1)');
        }
        setTimeout(mostrarTodo, 400);  // Muestra todos los productos después de un retraso
    });

    $('.agregar').click(function(e){
        e.preventDefault();
        const id = $(this).data('id');  // Obtiene el ID del producto a agregar

        // Verifica si el producto ya existe en el carrito
        let productoExistente = productos.find(producto => producto.id === id);

        if (productoExistente) {
            // Si el producto ya existe, aumenta su cantidad
            productoExistente.cantidad += 1;
        } else {
            // Si el producto no existe, agrégalo con cantidad igual a 1
            productos.push({ id, cantidad: 1 });
        }

        localStorage.setItem('productos', JSON.stringify(productos));  // Almacena la matriz de productos en el almacenamiento local
        mostrar();  // Actualiza el contador de productos en el carrito
    })

    $('#btnCarrito').click(function(e){
        $('#btnCarrito').attr('href','carrito.php');  // Redirige al usuario a la página del carrito al hacer clic en el botón
    })

    $('#btnVaciar').click(function(){
        localStorage.removeItem("productos");  // Elimina los productos almacenados en el almacenamiento local
        $('#tblCarrito').html('');  // Limpia el contenido del carrito en la página
        $('#total_pagar').text('0.00');  // Establece el total a pagar en cero
    })

    //categoria
    $('#abrirCategoria').click(function(){
        $('#categorias').modal('show');  // Muestra un modal de categorías al hacer clic en un botón
    })

    //productos
    $('#abrirProducto').click(function () {
        $('#productos').modal('show');  // Muestra un modal de productos al hacer clic en un botón
    })

    $('.eliminar').click(function(e){
        e.preventDefault();
        if (confirm('¿Está seguro de eliminar?')) {
            this.submit();  // Muestra una confirmación antes de enviar un formulario
        }
    });
});

function mostrar(){
    if (localStorage.getItem("productos") != null) {
        let array = JSON.parse(localStorage.getItem('productos'));
        if (array) {
            // Calcula la cantidad total de productos en el carrito
            let cantidadTotal = array.reduce((total, producto) => total + producto.cantidad, 0);
            $('#carrito').text(cantidadTotal);  // Actualiza el contador de productos en el carrito
        }
    }
}
