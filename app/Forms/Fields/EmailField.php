<?php

namespace RootCStar\FormBuilder\Forms\Fields;

use RootCStar\FormBuilder\Forms\FormField;

class EmailField extends FormField {
    public function toArray(): array {
        return array_merge($this->config, [
            'type' => 'email'
        ]);
    }
}
