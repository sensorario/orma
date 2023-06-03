<?php

namespace Sensorario\Orma;

class Outcome
{
    public function __construct(
        public readonly int $founded = 0,
        public readonly array $results = [],
    ) { } 
}
