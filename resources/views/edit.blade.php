@extends('layouts.master')

@section('titulo')
    index
@endsection

@section('contenido')
    <script>
        const baseUrl = "{{url('')}}";
        document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('saveForm').addEventListener('submit', async function(event) {
            event.preventDefault(); // Evita que se envíe el formulario de manera convencional

            // Obtener los valores de los campos del formulario
            const language = document.getElementById('language').value;
            const title = document.getElementById('title').value;
            const serieName = document.getElementById('serieName').value;
            const artist = document.getElementById('artist').value;
            const year = document.getElementById('year').value;
            const inventoryId = document.getElementById('inventoryId').value;
            const status = document.getElementById('status').value;
            const dimensions = document.getElementById('dimensions').value;
            const price = document.getElementById('price').value;
            const currency = document.getElementById('currency').value;            
            const file = document.getElementById('file');
            let fileBase64 = '';
            if(file.files[0]){
                 // Pasar a base64
                async function fileToBase64(file) {
                    return new Promise((resolve, reject) => {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            resolve(event.target.result);
                        };
                        reader.onerror = function(error) {
                            reject(error);
                        };
                        reader.readAsDataURL(file);
                    });
                }

                fileBase64 = await fileToBase64(file.files[0]);
            }
            
           
           
            // Crear el objeto de datos a enviar
            const data = {
                language: language,
                title: title,
                serieName: serieName,
                artist: artist,
                year: year,
                inventoryId: inventoryId,
                dimensions: dimensions,
                price: price,
                currency: currency,
                file: fileBase64,
                status: status,
                
            };

            // Configurar la solicitud
            const requestOptions = {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data)
            };
             // Realizar la llamada API para guardar los datos
             fetch(baseUrl + '/api/edit', requestOptions)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la solicitud');
                    }
                    return response.json();
                })
                .then(data => {
                    // Aquí puedes manejar la respuesta de la API, si es necesario
                    console.log('Datos guardados exitosamente:', data);
                    window.location.href = baseUrl + '/index'; 
                })
                .catch(error => {
                    console.error('Error al guardar los datos:', error);
                    // Aquí puedes manejar el error, como mostrar un mensaje de error al usuario
                });
        });
    });
    </script>
    <form id="saveForm">

        <div class="actions">
            <input type="submit" value="Save">  
            <a href="{{ url('/index') }}" id="cancel">Cancel</a>
  
        </div>    
        
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Language <label class="red">*</label></label>
            <select class="form-select" aria-label="Default select example" id="language">
                @if($data->language == 'English')
                    <option value="English"selected>English</option>
                    <option value="Español">Español</option>
                @else
                    <option value="English">English</option>
                    <option value="Español" selected>Español</option>
                @endif
            </select>
        </div>
        
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Title</label>                
            <input type="text" class="form-control-plaintext" id="title" value = "{{ $data->title }}"/>               
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Serie Name
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 50 50">
            <path d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 25 11 A 3 3 0 0 0 22 14 A 3 3 0 0 0 25 17 A 3 3 0 0 0 28 14 A 3 3 0 0 0 25 11 z M 21 21 L 21 23 L 22 23 L 23 23 L 23 36 L 22 36 L 21 36 L 21 38 L 22 38 L 23 38 L 27 38 L 28 38 L 29 38 L 29 36 L 28 36 L 27 36 L 27 21 L 26 21 L 22 21 L 21 21 z"></path>
            </svg>
            </label>
            <input type="text" class="form-control-plaintext" id="serieName" value = "{{ $data->serieName }}">
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Artist <label class="red">*</label></label>
            <input type="text" class="form-control-plaintext" id="artist" value = "{{ $data->artist }}">
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Year</label>
            <input type="text" class="form-control-plaintext" id="year" value = "{{ $data->year }}">
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Inventory ID <label class="red">*</label>
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 50 50">
                <path d="M 25 2 C 12.309295 2 2 12.309295 2 25 C 2 37.690705 12.309295 48 25 48 C 37.690705 48 48 37.690705 48 25 C 48 12.309295 37.690705 2 25 2 z M 25 4 C 36.609824 4 46 13.390176 46 25 C 46 36.609824 36.609824 46 25 46 C 13.390176 46 4 36.609824 4 25 C 4 13.390176 13.390176 4 25 4 z M 25 11 A 3 3 0 0 0 22 14 A 3 3 0 0 0 25 17 A 3 3 0 0 0 28 14 A 3 3 0 0 0 25 11 z M 21 21 L 21 23 L 22 23 L 23 23 L 23 36 L 22 36 L 21 36 L 21 38 L 22 38 L 23 38 L 27 38 L 28 38 L 29 38 L 29 36 L 28 36 L 27 36 L 27 21 L 26 21 L 22 21 L 21 21 z"></path>
                </svg>
            </label>
            <input type="text" class="form-control-plaintext" id="inventoryId" value = "{{ $data->inventoryId }}">
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Status</label>
            <select class="form-select" aria-label="Default select example" id="status">
                @if($data->status == 'Reserved')
                    <option value="Reserved" selected>Reserved</option>
                    <option value="Available">Available</option>
                @else
                    <option value="Reserved">Reserved</option>
                    <option value="Available" selected>Available</option>
                @endif
            </select>

        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Dimensions</label>
            <input type="text" class="form-control-plaintext" id="dimensions" value = "{{ $data->dimensions }}">
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Price</label>
            <input type="text" class="form-control-plaintext" id="price" value = "{{ $data->price }}">
            <select class="form-select" aria-label="Default select example" id="currency">
                @if($data->currency == 'EUR')
                    <option value="EUR" selected>€</option>
                    <option value="USD">USD</option>
                @else
                    <option value="USD" seleected>USD</option>
                    <option value="EUR">€</option>
                @endif
            </select>
        </div>
        <div class="mb-3 row">
            <label for="formFile" class="form-label">File</label>
            <input class="form-control" type="file" id="file">
        </div>
    </form>
@endsection
