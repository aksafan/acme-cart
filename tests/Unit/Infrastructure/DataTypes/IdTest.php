<?php

declare(strict_types=1);

namespace Unit\Infrastructure\DataTypes;

use App\Infrastructure\DataTypes\Id;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class IdTest extends TestCase
{
    public function testConstructor(): void
    {
        $uuid = '550e8400-e29b-41d4-a716-446655440000';
        $id = new Id($uuid);

        $this->assertSame(mb_strtolower($uuid), (string) $id);
        $this->assertSame(mb_strtolower($uuid), $id->getValue());
    }

    public function testConstructorThrowsExceptionForInvalidUuid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $invalidUuid = 'not_a_valid_uuid';
        new Id($invalidUuid);
    }

    public function testGenerate(): void
    {
        $id = Id::generate();

        $this->assertNotEmpty($id->getValue());
        $this->assertIsString($id->getValue());
        $this->assertSame($id->getValue(), (string) $id);
    }
}
