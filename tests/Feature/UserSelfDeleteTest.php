<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase; // <-- Importante: Importar el TestCase de Laravel

uses(TestCase::class, RefreshDatabase::class);

test('un usuario no puede eliminarse a si mismo', function () {

    // 1) Crear un usuario en BD de pruebas
    $user = User::factory()->create([  
        'email_verified_at' => now()
    ]);
    
    // 2) Simular que el usuario esta iniciado (Corregido actingAs)
    $this->actingAs($user, 'web');

    // 3) Simular que intenta borrar un usuario y GUARDAR en $response
    $response = $this->delete(route('admin.users.destroy', $user));

    // 4) Esperar a que el servidor bloquee esta accion
    $response->assertStatus(403);

    // 5) Verificamos que el usuario siga existiendo en BD (Corregido assertDatabaseHas)
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
    ]);  

});