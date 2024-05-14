@extends('layouts.master')

@section('titulo')
    summary
@endsection

@section('contenido')

        <script>
            const baseUrl = "{{url('')}}";
            let posicion = 1;
            cargarPagina(posicion);
            

            // Función para cargar una página específica
            function cargarPagina(pagina) {
                // Configuración de la solicitud POST
                const requestOptions = {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                };
                const url = baseUrl + '/api/index/'+ pagina;
                fetch(url, requestOptions)
                    .then(response => response.json())
                    .then(data => {
                        
                        
                        var divResultado = document.getElementById('galleryName');
                        var html = '';  
                        
                        html += '<div class="containerImg">';
                        html += '<img src="' + data.file +'"/>';
                        html += '</div>';
                        html += '<div class="containerInfo">'                        
                        html += '<div class="info">';
                        html += '<h1>'+data.title+'</h1>';
                        html += '<p id="serieName"> From series: ' + data.serieName + '</p>';
                        html += '<p id="artist">' + data.artist + '</p>'; 
                        html += '<p class="'+data.status+'"><span></span>' + data.status + '</p>';
                        html += '<p>' + data.inventoryId + '</p>';
                        html += '<p>' + data.year + '</p>';
                        html += '<p>' + data.dimensions + '</p>';
                        html += '<p>' + data.price + ' ' + data.currency + ' ' + data.secondPrice + '</p>';
                        html += '<div class="formActions">'
                        html += '<a href="'+baseUrl+'/edit/'+data.inventoryId+'" id="edit"><svg class="iconEdit" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/></svg></a>';
                        html += '<button id="exportPDF">export PDF</button>';
                        html += '<button id="exportAndSend">export & send PDF</button>';
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="paginator">';
                        html += '<button class="paginator" onclick="cargarPaginaAnterior()"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>';
                        html += '<button class="paginator" onclick="cargarPaginaSiguiente()"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>';
                        html += '</div>';
                        html += '</div>';

                        divResultado.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error al realizar la solicitud:', error);
                    });
            }

            // Función para cargar la página anterior
            function cargarPaginaAnterior() {
                if (posicion > 1) {
                    posicion--;
                    cargarPagina(posicion);
                }
            }

            // Función para cargar la página siguiente
            function cargarPaginaSiguiente() {
                if(posicion < 3){
                    posicion++;
                    cargarPagina(posicion);
                }
                
            }



        </script>
        
        <div id="galleryName">       
        </div>
    

@endsection