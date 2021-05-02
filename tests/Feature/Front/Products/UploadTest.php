<?php

namespace Tests\Feature\Front\Products;


use App\Models\User;
use Tests\TestCase;

class UploadTest extends TestCase
{
    public function testShouldRenderUploadPage(): void
    {
        // Set
        $user = User::factory()->create();
        $this->actingAs($user);

        // Act
        $response = $this->get('products/upload');

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('products.upload.upload');
    }
}
