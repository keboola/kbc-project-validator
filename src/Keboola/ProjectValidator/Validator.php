<?php
/**
 * Author: miro@keboola.com
 * Date: 24/08/2017
 */

namespace Keboola\ProjectValidator;

class Validator
{
    public function validate($rules)
    {
        return array_map(function ($rule) {
            return $rule();
        }, $rules);
    }
}