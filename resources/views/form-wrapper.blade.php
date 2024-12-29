{{-- resources/views/components/form-wrapper.blade.php --}}
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">{{$form['title']}}</h4>
            <h5 class="card-subtitle"> {{$form['subtitle']}}</h5>
            <form class="row g-3 needs-validation" id="{{ $form['form_id'] }}" novalidate>
                @csrf
                <input type="hidden" id="url" value="{{ $form['url'] }}">
                <input type="hidden" id="form_id" value="{{ $form['form_id'] }}">
                @if($form['redirect'])
                    <input type="hidden" id="redirect" value="{{ $form['redirect'] }}">
                @endif

                @foreach($form['fields'] as $field)

                    @if ($field['type'] !== 'hidden')

                        <div class="col-md-6 form-group mb-3">
                            <label for="{{ $field['name'] }}" class="form-label">{{ $field['label'] }}<span
                                    style="color:red;">{{$field['required'] ? '*' : ''}}</span></label>
                            <span class=""
                                  style="width:100%; color:red;">{{ isset($field['field_warning']) ? '( '.$field['field_warning'].' )':'' }}</span>

                            @switch($field['type'])
                                @case('selectbox')
                                    <select
                                        class="form-control {{ $field['disabled'] ? '' : 'input-fields' }}"
                                        style="width:100%;"
                                        id="{{ $field['name'] }}"
                                        name="{{ $field['name'] }}{{ isset($field['multiple']) && $field['multiple'] ? '[]' : '' }}"
                                        {{ $field['required'] ? 'required' : '' }}

                                        {{ isset($field['multiple']) && $field['multiple'] ? 'multiple' : '' }}
                                    >
                                        <option value="" disabled>
                                            Select {{ isset($field['multiple']) && $field['multiple'] ? 'multiple option with holding ctrl key' : 'an option'}}</option>
                                        @foreach($field['options'] as $option)
                                            <option
                                                value="{{ $option['value'] }}" {{(isset($field['value']) && ($field['value'] == $option['value'])) ? 'selected': ''}}>{{ $option['description'] }}</option>
                                        @endforeach
                                    </select>
                                    @break
                                @case('selectbox-select2')
                                    <select
                                        class="select2 form-control {{ $field['disabled'] ? '' : 'input-fields' }}"
                                        style="width:100%;"
                                        id="{{ $field['name'] }}"
                                        name="{{ $field['name'] }}{{ isset($field['multiple']) && $field['multiple'] ? '[]' : '' }}"
                                        {{ $field['required'] ? 'required' : '' }}
                                        {{ $field['disabled'] ? 'disabled' : '' }}
                                        {{ isset($field['multiple']) && $field['multiple'] ? 'multiple' : '' }}
                                    >
                                        <option value=""
                                                {{ isset($field['multiple']) && $field['multiple'] ? '' : 'selected' }} disabled>
                                            Select an option
                                        </option>
                                        @foreach($field['options'] as $option)
                                            <option
                                                value="{{ $option['value'] }}" {{(isset($field['value']) && ($field['value'] == $option['value'])) ? 'selected': ''}}>{{ $option['description'] }}</option>
                                        @endforeach
                                    </select>
                                    @break

                                @case('file')
                                    <input
                                        type="file"
                                        class="form-control {{ $field['disabled'] ? '' : 'input-fields' }}"
                                        id="{{ $field['name'] }}"
                                        name="{{ $field['name'] }}{{ isset($field['multiple']) && $field['multiple'] ? '[]' : '' }}"
                                        {{ $field['required'] ? 'required' : '' }}
                                        {{ $field['disabled'] ? 'disabled' : '' }}
                                        {{ isset($field['multiple']) && $field['multiple'] ? 'multiple' : '' }}
                                        {{ isset($field['accept']) ? 'accept='.$field['accept'] : '' }}
                                    >
                                    @break

                                @case('number')
                                    <input
                                        type="number"
                                        class="form-control {{ $field['disabled'] ? '' : 'input-fields' }}"
                                        id="{{ $field['name'] }}"
                                        name="{{ $field['name'] }}"
                                        placeholder="{{ $field['placeholder'] ?? '' }}"
                                        value="{{ $field['value'] ?? '' }}"
                                        {{ $field['required'] ? 'required' : '' }}
                                        {{ $field['disabled'] ? 'disabled' : '' }}
                                        {{ isset($field['min']) ? "min={$field['min']}" : '' }}
                                        {{ isset($field['max']) ? "max={$field['max']}" : '' }}
                                    >
                                    @break
                                @case('text')
                                    <input
                                        type="{{ $field['type'] }}"
                                        class="form-control {{ $field['disabled'] ? '' : 'input-fields' }}"
                                        id="{{ $field['name'] }}"
                                        name="{{ $field['name'] }}"
                                        placeholder="{{ $field['placeholder'] ?? '' }}"
                                        value="{{ $field['value'] ?? '' }}"
                                        {{ $field['required'] ? 'required' : '' }}
                                        {{ $field['disabled'] ? 'disabled' : '' }}
                                    >
                                    @break

                                @case('textarea')
                                    <textarea
                                        class="form-control {{ $field['disabled'] ? '' : 'input-fields' }}"
                                        id="{{ $field['name'] }}"
                                        name="{{ $field['name'] }}"
                                        placeholder="{{ $field['placeholder'] ?? '' }}"
                                    {{ $field['required'] ? 'required' : '' }}
                                        {{ $field['disabled'] ? 'disabled' : '' }}
                                >{{ $field['value'] ?? '' }}</textarea>
                                    @break
                                @case('datepicker')
                                    <input
                                        type="date"
                                        class="form-control {{ $field['disabled'] ? '' : 'input-fields' }}"
                                        id="{{ $field['name'] }}"
                                        name="{{ $field['name'] }}"
                                        placeholder="{{ $field['placeholder'] ?? '' }}"
                                        value="{{ $field['value'] ?? '' }}"
                                        {{ $field['required'] ? 'required' : '' }}
                                        {{ $field['disabled'] ? 'disabled' : '' }}
                                    >
                                    @break
                                @case('checkbox')
                                    @php($count = 0)
                                    @foreach($field['options'] as $option)
                                        <div
                                            class="form-check {{isset($field['inline']) && $field['inline'] ? 'form-check-inline':''}}">
                                            <input
                                                class="form-check-input {{ $field['disabled'] ? '' : 'input-fields' }}"
                                                type="checkbox"
                                                id="{{ $field['name'].'_'.$count }}"
                                                name="{{ $field['name'] }}{{ isset($field['multiple']) && $field['multiple'] ? '[]' : '' }}"
                                                value="{{ $option['value'] }}"
                                                {{(isset($field['value']) && ($field['value'] == $option['value'])) ? 'checked': ''}}
                                                {{ $field['required'] ? 'required' : '' }}
                                                {{ $field['disabled'] ? 'disabled' : '' }}
                                            >
                                            <label class="form-check-label"
                                                   for="{{ $field['name'].'_'.$count }}">{{ $option['description'] }}</label>
                                        </div>
                                        @php($count++)
                                    @endforeach
                                    @break
                                @case('custom-field-html')
                                    {!! $field['html'] !!}
                                    @break

                                @default
                                    <input
                                        type="{{ $field['type'] }}"
                                        class="form-control {{ $field['disabled'] ? '' : 'input-fields' }}"
                                        id="{{ $field['name'] }}"
                                        name="{{ $field['name'] }}"
                                        placeholder="{{ $field['placeholder'] ?? '' }}"
                                        value="{{ $field['value'] ?? '' }}"
                                        {{ $field['required'] ? 'required' : '' }}
                                        {{ $field['disabled'] ? 'disabled' : '' }}
                                    >
                            @endswitch

                            <div class="invalid-feedback">
                                {{ $field['invalid_feedback'] }}
                            </div>
                        </div>
                    @else
                        <!-- For hidden fields, do nothing or render the field value -->
                        <input type="hidden" id="{{ $field['name'] }}" class="input-fields" name="{{ $field['name'] }}"
                               value="{{ $field['value'] }}">
                    @endif
                @endforeach

                @if(isset($form['submit-button']))
                    <div class="col-md-12">
                        <div class="btn {{$form['submit-button']['class']}} form-submit"
                             id="form-builder-form-submit">{{$form['submit-button']['text']}}</div>
                    </div>
                @endif

            </form>
        </div>
    </div>
</div>
@push('scripts')
    @if(config('form-builder.load_jquery', true))
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @endif

    @if(config('form-builder.load_select2', true))
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endif

    @if(config('form-builder.load_sweetalert', true))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endif

    <script>
        (function($) {
            // Your form builder code here
        })(jQuery.noConflict(true)); // Use noConflict to avoid conflicts
    </script>
@endpush

@push('styles')
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
