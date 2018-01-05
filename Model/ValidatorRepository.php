<?php

namespace Alaa\RvInputValidation\Model;

use Alaa\RvInputValidation\Api\ValidatorRepositoryInterface;

/**
 * Class ValidatorRepository.
 *
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ValidatorRepository implements ValidatorRepositoryInterface
{
    /**
     * @var ValidationInterface
     */
    private $validation;

    /**
     * Validator constructor.
     *
     * @param ValidationInterface $validation
     */
    public function __construct(ValidationInterface $validation)
    {
        $this->validation = $validation;
    }

    /**
     * @param string $rules
     *
     * @return bool
     */
    public function validate($rules)
    {
        $rules = json_decode($rules, true);
        $input = $rules['input'];

        return $this->validation->validate($input, $rules['rules']);
    }
}
