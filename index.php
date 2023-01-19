<?php
$direccion_archivo_pc = 'C:\Users\Juan\Desktop\Personas.csv';
$delimitador = ";";
$listaRuts = ["16163631-2","5126663-3","5811892-3","3632455-4","4100738-9"];

class Persona {
      public $rut;
      public $nombre;
}

$titulo = array("Rut","Nombre");

$listaPersonas = [];

foreach ($listaRuts as $rut) {
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.libreapi.cl/rut/activities?rut='.$rut,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      $persona = new Persona();
      $persona->rut = $rut;
      $persona->nombre =json_decode($response)->data->name;

      array_push($listaPersonas, $persona);
}

$fp = fopen($direccion_archivo_pc, 'w');

fputcsv($fp, $titulo,$delimitador);  

foreach ($listaPersonas as $persona) {
      fputcsv($fp, (array)$persona,$delimitador);
}
fclose($fp);

?>