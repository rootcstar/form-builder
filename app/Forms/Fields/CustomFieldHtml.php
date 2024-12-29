<?php

namespace RootCStar\FormBuilder\Forms\Fields;

use RootCStar\FormBuilder\Forms\FormField;

class CustomFieldHtml extends FormField {
    protected $html = '';

    public function html(string $html): self {
        $this->html = $html;
        return $this;
    }

    public function toArray(): array {
        return array_merge($this->config, [
            'type' => 'custom-field-html',
            'html' => $this->html
        ]);
    }

}
