<?php

namespace Alaa\RvInputValidation\Model;

/**
 * Class Validation.
 *
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Validation implements ValidationInterface
{
    /**
     * Class package of the rule.
     */
    const RULES_PACKAGE = 'Respect\Validation\Rules';

    /**
     * @param array $postData
     * @param array $ruleConfig
     *
     * @return array
     */
    public function validatePostData(array $postData, array $ruleConfig)
    {
        $validationResults = [];
        foreach ($ruleConfig as $inputKey => $rules) {
            if (array_key_exists($inputKey, $postData)) {
                $input = $postData[$inputKey];
                $isValid = true;
                $message = null;

                foreach ($rules as $rule) {
                    $isValid &= $this->validateInput($input, $rule);

                    if (array_key_exists('success_message', $rule)
                        && array_key_exists('failure_message', $rule)
                    ) {
                        $message = $isValid ? $rule['success_message'] : $rule['failure_message'];
                    }

                    if (!$isValid) {
                        break;
                    }
                }

                $results = [
                    'is_valid' => (bool) $isValid,
                ];

                if ($message !== null) {
                    $results['message'] = $message;
                }

                $validationResults[$inputKey] = $results;
            }
        }

        return $validationResults;
    }

    /**
     * @param array $getData
     * @param array $ruleConfig
     *
     * @return array
     */
    public function validateGetData(array $getData, array $ruleConfig)
    {
        return $this->validatePostData($getData, $ruleConfig);
    }

    /**
     * @param string $input
     * @param array  $rules
     *
     * @return bool
     */
    public function validate($input, array $rules)
    {
        $isValid = true;
        foreach ($rules as $rule) {
            $isValid &= $this->validateInput($input, $rule);

            /*
             * Validation failed, stop validation process as no need to continue
             */
            if (!$isValid) {
                break;
            }
        }

        return (bool) $isValid;
    }

    /**
     * @param string $input
     * @param array  $rule
     *
     * @return bool
     */
    public function validateInput($input, array $rule)
    {
        $class = $this->resolveClass($rule);
        $ruleInstance = $this->getRuleInstance($class, $rule);

        return (bool) $ruleInstance->validate($input);
    }

    /**
     * @param array $rule
     *
     * @return string
     *
     * @throws InputValidationException
     */
    protected function resolveClass(array $rule)
    {
        if (!array_key_exists('class', $rule)) {
            throw new InputValidationException('Validation rule class must be provided.');
        }

        $ruleClass = $rule['class'];
        $fullClassName = self::RULES_PACKAGE.'\\'.$rule['class'];
        if (!class_exists($fullClassName)) {
            throw new InputValidationException(
                sprintf('%s class is not found', $ruleClass)
            );
        }

        return $fullClassName;
    }

    /**
     * @param $ruleClass
     * @param $rule
     *
     * @return null|object
     */
    protected function getRuleInstance($ruleClass, $rule)
    {
        $instance = null;
        if (array_key_exists('args', $rule) && is_array($rule['args'])) {
            $ref = new \ReflectionClass($ruleClass);
            $instance = $ref->newInstanceArgs($rule['args']);
        } else {
            $instance = new $ruleClass();
        }

        return $instance;
    }
}
