<?php

namespace Src\Users\Infrastructure\Laravel\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Math\Percentage;
use Src\Users\Domain\DataTransfer\Erp;
use Src\Users\Domain\Models\ValueObjects\Taxes;
use Tests\Data\Models\Users\UserData;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_should_instantiate_user_model(): void
    {
        // Arrange
        $taxes = new Taxes(Percentage::fromPercentage(5.45), Percentage::fromPercentage(18));

        // Act
        $instance = UserData::make();

        // Assert
        $this->assertSame('usuario@email.com', $instance->getEmail());
        $this->assertSame('bling', $instance->getErp());
        $this->assertSame('token', $instance->getErpToken());
        $this->assertSame('66569343076', $instance->getFiscalId());
        $this->assertSame(18.0, $instance->getIcmsInnerStateTaxRate());
        $this->assertIsString($instance->getId());
        $this->assertSame('Artigos de Venda SA', $instance->getName());
        $this->assertSame('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', $instance->getPassword());
        $this->assertSame('+5511987654321', $instance->getPhone());
        $this->assertSame(5.45, $instance->getSimplesNacionalTaxRate());
        $this->assertEquals($taxes, $instance->getTaxes());
    }

    public function test_should_set_erp(): void
    {
        // Arrange
        $instance = UserData::make();
        $erp = new Erp('new-token', 'tiny-erp');

        // Act
        $instance->setErp($erp);

        // Assert
        $this->assertSame('tiny-erp', $instance->getErp());
        $this->assertSame('new-token', $instance->getErpToken());
    }

    public function test_should_set_password(): void
    {
        // Arrange
        $instance = UserData::make();

        // Act
        $instance->setPassword('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

        // Assert
        $this->assertSame(
            '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            $instance->getPassword()
        );
    }

    public function test_should_set_profile(): void
    {
        // Arrange
        $instance = UserData::make();

        // Act
        $instance->setProfile('Supermercados Almeida', '+553532147450', '25537773023');

        // Assert
        $this->assertSame('Supermercados Almeida', $instance->getName());
        $this->assertSame('+553532147450', $instance->getPhone());
        $this->assertSame('25537773023', $instance->getFiscalId());
    }

    public function test_should_set_taxes(): void
    {
        // Arrange
        $instance = UserData::make();
        $taxes = new Taxes(
            Percentage::fromPercentage(6.134),
            Percentage::fromPercentage(17)
        );

        // Act
        $instance->setTaxes($taxes);

        // Assert
        $this->assertEquals($taxes, $instance->getTaxes());
    }
}
