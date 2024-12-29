# Laravel Form Builder

A flexible and easy-to-use Form Builder package for Laravel applications that helps you create forms with various field types and customization options.

## Installation

You can install the package via composer:

```bash
composer require rootcstar/form-builder
```

## Publishing Views

You can publish the views using:

```bash
php artisan vendor:publish --tag=form-builder-views
```
## JavaScript Integration

After installing the package, publish the JavaScript assets:

```bash
php artisan vendor:publish --tag=form-builder-scripts
```
Make sure your layout file includes the necessary style and script sections:
```php
<!DOCTYPE html>
<html>
<head>
    <!-- Other head elements -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @stack('styles')
</head>
<body>
    <!-- Your content -->
    
    @stack('scripts')
</body>
</html>
```

## Usage

Here's a comprehensive guide on how to use the Form Builder:

### Basic Form Creation

```php
use RootCStar\FormBuilder\Forms\FormBuilder;

$form = FormBuilder::create(
    'form-id',           // Unique form ID
    route('home'),       // Form action URL
    route('home'),       // Redirect URL after submission
    'Form Title',        // Optional form title
    'Form Subtitle'      // Optional form subtitle
);
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

#### Custom HTML Field
```php
$form->customFieldHtml('<h1>Custom Field HTML</h1>', 'optional label');
```

#### File Upload Fields
```php
// Single File Upload
$form->fileField('document', 'Upload Single File')
    ->required()
    ->fieldWarning('max file size 2 mb')
    ->accept('.pdf,.doc,.docx');

// Multiple File Upload
$form->fileField('photos', 'Upload Multiple Files')
    ->required()
    ->multiple()
    ->accept('image/*');
```

#### Select Fields
```php
// Single Select
$form->selectField('role', 'Single Select')
    ->required()
    ->options([
        1 => 'option 1',
        2 => 'option 2',
        3 => 'option 3'
    ])
    ->selected(2);

// Multiple Select
$form->selectField('permissions', 'Multiple Select')
    ->required()
    ->multiple()
    ->options([
        'create' => 'option 1',
        'read' => 'option 2',
        'update' => 'option 3',
        'delete' => 'option 4'
    ])
    ->selected('read');
```

#### Select2 Fields
```php
// Single Select2
$form->select2Field('role', 'Single Select with select2')
    ->required()
    ->options([
        1 => 'option 1',
        2 => 'option 2',
        3 => 'option 3'
    ])
    ->selected(2);

// Multiple Select2
$form->select2Field('permissions', 'Multiple Select with select2')
    ->required()
    ->multiple()
    ->options([
        'create' => 'option 1',
        'read' => 'option 2',
        'update' => 'option 3',
        'delete' => 'option 4'
    ])
    ->selected('read');
```

#### Textarea Field
```php
$form->textAreaField('description', 'Text Area Field')
    ->required()
    ->placeholder('Enter your description')
    ->value('Lorem ipsum dolor sit amet');
```

#### Telephone Field
```php
$form->telephoneField('phone', 'Phone Field')
    ->required()
    ->placeholder('Enter your phone number')
    ->value('1234567890');
```

#### Password Field
```php
$form->passwordField('password', 'Password Field')
    ->required()
    ->placeholder('Enter your password');
```

#### Date Picker Field
```php
$form->datePickerField('date', 'Date Field')
    ->required()
    ->fieldWarning('mm/dd/yyyy')
    ->value('2021-01-03');
```

#### Checkbox Field
```php
$form->checkboxField('terms', 'Choose to agree one')
    ->required()
    ->options([
        'create' => 'option 1',
        'read' => 'option 2',
        'update' => 'option 3',
        'delete' => 'option 4'
    ])
    ->multiple()
    ->inline();
```

### Rendering the Form

Add a submit button and render the form:
```php
$form->submitButton('Submit Form');

return view('your.view', [
    'form' => $form->render(),
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
