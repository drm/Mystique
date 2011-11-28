<?php

namespace Meander\PHP\Builder;

interface InputParser {
    function parseValue($input);
    function parseName($input);
}