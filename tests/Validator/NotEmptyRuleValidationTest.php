<?php

namespace DmitrySilinsky\Tests\Validator;

class EmailValidationTest extends BaseTest
{
    public function testSuccess(): void
    {
        $this->validator->validate(
            ['value' => 'some_value'],
            ['value' => 'not_empty'],
            ['value.required' => 'Value must not be empty']
        );

        $this->assertFalse($this->validator->failed());
    }

    public function testFailure(): void
    {
        $this->validator->validate(
            ['value' => ''],
            ['value' => 'not_empty'],
            ['value.not_empty' => $message = 'Value must not be empty']
        );

        $this->assertTrue($this->validator->failed());
        $this->assertEquals(
            ['value' => [$message]],
            $this->validator->errors()->all()
        );

        $this->validator->validate(
            ['value' => ' '],
            ['value' => 'not_empty'],
            ['value.not_empty' => $message = 'Value must not be empty']
        );

        $this->assertTrue($this->validator->failed());
        $this->assertEquals(
            ['value' => [$message]],
            $this->validator->errors()->all()
        );
    }
}
