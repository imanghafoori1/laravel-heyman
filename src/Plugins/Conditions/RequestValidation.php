<?php

namespace Imanghafoori\HeyMan\Plugins\Conditions;

use Imanghafoori\HeyMan\Reactions\Validator;

class RequestValidation
{
    /**
     * Validate the given request with the given rules.
     *
     * @param array|callable $rules
     * @param array $messages
     * @param array $customAttributes
     *
     * @return \Imanghafoori\HeyMan\Reactions\Validator
     */
    public function yourRequestShouldBeValid($rules, array $messages = [], array $customAttributes = [])
    {
        return new Validator([$rules, $messages, $customAttributes]);
    }
}
