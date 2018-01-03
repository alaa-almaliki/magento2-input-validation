<?php

namespace Alaa\RvInputValidation\Api;

/**
 * Interface ValidatorRepositoryInterface
 * @package Alaa\RvInputValidation\Api
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface ValidatorRepositoryInterface
{
    /**
     * @param string $rules
     * @return bool
     */
    public function validate($rules);
}