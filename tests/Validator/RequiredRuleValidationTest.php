<?php

namespace DmitrySilinsky\Tests\Validator;

class RequiredRuleValidationTest extends BaseTest
{
    public function testSuccess(): void
    {
        $this->validator->validate(
            ['value' => 'some_value'],
            ['value' => 'required'],
            ['value.required' => 'Value required']
        );

        $this->assertFalse($this->validator->failed());
    }

    public function testFailure(): void
    {
        $this->validator->validate(
            [],
            ['value' => 'required'],
            ['value.required' => $message = 'Value required']
        );

        $this->assertTrue($this->validator->failed());
        $this->assertEquals(
            ['value' => [$message]],
            $this->validator->errors()->all()
        );
    }
}
