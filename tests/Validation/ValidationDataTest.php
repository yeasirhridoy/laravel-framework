<?php

namespace Illuminate\Tests\Validation;

use Illuminate\Validation\ValidationData;
use PHPUnit\Framework\TestCase;

class ValidationDataTest extends TestCase
{
    public function testGetLeadingExplicitAttributePath()
    {
        $this->assertEquals('foo.bar', ValidationData::getLeadingExplicitAttributePath('foo.bar.*.baz'));
        $this->assertEquals('foo', ValidationData::getLeadingExplicitAttributePath('foo.*'));
        $this->assertNull(ValidationData::getLeadingExplicitAttributePath('*'));
        $this->assertEquals('foo.bar', ValidationData::getLeadingExplicitAttributePath('foo.bar'));
    }

    public function testExtractDataFromPath()
    {
        $data = ['foo' => ['bar' => 'baz'], 'qux' => 'ux'];

        $this->assertEquals(['foo' => ['bar' => 'baz']], ValidationData::extractDataFromPath('foo', $data));
        $this->assertEquals(['foo' => ['bar' => 'baz']], ValidationData::extractDataFromPath('foo.bar', $data));
        $this->assertEquals([], ValidationData::extractDataFromPath('nonexistent', $data));
    }

    public function testInitializeAndGatherData()
    {
        $data = [
            'name' => 'Taylor',
            'users' => [
                ['id' => 1, 'email' => 'taylor@laravel.com'],
                ['id' => 2, 'email' => 'abigail@laravel.com'],
            ],
        ];

        // Simple attribute
        $this->assertEquals(['name' => 'Taylor'], ValidationData::initializeAndGatherData('name', $data));

        // Nested attribute
        $this->assertEquals(['users.0.id' => 1], ValidationData::initializeAndGatherData('users.0.id', $data));

        // Wildcard attribute
        $this->assertEquals([
            'users.0.id' => 1,
            'users.0.email' => 'taylor@laravel.com',
            'users.1.id' => 2,
            'users.1.email' => 'abigail@laravel.com',
            'users.0' => ['id' => 1, 'email' => 'taylor@laravel.com'],
            'users.1' => ['id' => 2, 'email' => 'abigail@laravel.com'],
        ], ValidationData::initializeAndGatherData('users.*', $data));

        // Nested wildcard attribute
        $this->assertEquals([
            'users.0.id' => 1,
            'users.0.email' => 'taylor@laravel.com',
            'users.1.id' => 2,
            'users.1.email' => 'abigail@laravel.com',
        ], ValidationData::initializeAndGatherData('users.*.email', $data));

        // Missing attribute
        $this->assertEquals([], ValidationData::initializeAndGatherData('missing', $data));
    }
}
