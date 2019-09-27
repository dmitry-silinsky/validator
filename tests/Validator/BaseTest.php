<?php

namespace DmitrySilinsky\Tests\Validator;

use DmitrySilinsky\Validator\{ErrorBag, Ruleset, Validator};
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    protected $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->validator = new Validator(new Ruleset(), new ErrorBag(), true);
    }
}
