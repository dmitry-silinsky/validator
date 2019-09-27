<?php

namespace DmitrySilinsky\Validator\Rules;

use DmitrySilinsky\Validator\{Rule, ValidationResult};

class EmailRule extends Rule
{
    protected $name = 'email';

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

        $formatIsCorrect = filter_var($data[$key], FILTER_VALIDATE_EMAIL);

        if ($this->getParam($params)) {
            $mxIsCorrect = $this->checkMX($data[$key]);
            $result->isPassed = $formatIsCorrect && $mxIsCorrect;
        } else {
            $result->isPassed = $formatIsCorrect;
        }

        if ($result->failed()) {
            $result->message = $this->findMessage($messages, $key);
        }

        return $result;
    }

    /**
     * @param string $email
     * @return bool
     */
    protected function checkMX(string $email): bool
    {
        $domain = substr(strrchr($email, '@'), 1);
        $res = getmxrr($domain, $hosts, $weight);

        if ($res === false || count($hosts) == 0 || (count($hosts) && in_array($hosts[0], ['0.0.0.0', null]))) {
            return false;
        }

        return true;
    }

    /**
     * @param array $params
     * @return string|null
     */
    protected function getParam(array $params): ?string
    {
        if (empty($params)) {
            return null;
        }

        if ($params[0] !== 'check_mx') {
            throw new \InvalidArgumentException('Email rule: invalid parameter');
        }

        return $params[0];
    }
}
