<?php

namespace RootCStar\FormBuilder\Forms\Fields;

use RootCStar\FormBuilder\Forms\FormField;

class FileUploadField extends FormField
{
    protected $multiple = false;
    protected $accept = '';

    public function multiple(bool $multiple = true): self
    {
        $this->config['multiple'] = $multiple;
        return $this;
    }

    public function accept(string $fileTypes): self
    {
        // Example: accept('.pdf,.doc,.docx') or 'image/*'
        $this->config['accept'] = $fileTypes;
        return $this;
    }

    public function toArray(): array
    {
        return array_merge($this->config, [
            'type' => 'file'
        ]);
    }
}
