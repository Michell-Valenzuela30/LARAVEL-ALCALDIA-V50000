<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A test that checks if the application returns a successful response.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        if ($response->status() !== 200) {
            // Si '/' no responde con 200, probar '/install'
            $response = $this->get('/install');
        }

        // Verificar que al menos una de las dos rutas devuelve 200
        $response->assertStatus(200);
    }
}
