<?php

namespace RootCStar\FormBuilder\Forms\Fields;

use RootCStar\FormBuilder\Forms\FormField;

class NumberField extends FormField
{
    public function min(int $min): self
    {
        $this->config['min'] = $min;
        return $this;
    }

    public function max(int $max): self
    {
        $this->config['max'] = $max;
        return $this;
    }

    public function toArray(): array
    {
        return array_merge($this->config, [
            'type' => 'number'
        ]);
    }
}
