// Form validation on input
$(function () {
    $('.needs-validation-form-builder').find('input,select,textarea,input[type=radio],input[type=tel],input[type=checkbox],input[type=time]').on('input', function () {
        $(this).removeClass('is-valid is-invalid')
            .addClass(this.checkValidity() ? 'is-valid' : 'is-invalid');

    });
});

// Initialize Select2
$(document).ready(function() {
    $('.select2').select2();
});

// Form submission handler
$('.form-builder-form-submit').click(function () {

    const form = $(this).closest('form');
    const form_id = form.attr('id');
    const url = $(`#${form_id} #url`).val();
    const route = $('#redirect').val();

    if (!form_validation(form_id)) {

        return;
    }
    const formData = new FormData();
    const fields = [];
    let tmp_array = [];

    $(`#${form_id} .input-fields`).each(function () {
        if ($(this).prop('disabled')) return;

        const name = $(this).attr('name');
        let value;
        let field = {};

        if ($(this).attr('type') === 'checkbox') {
            if (!$(this).is(':checked')) return;

            tmp_array.push($(this).val());
            if (tmp_array.length !== $(`input:checkbox[name="${name}"]:checked`).length) return;

            value = JSON.stringify(tmp_array);
            field[name] = value;
            tmp_array = [];
        } else if (isFileInput($(this))) {
            value = $(this).prop('files')[0];
            field[name] = value;
        } else if ($(this).hasClass('select2')) {
            const selectedValues = $(this).val();
            value = JSON.stringify(selectedValues);
            field[name] = value;
        } else {
            value = $(this).val();
            field[name] = value;
        }

        fields.push(field);
        formData.append(name, value);
    });

    send_request(url, formData, route);
});

function isFileInput(input) {
    const name = input.attr('name');
    return name && (
        name.includes('img') ||
        name.includes('image') ||
        name.includes('photo') ||
        name.includes('csv')
    );
}

function form_validation(form_id) {
    let is_valid = true;

    $(`#${form_id} .input-fields`).each(function () {
        const $field = $(this);
        if($field.val() === null) {
            Swal.fire({
                icon: 'info',
                title: 'Please fill out empty field !'
            });
            is_valid = false;
            return;
        }
        const value = $field.val().trim();
        const dataType = $field.data('type');

        // Remove previous validation states
        $field.removeClass('is-invalid');

        // Required field validation
        if ($field.prop('required') && !value) {
            $field.addClass('is-invalid');
            is_valid = false;
            return; // Skip other validations if empty required field
        }

        // Skip type validation if field is empty and not required
        if (!value) return;

        // Data type validation
        switch (dataType) {
            case 'integer':
                // Matches HTML <input type="number" step="1">
                if (!/^-?\d+$/.test(value)) {
                    $field.addClass('is-invalid');
                    is_valid = false;
                    title = 'Please enter an integer';
                }
                break;

            case 'float':
                // Matches HTML <input type="number" step="any">
                if (!/^-?\d*\.?\d+$/.test(value)) {
                    $field.addClass('is-invalid');
                    is_valid = false;
                    title = 'Please enter a floating point number';
                }
                break;

            case 'email':
                // Matches HTML <input type="email">
                // This is a simplified version of the HTML5 email validation
                // HTML5 uses a more complex pattern internally
                if (!/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(value)) {
                    $field.addClass('is-invalid');
                    is_valid = false;
                    title = 'Please enter a valid email address';
                }
                break;

            case 'tel':
                // Matches pattern="[0-9]{3}[0-9]{3}[0-9]{4}"
                // Format: 10 digits without separators (e.g., 1234567890)
                if (!/^[0-9]{10}$/.test(value)) {
                    $field.addClass('is-invalid');
                    is_valid = false;
                    title = 'Please enter a valid phone number';
                }
                break;

            case 'date':
                // Matches HTML <input type="date">
                // Format: YYYY-MM-DD
                if (!/^\d{4}-\d{2}-\d{2}$/.test(value)) {
                    $field.addClass('is-invalid');
                    is_valid = false;
                    title = 'Please enter a valid date';
                } else {
                    // Additional check for valid date
                    const date = new Date(value);
                    if (isNaN(date.getTime())) {
                        $field.addClass('is-invalid');
                        is_valid = false;
                        title = 'Please enter a valid date';
                    }
                }
                break;
        }
    });

    if(!is_valid){
        Swal.fire({
            icon: 'info',
            title: title
        });
    }
    return is_valid;
}

async function send_request(url, form_data, route) {
    Swal.fire({
        title: 'Submitting...',
        html: 'Please wait, your request is being processed.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    try {
        const response = await fetch(url, {
            method: "POST",
            body: form_data,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const data = await response.json();

        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: `${data.msg}\nRedirecting...`,
            });
            setTimeout(() => {
                window.location.href = route;
            }, 1000);
        } else if (response.status === 401) {
            Swal.fire({
                icon: 'error',
                text: 'Redirecting Logging out...',
                title: data.msg,
            });
            setTimeout(() => {
                window.location.href = '/logout';
            }, 3000);
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Oopsssss...',
                text: data.msg
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An unexpected error occurred'
        });
    }
}
