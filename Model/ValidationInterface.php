<?php

namespace Alaa\RvInputValidation\Model;

/**
 * Interface ValidationInterface
 * @package Alaa\RvInputValidation\Model
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface ValidationInterface
{
    /**
     * @param array $postData
     * @param array $ruleConfig
     * @return array
     */
    public function validatePostData(array $postData, array $ruleConfig);

    /**
     * @param array $getData
     * @param array $ruleConfig
     * @return array
     */
    public function validateGetData(array $getData, array $ruleConfig);


    /**
     * @param string $input
     * @param array $rule
     * @return bool
     */
    public function validateInput($input, array $rule);

    /**
     * @param string $input
     * @param array $rules
     * @return bool
     */
    public function validate($input, array $rules);
}