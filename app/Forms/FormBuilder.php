<?php

namespace RootCStar\FormBuilder\Forms;

use Illuminate\Encryption\Encrypter;
use RootCStar\FormBuilder\Forms\Fields\CheckBoxField;
use RootCStar\FormBuilder\Forms\Fields\CustomFieldHtml;
use RootCStar\FormBuilder\Forms\Fields\DatePicker;
use RootCStar\FormBuilder\Forms\Fields\EmailField;
use RootCStar\FormBuilder\Forms\Fields\FileUploadField;
use RootCStar\FormBuilder\Forms\Fields\HiddenField;
use RootCStar\FormBuilder\Forms\Fields\NumberField;
use RootCStar\FormBuilder\Forms\Fields\PasswordField;
use RootCStar\FormBuilder\Forms\Fields\Select2Field;
use RootCStar\FormBuilder\Forms\Fields\SelectField;
use RootCStar\FormBuilder\Forms\Fields\TelephoneField;
use RootCStar\FormBuilder\Forms\Fields\TextAreaField;
use RootCStar\FormBuilder\Forms\Fields\TextField;

class FormBuilder {
    private const SECRET_KEY = 'xAsMrIiYoOwrEwgWYoVqmiftuj7OvAAC';

    protected $form = [];
    protected $fields = [];

    private function __construct() {
        $this->form = [
            'form_id' => null,
            'api_url' => null,
            'proxy_url' => null,
            'redirect_url' => null,
            'api_method' => 'POST',
            'title' => null,
            'subtitle' => null,
            'fields' => []
        ];
    }

    public static function create(): self {
        return new self();
    }

    public function formId(string $formId): self {
        $this->form['form_id'] = $formId;
        return $this;
    }

    public function apiUrl(string $url, bool $encrypt = true): self {
        $this->form['api_url'] = $encrypt ? self::encrypt($url) : $url;
        if ($this->form['proxy_url'] === null) {
            $this->form['proxy_url'] = $url;
        }
        return $this;
    }

    public function proxyUrl(string $url): self {
        $this->form['proxy_url'] = $url;
        return $this;
    }

    public function redirectUrl(?string $url): self {
        $this->form['redirect_url'] = $url;
        return $this;
    }

    public function title(?string $title): self {
        $this->form['title'] = $title;
        return $this;
    }

    public function subtitle(?string $subtitle): self {
        $this->form['subtitle'] = $subtitle;
        return $this;
    }

    public function apiMethod(string $method): self {
        $this->form['api_method'] = $method;
        return $this;
    }

    public function customFieldHtml(string $html, string $label = '', string $name = ''): FormField {
        $field = new CustomFieldHtml($name, $label);
        $field->html($html);
        $this->fields[] = $field;
        return $field;
    }

    public function submitButton(string $text = 'Submit', string $class = 'btn-primary'): self {
        $this->form['submit-button'] = [
            'text' => $text,
            'class' => $class
        ];
        return $this;
    }

    public function textField(string $name, string $label): FormField {
        $field = new TextField($name, $label);
        $this->fields[] = $field; // Store the field object instead of the array
        return $field;
    }

    public function numberField(string $name, string $label): FormField {
        $field = new NumberField($name, $label);
        $this->fields[] = $field; // Store the field object instead of the array
        return $field;
    }


    public function hiddenField(string $name, string $label): FormField {
        $field = new HiddenField($name, $label);
        $this->fields[] = $field;
        return $field;
    }

    public function telephoneField(string $name, string $label): FormField {
        $field = new TelephoneField($name, $label);
        $this->fields[] = $field;
        return $field;
    }

    public function emailField(string $name, string $label): FormField {
        $field = new EmailField($name, $label);
        $this->fields[] = $field;
        return $field;
    }

    public function passwordField(string $name, string $label): FormField {
        $field = new PasswordField($name, $label);
        $this->fields[] = $field;
        return $field;
    }

    public function selectField(string $name, string $label, ?string $selected = null): SelectField {
        $field = new SelectField($name, $label, $selected);
        $this->fields[] = $field; // Store the field object instead of the array
        return $field;
    }

    public function select2Field(string $name, string $label, ?string $selected = null): Select2Field {
        $field = new Select2Field($name, $label, $selected);
        $this->fields[] = $field; // Store the field object instead of the array
        return $field;
    }

    public function fileField(string $name, string $label): FileUploadField {
        $field = new FileUploadField($name, $label);
        $this->fields[] = $field;
        return $field;
    }

    public function textAreaField(string $name, string $label): FormField {
        $field = new TextAreaField($name, $label);
        $this->fields[] = $field;
        return $field;
    }

    public function datePickerField(string $name, string $label): FormField {
        $field = new DatePicker($name, $label);
        $this->fields[] = $field;
        return $field;
    }

    public function checkboxField(string $name, string $label): FormField {
        $field = new CheckBoxField($name, $label);
        $this->fields[] = $field;
        return $field;
    }

    public function render() {
        $this->form['fields'] = array_map(function ($field) {
            return $field->toArray();
        }, $this->fields);

        return view('form-builder::form-wrapper', [
            'form' => $this->form,
            'jquery_loaded' => defined('JQUERY_LOADED'),
            'select2_loaded' => defined('SELECT2_LOADED'),
            'sweetalert_loaded' => defined('SWEETALERT_LOADED')
        ]);
    }

    public static function encrypt(string $value): string {
        $key = hash('sha256', self::SECRET_KEY, true);
        $cipher = 'AES-256-CBC';

        $encrypter = new Encrypter($key, $cipher);

        $encrypted = $encrypter->encrypt($value);

        return $encrypted;
    }

    public static function decrypt(string $value): string {
        $key = hash('sha256', self::SECRET_KEY, true);
        $cipher = 'AES-256-CBC';

        $encrypter = new Encrypter($key, $cipher);

        $decrypted = $encrypter->decrypt($value);

        return $decrypted;
    }
}
