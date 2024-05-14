<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Requests\GalleryPostRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($posicion)
    {
        // Traer los datos
        $data = json_decode(file_get_contents('datos.json'));
        
        foreach($data as $key => $valor){
            // Buscar el valor según la posición
            if($valor->posicion == $posicion){
                $valor = $this->search($valor->inventoryId,false); 
                return response()->json($valor); 
            }
                   
        }
         
    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(GalleryPostRequest $request)
    {        
        
        try{

            if($request->file){
                // Genera el nombre de archivo
                $imageName = $request->inventoryId . '_' . time() . '.png';
                // Guarda la imagen            
                Storage::disk('public')->put($imageName,$request->file); 
            }            
            
        }catch(Exception $e){
            // Guarda en el log el inventoryID, porque es único, el tamaño del fichero y el mensaje de error
            file_put_contents('errorFile.log','error: ' .$e->getMessage(). ' inventoryID: ' .$request->inventoryID . ' tamaño del fichero: ' . filesize($request->file));  
            return response()->json(["message" => 'An error ocurred while saving the image'],500);
        }

        // Guarda los valores en un array
        $data = [
            'language' => $request->language,
            'title' => $request->title,
            'artist' => $request->artist,
            'file' => $imageName,
            'inventoryId' => $request->inventoryID,
            'price' => $request->price,
            'currency' => $request->currency,
            'serieName' => isset($request->serieName) ? $request->serieName : '',
            'year' => isset($request->year) ? $request->year : '',
            'status' => isset($request->status) ? $request->status : '',
            'dimensions' => isset($request->dimensions) ? $request->dimensions : '',
        ];

        // Trae los datos del array
        $array = (array)json_decode(file_get_contents('datos.json'));
        
        // Añade los nuevos datos a los antiguos
        array_push($array,$data);

        // Añade los datos al json
        file_put_contents('datos.json', json_encode($array));

        return response()->json(['message' => "Gallery saved correctly"],200);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // Buscar los datos
        $data = $this->search($request->inventoryId,false);

        return response()->json($data);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GalleryPostRequest $request)
    {
        // Traer los datos
        $data = json_decode(file_get_contents('datos.json'));
        
        foreach($data as $key => $valor){
            
            // Buscar según el inventoryId
            if($valor->inventoryId == $request->inventoryId){  
                
                // Guardar los nuevos datos
                $valor->language = $request->language;
                $valor->title = $request->title;
                $valor->artist = $request->artist;                
                $valor->inventoryId = $request->inventoryId;
                $valor->price = $request->price;
                $valor->serieName = $request->serieName;
                $valor->year = $request->year;
                $valor->status = $request->status;
                $valor->dimensions = $request->dimensions;  
                $valor->currency = $request->currency;
                
                // Comprobar que llega file
                if(isset($request->file) && $request->file != ""){
                    try{

                        // Eliminar los valores no necesarios y decodificar base64
                        $base64Image = $request->file;
                        list(, $imageData) = explode(';', $base64Image);
                        list(, $imageData) = explode(',', $imageData);
                        $imageData = base64_decode($imageData);

                        // Generar el nombre de archivo
                        $imageName = $request->inventoryId . '_' . time() . '.png';

                        // Guardar la imagen en el sistema de archivos
                        $path = Storage::disk('public')->put($imageName, $imageData);


                        // Asignar la ruta de la imagen al objeto $valor
                        $valor->file = $imageName;

                    }catch(Exception $e){
                        //guardamos en el log el inventoryID, porque es único, el tamaño del fichero y el mensaje de error
                        file_put_contents('errorFile.log','error: ' .$e->getMessage(). ' inventoryID: ' .$request->inventoryID . ' tamaño del fichero: ' . filesize($request->file));  
                        return response()->json(["message" => 'An error ocurred while saving the image'],500);
                    }
                    
                }
               
            }
        }

        file_put_contents('datos.json',json_encode($data));

        return response()->json(["message" => "Gallery modified successfully"],200);
    }

   /**
     * Converter price
     */
    public function converter($price,$currency)
   {    
        // Modificar valor del precio a tipo float        
        $price = floatval($price);

        // Hacer llamada a API externa para extraer los valores de la moneda
        if($currency == 'EUR'){
            $url = 'https://api.freecurrencyapi.com/v1/latest?apikey=fca_live_JskVm3P7e31zfSCqexRUEOCl3HiBD3GVbtO6dXAh&currencies=EUR%2CUSD&base_currency=EUR';       
        }else{
            $url = 'https://api.freecurrencyapi.com/v1/latest?apikey=fca_live_JskVm3P7e31zfSCqexRUEOCl3HiBD3GVbtO6dXAh&currencies=EUR%2CUSD';
        }
                
        
        $client = new Client();

        try {
            // Realizar la llamada a la API externa
            $response = $client->request('GET', $url);
            
            // Manejar la respuesta de la API externa
            $statusCode = $response->getStatusCode(); 
            $body = json_decode($response->getBody()->getContents()); 
            
            
            $data = $body->data;
           
            // Multiplicar el precio por el valor de la moneda
            $price = $currency == 'EUR' ? $price * $data->USD : $price * $data->EUR;
           
            // Guardar el tipo de moneda
            $otherCurrency = $currency == 'EUR' ? 'USD' : 'EUR';

            // Devolver el valor con redondeo de 2 decimales
            return round($price,2) . ' ' . $otherCurrency;

        } catch (\Exception $e) {
            // Maneja cualquier error que ocurra durante la llamada
            file_put_contents('errorConverter.log','error: ' .$e->getMessage());  
                        
        }

   }

   public function editView ($inventoryId)
   {
        // Buscar los datos
        $data = $this->search($inventoryId,true);

        // Devolver los datos a la vista del cuadro
        return view('edit',['data' => $data]);               

   }


   public function search ($inventoryId,$edit = null)
   {
        // Traer los datos
        $data = json_decode(file_get_contents('datos.json'));


        foreach($data as $key => $valor){
            // Buscar por el inventoryId
            if($valor->inventoryId == $inventoryId){  
                // Traer el path de donde está ubicado la imagen
                $valor->file = Storage::url($valor->file); 
                // Convertir el precio 
                $valor->secondPrice = $this->converter($valor->price,$valor->currency); 
                // Si la llamada no viene de editView() convertir las dimensiones
                if($edit==false){
                    $valor->dimensions = $valor->dimensions . ' cm ' . $this->cmToIn($valor->dimensions) . ' in'; 
                }    
                return $valor;                
            }
        } 
   }

        
    /**
     * converter cm to In 
     */
    public function cmToIn ($dimensions)
    {
        // Valor de una pulgada
        $pulgada = 0.39;
        
        // Extraer el valor en array
        $array = explode('x',$dimensions);
        // Crear nuevo array
        $dimensions = [];
        
        foreach($array as $valor){
            // Convertir el valor a int y multiplicar por el valor de una pulgada
            $valor = intVal($valor) * $pulgada;
            // Añadir el nuevo valor al array
            array_push($dimensions,$valor);
        }   
        
        // Convertir el array en un string
        return implode(' x ' ,$dimensions);
    }
}
