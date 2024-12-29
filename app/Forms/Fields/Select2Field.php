<?php

namespace RootCStar\FormBuilder\Forms\Fields;

use RootCStar\FormBuilder\Forms\FormField;

class Select2Field extends FormField
{
    protected $options = [];

    public function multiple(bool $multiple = true): self
    {
        $this->config['multiple'] = $multiple;
        return $this;
    }

    public function options(array $options): self
    {
        $formattedOptions = [];
        foreach ($options as $value => $description) {
            $formattedOptions[] = [
                'value' => $value,
                'description' => $description
            ];
        }
        $this->options = $formattedOptions;
        return $this;
    }

    public function toArray(): array
    {
        return array_merge($this->config, [
            'type' => 'selectbox-select2',
            'options' => $this->options
        ]);
    }
}
