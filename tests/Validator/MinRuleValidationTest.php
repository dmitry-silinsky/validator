<?php

namespace DmitrySilinsky\Tests\Validator;

class MinRuleValidationTest extends BaseTest
{
    public function testParameterRequired()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->validator->validate(
            ['value' => 'some_value'],
            ['value' => 'min'],
            ['value.min' => "Minimum length of value - 5 characters"]
        );
    }

    public function testSuccess(): void
    {
        $this->validator->validate(
            ['value' => 'some_value'],
            ['value' => 'min:' . $param = 10],
            ['value.min' => "Minimum length of value - $param characters"]
        );

        $this->assertFalse($this->validator->failed());
    }

    public function testFailure(): void
    {
        $this->validator->validate(
            ['value' => 'some_value'],
            ['value' => 'min:' . $param = 11],
            ['value.min' => $message = "Minimum length of value - $param characters"]
        );

        $this->assertTrue($this->validator->failed());
        $this->assertEquals(
            ['value' => [$message]],
            $this->validator->errors()->all()
        );
    }
}
