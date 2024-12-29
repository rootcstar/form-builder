<?php

namespace RootCStar\FormBuilder\Forms\Fields;

use RootCStar\FormBuilder\Forms\FormField;

class TelephoneField extends FormField
{
    protected $config = [];


    public function minLength(int $minLength): self
    {
        $this->config['minLength'] = $minLength;
        return $this;
    }

    public function maxLength(int $maxLength): self
    {
        $this->config['maxLength'] = $maxLength;
        return $this;
    }

    public function pattern(string $pattern): self
    {
        $this->config['pattern'] = $pattern; // Regex deseni
        return $this;
    }

    public function toArray(): array
    {
        return array_merge($this->config, [
            'type' => 'tel'
        ]);
    }
}
