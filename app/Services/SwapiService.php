<?php

namespace App\Services;

use GuzzleHttp\Client;

class SwapiService
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get all the people resources
     *
     * @param  int  $limit
     * @param  int  $offset
     * @return array
     */
    public function getPeople($limit = 10, $offset = 0)
    {
        return $this->getDataByLimitOffset($limit, $offset, 'people');
    }

    /**
     * Get a specific people resource
     *
     * @param  int  $id
     * @return array
     */
    public function getPeopleById($id)
    {
        return $this->getData('people/' . $id);
    }

    /**
     * Get all the planets resources
     *
     * @param  int  $limit
     * @param  int  $offset
     * @return array
     */
    public function getPlanets($limit = 10, $offset = 0)
    {
        return $this->getDataByLimitOffset($limit, $offset, 'planets');       
    }

    /**
     * Get a specific planets resource
     *
     * @param  int  $id
     * @return array
     */
    public function getPlanetById($id)
    {   
        return $this->getData('planets/' . $id);
    }

    /**
     *  Get all the vehicle resources
     *
     * @param  int  $limit
     * @param  int  $offset
     * @return array
     */
    public function getVehicles($limit = 10, $offset = 0)
    {
        return $this->getDataByLimitOffset($limit, $offset, 'vehicles');
    }
    
    /**
     * Get a specific vehicle resource
     *
     * @param  int  $id
     * @return array
     */
    public function getVehicleById($id)
    {   
        return $this->getData('vehicles/' . $id);
    }

    private function getDataByLimitOffset($limit, $offset, $resource)
    {
        $results = [];
        $page = 1;
        $count = 0;
        $totalCount = 0;
    
        $page = ceil(($offset + 1) / 10);
        
        if ($page > 1) {
            $offset = ($offset) % 10;
        }

        while ($count < $limit) {
            $url = $resource."/?page=" . $page;

            $body = $this->getData($url);
    
            // Obtener los resultados de la página actual
            $resultsPage = $body['results'];
    
            // Si es la página inicial, recortar los resultados para omitir los registros iniciales según el offset
            if ($offset > 0) {
                $resultsPage = array_slice($resultsPage, $offset);
                $offset -= $offset;
            }   
    
            // Agregar los resultados obtenidos al array de resultados
            $results = array_merge($results, $resultsPage);
    
            // Actualizar el contador de resultados
            $count += count($resultsPage);
    
            // Actualizar la cantidad total de planetas
            $totalCount = $body['count'];
    
            // Incrementar el número de página para la siguiente iteración
            $page++;
    
            // Si se llega a la última página, salir del ciclo
            if ($page > ceil($totalCount / 10)) {
                break;
            }
        }
    
        // Recortar el array de resultados para que tenga la cantidad exacta de resultados requeridos
        $results = array_slice($results, 0, $limit);
    
        return $results;
    }

    private function getData($url) {
        $response = $this->client->get(config('services.swapi.url') . $url, ['verify' => false]);

        return json_decode($response->getBody(), true);
    }
    
}