window.addEventListener("load", function () {
    var paginaActual = 0;
    cargarPagina(0);
    agregarEventoVerInsertar();

    function agregarEventoVerInsertar()
    {
        var elemento = document.getElementById("btverinsertar");
        elemento.addEventListener("click", function ()
        {
            $("#btsiI").unbind("click");
            $("#btsiI").on("click", function ()
            {
                var nombre = document.getElementById("nombre").value;
                var descripcion = document.getElementById("descripcion").value;
                var precio = document.getElementById("precio").value;

                var datos = {
                    nombre: nombre,
                    descripcion: descripcion,
                    precio: precio,
                };
                ajaxInsert(datos);
                $('#myModal').modal('hide');
            });
            $("#btnoI").unbind("click");
            $("#btnoI").on("click", function ()
            {
                $('#myModal').modal('hide');
                tostada("Inserción cancelada", '2');
            });
            $('#myModal').modal('show');
        });
    }

    function ajaxInsert(datos)
    {
        $.ajax({
            url: "ajaxinsert.php",
            //type: "post",
            data: datos,
            success: function (result) {
                if (result.r === 0) {
                    tostada("No se ha podido insertar", '2');
                } else {
                    tostada("Plato Insertado", 1);
                    destruirTabla();
                    construirTabla(result);
                    crearEventos();
                    nombre.value = "";
                    descripcion.value = "";
                    precio.value = "";
                }
                subirImagenes(result);
            },
            error: function () {
                tostada("No se ha podido insertar. Error ajax", '2');
            }
        });
    }

    function cargarPagina(pagina) {
        paginaActual = pagina;
        $.ajax({
            url: "ajaxselect.php?pagina=" + pagina,
            success: function (result) {
                destruirTabla();
                construirTabla(result);
                crearEventos();
            },
            error: function () {
                alert("error al cargar pagina");
            }
        });
    }

    function crearEventos() {
        var enlaces = document.getElementsByClassName("enlace");
        for (var i = 0; i < enlaces.length; i++) {
            agregarEvento(enlaces[i]);
        }

        var enlacesEditar = document.getElementsByClassName("enlace-editar");
        for (var i = 0; i < enlacesEditar.length; i++) {
            agregarEventoEditar(enlacesEditar[i]);
        }

        var enlacesBorrar = document.getElementsByClassName("enlace-borrar");
        for (var i = 0; i < enlacesBorrar.length; i++) {
            agregarEventoBorrar(enlacesBorrar[i]);
        }
    }

    function destruirTabla() {
        var divcarta = document.getElementById("carta");
        while (divcarta.hasChildNodes()) {
            divcarta.removeChild(divcarta.firstChild);
        }
    }

    function agregarEvento(elemento) {
        var datahref = elemento.getAttribute("data-href");
        elemento.addEventListener("click", function (e) {
            cargarPagina(datahref);
        });
    }
    function agregarEventoEditar(elemento) {
        var dataEditar = elemento.getAttribute("data-editar");
        elemento.addEventListener("click", function (e) {
            editar(dataEditar);
        });
    }

    function agregarEventoBorrar(elemento) {
        var mensaje = elemento.getAttribute("data-borrar");
        elemento.addEventListener("click", function () {
            confirmarBorrar(mensaje);
        });
    }

    function editar(dataEditar) {
        $.ajax({
            url: "ajaxget.php?idPlato=" + dataEditar,
            success: function (result) {
                console.log(result.r);
                if (result.r === 0) {
                    tostada("No existe el Plato", 2);
                } else {
                    var nombre = document.getElementById("nombre");
                    var descripcion = document.getElementById("descripcion");
                    var precio = document.getElementById("precio");
                    var imagenes = document.getElementById("imagenes");
                    platoEdit = result.plato;
                    var idPlato = platoEdit.idPlato;
                    nombre.value = platoEdit.nombre;
                    descripcion.value = platoEdit.descripcion;
                    precio.value = platoEdit.precio;
                    mostrarEditar(idPlato, dataEditar);
                }
            },
            error: function () {
                tostada("No existe el plato. Error ajax", '2');
            }
        });

        function mostrarEditar(idPlato, dataEditar) {
            $("#btsiI").unbind("click");
            $("#btsiI").on("click", function () {
                var nombre = document.getElementById("nombre").value;
                var descripcion = document.getElementById("descripcion").value;
                var precio = document.getElementById("precio").value;

                var datos = {
                    pagina: paginaActual,
                    idPlato: idPlato,
                    nombre: nombre,
                    descripcion: descripcion,
                    precio: precio
                };
                update(datos, dataEditar);
                $('#myModal').modal('hide');
            });
            $("#btnoI").unbind("click");
            $("#btnoI").on("click", function () {
                $('#myModal').modal('hide');
                tostada("Inserción cancelada", '2');
            });
            $('#myModal').modal('show');
            mostrarFotos(idPlato);
        }
    }

    function update(datos, dataEditar) {
        $.ajax({
            url: "ajaxupdate.php",
            type: "post",
            data: datos,
            success: function (result) {
                if (result.r === 0) {
                    tostada("No se ha podido actualizar", '2');
                } else {
                    tostada("Plato Actualizado", 2);
                    destruirTabla();
                    construirTabla(result);
                    crearEventos();
                }
                subirImagenes(result, dataEditar);

            },
            error: function () {
                tostada("No se ha podido actualizar. Error ajax", '2');
            }
        });
    }

    function destruirImagenes() {
        var imagenes = document.getElementById("imagenes");
        while (imagenes.hasChildNodes()) {
            imagenes.removeChild(imagenes.firstChild);
        }
    }

    function mostrarFotos(idPlato)
    {
        $.ajax({
            url: "ajaxGetFotos.php?idPlato=" + idPlato,
            success: function (result) {
                destruirImagenes();
                if (result.length !== 0) {
                    var imagenes = document.getElementById("imagenes");
                    var idFoto, idPlato;
                    for (var i = 0; i < result.fotos.length; i++){
                        idFoto = result.fotos[i].idPlato;
                        idPlato = result.fotos[i].idFoto;
                        var imagen = document.createElement("img");
                        imagen.setAttribute("src", result.fotos[i].url);
                        imagen.setAttribute("id", idFoto);
                        imagen.setAttribute("data-idPlato", idPlato);
                        imagen.setAttribute("width", "30%");
                        imagen.setAttribute("class", "borrarImagen");
                        imagenes.appendChild(imagen);
                        imagen.onclick = function (e){
                            borrarFoto(e);
                        };
                    }
                }
            },
            error: function (result) {
                tostada("No existen fotos. Error ajax", '2');
            }
        });
    }

    function borrarFoto(e)
    {
        var idFoto = e.currentTarget.id;
        var cm = document.getElementById("contenidomodal");
        cm.innerHTML = "¿Borrar Foto " + idFoto + "?";
        $("#btsi").unbind("click");
        $("#btsi").on("click", function () {
            $("#dialogomodal").modal('hide');
            borraDefinitivo(idFoto);
        });
        $("#btno").unbind("click");
        $("#btno").on("click", function (e) {
            $("#dialogomodal").modal('hide');
            tostada("Borrado cancelado", '2');
        });
        $('#dialogomodal').modal('show');
    }

    function borraDefinitivo(e)
    {
        var idFoto = e;
        $.ajax({
            url: "ajaxDeleteFoto.php?idFoto=" + idFoto,
            success: function (result) {
                if (result.r === 0) {
                    tostada("No se ha podido borrar", '2');
                } else {
                    tostada("Foto " + result.r + " borrado", 2);
                    mostrarFotos(result.r);
                }
            },
            error: function (result) {
                tostada("No se ha podido borrar", '2');
            }
        });
    }

    function confirmarBorrar(mensaje) {
        var cm = document.getElementById("contenidomodal");
        cm.innerHTML = "¿Borrar " + mensaje + "?";
        $("#btsi").unbind("click");
        $("#btsi").on("click", function () {
            $("#dialogomodal").modal('hide');
            borrar(mensaje, paginaActual);
        });
        $("#btno").unbind("click");
        $("#btno").on("click", function (e) {
            $("#dialogomodal").modal('hide');
            tostada("Borrado cancelado", '2');
        });
        $('#dialogomodal').modal('show');
    }

    function borrar(idPlato, posicion) {
        $.ajax({
            url: "ajaxdelete.php?idPlato=" + idPlato + "&pagina=" + posicion,
            success: function (result) {
                console.log(result);
                if (result.r === 0) {
                    tostada("No se ha podido borrar", 2);
                } else {
                    tostada("Plato " + idPlato + " borrado", 2);
                    destruirTabla();
                    construirTabla(result);
                    crearEventos();
                }
            },
            error: function () {
                tostada("No se ha podido borrar", 2);
            }
        });
    }

    function subirImagenes(result, dataEditar)
    {
        var archivo = document.getElementById("archivo");
        var ajax, archivoactual, archivos, parametros, i, longitud;
        archivos = archivo.files;
        longitud = archivo.files.length;
        parametros = new FormData();
        parametros.append("numerodearchivos", longitud);
        for (i = 0; i < longitud; i++) {
            archivoactual = archivos[i];
            parametros.append('archivo[]', archivoactual, archivoactual.name);
        }
        ajax = new XMLHttpRequest();
        if (ajax.upload) {
            var plato = result.platos[result.platos.length - 1];
            plato = plato.idPlato;
            if (dataEditar !== undefined)
            {
                plato = dataEditar;
            }
            ajax.open("POST", "ajaxSubirArchivos.php?idPlato=" + plato /*plato.idPlato*/, true);
            ajax.onreadystatechange = function (texto) {
                if (ajax.readyState == 4) {
                    if (ajax.status == 200) {
                        tostada("Imagenes subidas", 2);
                    } else {
                        tostada("Error al subir las imagenes", '2');
                    }
                }
            };
            ajax.send(parametros);
        }
    }

    function construirTabla(datos) {
        var tabla = document.createElement("table");
        var tr, td, th;

        for (var i = 0; i < datos.platos.length; i++)
        {
            if (i === 0)
            {
                tr = document.createElement("tr");
                for (var j = 0 in datos.platos[i]) {
                    th = document.createElement("th");
                    th.textContent = j;
                    tr.appendChild(th);
                }
            }
            tabla.appendChild(tr);
            tr = document.createElement("tr");
            for (var j = 0 in datos.platos[i])
            {
                td = document.createElement("td");
                td.textContent = datos.platos[i][j];
                tr.appendChild(td)
            }
            td = document.createElement("td");
            td.innerHTML = "<a class='enlace-editar' data-editar='" + datos.platos[i].idPlato + "'>Editar</a>";
            tr.appendChild(td);
            td = document.createElement("td");
            td.innerHTML = "<a class='enlace-borrar' data-borrar='" + datos.platos[i].idPlato + "'>Borrar</a>";
            tr.appendChild(td);
            tabla.appendChild(tr);
        }
        /* paginacion */
        tr = document.createElement("tr");
        td = document.createElement("th");
        td.setAttribute("colspan", "10");

        td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.inicio + "'>&lt&lt;</a>";
        td.innerHTML += "&nbsp;";
        td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.anterior + "'>&lt;</a>";
        td.innerHTML += "&nbsp;";
        if (datos.paginas.primero !== -1) {
            td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.primero + "'>" +
                    (parseInt(datos.paginas.primero) + 1) + "</a>";
            td.innerHTML += "&nbsp;";
        }
        if (datos.paginas.segundo !== -1) {
            td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.segundo + "'>" +
                    (parseInt(datos.paginas.segundo) + 1) + "</a>";
            td.innerHTML += "&nbsp;";
        }
        if (datos.paginas.actual !== -1) {
            td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.actual + "'>" +
                    (parseInt(datos.paginas.actual) + 1) + "</a>";
            td.innerHTML += "&nbsp;";
        }
        if (datos.paginas.cuarto !== -1) {
            td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.cuarto + "'>" +
                    (parseInt(datos.paginas.cuarto) + 1) + "</a>";
            td.innerHTML += "&nbsp;";
        }
        if (datos.paginas.quinto !== -1) {
            td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.quinto + "'>" +
                    (parseInt(datos.paginas.quinto) + 1) + "</a>";
            td.innerHTML += "&nbsp;";
        }
        td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.siguiente + "'>&gt;</a>";
        td.innerHTML += "&nbsp;";
        td.innerHTML += "<a class='enlace' data-href='" + datos.paginas.ultimo + "'>&gt;&gt;</a>";
        tr.appendChild(td);
        tabla.appendChild(tr);
        var divcarta = document.getElementById("carta");
        divcarta.appendChild(tabla);
    }
});