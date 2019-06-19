<?php

namespace HotlineEmu\DotenvValidator;

interface ValidatorInterface
{
    /**
     * Validates the environment.
     *
     * @return bool
     */
    public function isValid() : bool;
}
