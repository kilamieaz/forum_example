<?php

namespace App\Inspections;

class Spam
{
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    public function detect($body)
    {
        // dd($this->inspections);
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }
        return false;
    }
}
