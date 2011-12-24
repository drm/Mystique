<?php

namespace Mystique\PHP\Builder;

interface InputParser {
    function parseValue($input);
    function parseName($input);
}