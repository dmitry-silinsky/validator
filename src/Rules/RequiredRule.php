<?php

namespace DmitrySilinsky\Validator\Rules;

use DmitrySilinsky\Validator\{Rule, ValidationResult};

class RequiredRule extends Rule
{
    /** @var string */
    protected $name = 'required';

    /**
     * @param array $data
     * @param string $key
     * @param array $params
     * @param array $messages
     * @return ValidationResult
     */
    public function validate(array $data, string $key, array $params = [], array $messages = []): ValidationResult
    {
        $result = new ValidationResult();

        $result->isPassed = array_key_exists($key, $data);

        if ($result->failed()) {
            $result->message = $this->findMessage($messages, $key);
        }

        return $result;
    }
}
