# Laravel Form Builder

A flexible and easy-to-use Form Builder package for Laravel applications that helps you create forms with various field types and customization options.

## Installation

You can install the package via composer:

```bash
composer require rootcstar/form-builder
```

## Publishing Assets

```bash
# Publish config
php artisan vendor:publish --tag=form-builder-config

# Publish views
php artisan vendor:publish --tag=form-builder-views --force

# Publish JavaScript
php artisan vendor:publish --tag=form-builder-scripts --force
```

## Usage

Here's a comprehensive guide on how to use the Form Builder:

### Basic Form Creation

```php
use RootCStar\FormBuilder\Forms\FormBuilder;

$form = FormBuilder::create()
    ->formId('my-form')
    ->apiUrl('/api/endpoint')      // API endpoint for form submission
    ->proxyUrl('/proxy/endpoint')  // Optional proxy URL (defaults to apiUrl if not set)
    ->redirectUrl('/success')      // Optional redirect URL after submission
    ->apiMethod('POST')           // HTTP method (defaults to POST)
    ->title('Form Title')         // Optional form title
    ->subtitle('Form Subtitle');  // Optional form subtitle
```

### Available Field Types

#### Text Field
```php
$form->textField('name', 'Full Name')
    ->required()
    ->placeholder('Enter your name')
    ->value('John Doe');
```

#### Number Field
```php
$form->numberField('age', 'Age')
    ->required()
    ->min(18)
    ->max(100)
    ->value(25);
```

#### Hidden Field
```php
$form->hiddenField('user_id', '')
    ->value(1);
```

#### Custom HTML Field
```php
$form->customFieldHtml('<div class="alert alert-info">Custom HTML</div>', 'Optional Label');
```

#### File Upload Fields
```php
// Single File Upload
$form->fileField('document', 'Upload File')
    ->required()
    ->fieldWarning('Max file size: 2MB')
    ->accept('.pdf,.doc,.docx');

// Multiple File Upload
$form->fileField('photos', 'Upload Images')
    ->required()
    ->multiple()
    ->accept('image/*');
```

#### Select Fields
```php
// Basic Select
$form->selectField('country', 'Select Country')
    ->required()
    ->options([
        'us' => 'United States',
        'uk' => 'United Kingdom'
    ])
    ->selected('us');

// Multiple Select
$form->selectField('skills', 'Select Skills')
    ->required()
    ->multiple()
    ->options([
        'php' => 'PHP',
        'js' => 'JavaScript',
        'python' => 'Python'
    ])
    ->selected(['php', 'js']);
```

#### Select2 Fields
```php
// Single Select2
$form->select2Field('category', 'Select Category')
    ->required()
    ->options([
        1 => 'Category 1',
        2 => 'Category 2'
    ])
    ->selected(1);

// Multiple Select2
$form->select2Field('tags', 'Select Tags')
    ->required()
    ->multiple()
    ->options([
        'tag1' => 'Tag 1',
        'tag2' => 'Tag 2'
    ])
    ->selected(['tag1']);
```

#### Email Field
```php
$form->emailField('email', 'Email Address')
    ->required()
    ->placeholder('Enter your email');
```

#### Password Field
```php
$form->passwordField('password', 'Password')
    ->required()
    ->placeholder('Enter your password');
```

#### Telephone Field
```php
$form->telephoneField('phone', 'Phone Number')
    ->required()
    ->placeholder('Enter your phone number');
```

#### Textarea Field
```php
$form->textAreaField('description', 'Description')
    ->required()
    ->placeholder('Enter description')
    ->rows(5);
```

#### Date Picker Field
```php
$form->datePickerField('birth_date', 'Birth Date')
    ->required()
    ->fieldWarning('Format: MM/DD/YYYY')
    ->value('2024-01-01');
```

#### Checkbox Field
```php
$form->checkboxField('terms', 'Terms and Conditions')
    ->required()
    ->options([
        'agree' => 'I agree to the terms',
        'newsletter' => 'Subscribe to newsletter'
    ])
    ->multiple()
    ->inline();
```

### Rendering the Form

Add a submit button and render the form:
```php
$form->submitButton('Save Changes', 'btn-primary');

return view('your.view', [
    'form' => $form->render()
]);
```

In your Blade view:
```php
{!! $form !!}
```

## Requirements

- PHP ^8.2|^8.3
- Laravel ^10.0|^11.0

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

- [RootCStar](https://github.com/rootcstar)
