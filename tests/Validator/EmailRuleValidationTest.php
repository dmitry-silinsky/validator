<?php

namespace DmitrySilinsky\Tests\Validator;

class EmailRuleValidationTest extends BaseTest
{
    public function testSuccess(): void
    {
        $this->validator->validate(
            ['email' => 'test@test.com'],
            ['email' => 'email'],
            ['email.email' => 'Email address is not valid']
        );

        $this->assertFalse($this->validator->failed());
    }

    public function testFailure(): void
    {
        $this->validator->validate(
            ['email' => 'invalid-email'],
            ['email' => 'email'],
            ['email.email' => $message = 'Email address is not valid']
        );

        $this->assertTrue($this->validator->failed());
        $this->assertEquals(
            ['email' => [$message]],
            $this->validator->errors()->all()
        );
    }

    public function testCheckMXFailure(): void
    {
        $invalidEmails = [
            'taurean58@sdfafasd.com',
            'isai.emmerich@dubusdfasdasfque.com',
            'muller.hettie@ioeruwjsdlkjf.com',
            'garett15@ziealksfjame.net',
        ];

        foreach ($invalidEmails as $email) {
            $this->validator->validate(
                ['email' => $email],
                ['email' => 'email:check_mx'],
                ['email.email' => $message = 'Email address is not valid']
            );

            $this->assertTrue($this->validator->failed(), "$email has MX");
            $this->assertEquals(
                ['email' => [$message]],
                $this->validator->errors()->all());
        }
    }

    public function testCheckMXSuccess(): void
    {
        $validEmails = [
            'test@gmail.com',
            'test@yahoo.com',
            'test@hotmail.com',
            'test@yandex.ru',
            'test@rambler.ru',
        ];

        foreach ($validEmails as $email) {
            $this->validator->validate(
                ['email' => $email],
                ['email' => 'email:check_mx'],
                ['email.email' => $message = 'Email address is not valid']
            );

            $this->assertFalse($this->validator->failed(), "$email has not MX");
        }
    }
}
