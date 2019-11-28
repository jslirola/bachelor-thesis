<?php

namespace Tests\Unit;

use Tests\TestCase;

class ApiTest extends TestCase
{

    public function testGetFreeProjects()
    {
        $response = $this->json('GET', '/api/getFreeProjects');
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                [
                    'tituloTrabajo',
                    'detalleTrabajo',
                    'tipoTrabajo'
                ]
            ]
        );
    }
}
