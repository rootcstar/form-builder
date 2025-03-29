<?php

namespace RootCStar\FormBuilder\Forms\Fields;

use RootCStar\FormBuilder\Forms\FormField;

class TextField extends FormField {
    public function pattern(string $pattern): self {
        $this->config['pattern'] = $pattern;
        return $this;
    }

    public function minLength(int $min_length): self {
        $this->config['min_length'] = $min_length;
        return $this;
    }

    public function maxLength(int $max_length): self {
        $this->config['max_length'] = $max_length;
        return $this;
    }

    public function toArray(): array {
        return array_merge($this->config, [
            'type' => 'text'
        ]);
    }
}
