<?php

namespace RootCStar\FormBuilder\Forms\Fields;
use RootCStar\FormBuilder\Forms\FormField;

class DatePicker extends FormField{

    public function min(string $min): self
    {
        $this->config['min'] = $min;
        return $this;
    }

    public function max(string $max): self
    {
        $this->config['max'] = $max;
        return $this;
    }
    public function toArray(): array
    {
        return array_merge($this->config, [
            'type' => 'datepicker'
        ]);
    }

}
