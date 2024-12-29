<?php

namespace RootCStar\FormBuilder\Forms;

abstract class FormField
{
    protected $config = [];

    public function __construct(string $name, string $label)
    {
        $this->config = [
            'name' => $name,
            'label' => $label,
            'required' => false,
            'disabled' => false,
            'invalid_feedback' => 'This field is required',
            'value' => null,
            'field_warning' => null,
        ];
    }

    public function selected(string $selected_value = null): self
    {
        $this->config['value'] = $selected_value;
        return $this;
    }
    public function value(string $value = null): self
    {
        $this->config['value'] = $value;
        return $this;
    }
    public function required(bool $required = true): self
    {
        $this->config['required'] = $required;
        return $this;
    }
    public function fieldWarning(string $warning_text = null): self
    {
        $this->config['field_warning'] = $warning_text;
        return $this;
    }

    public function disabled(bool $disabled = true): self
    {
        $this->config['disabled'] = $disabled;
        return $this;
    }

    public function placeholder(string $placeholder): self
    {
        $this->config['placeholder'] = $placeholder;
        return $this;
    }

    public function invalidFeedback(string $message): self
    {
        $this->config['invalid_feedback'] = $message;
        return $this;
    }

    abstract public function toArray(): array;
}
