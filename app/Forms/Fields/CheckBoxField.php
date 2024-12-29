<?php

namespace RootCStar\FormBuilder\Forms\Fields;
use RootCStar\FormBuilder\Forms\FormField;

class CheckBoxField extends FormField{
    protected $options = [];
    public function multiple(bool $multiple = true): self
    {
        $this->config['multiple'] = $multiple;
        return $this;
    }
    public function inline(bool $inline = true): self
    {
        $this->config['inline'] = $inline;
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
            'type' => 'checkbox',
            'options' => $this->options
        ]);
    }

}
