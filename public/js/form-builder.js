// Initialize Select2
$(document).ready(function() {
    $('.select2').select2();
});

// Form validation on input
$(document).on('input', '.needs-validation-form-builder input, select, textarea', function() {
    $(this).toggleClass('is-valid', this.checkValidity())
        .toggleClass('is-invalid', !this.checkValidity());
});

// Form submission handler
$('.form-builder-form-submit').click(function () {
    const form = $(this).closest('form');
    const form_id = form.attr('id');
    const formElement = $(`#${form_id}`);

    if (!form_validation(form_id)) {
        Swal.fire({
            icon: 'info',
            title: 'Please check the form before sending'
        });
        return;
    }

    const formData = new FormData();
    $(`#${form_id} .input-fields`).each(function () {
        if ($(this).prop('disabled')) return;
        const name = $(this).attr('name');
        if ($(this).attr('type') === 'checkbox') {
            if (!$(this).is(':checked')) return;
            const value = JSON.stringify($(`input:checkbox[name="${name}"]:checked`).map(function() { return $(this).val(); }).get());
            formData.append(name, value);
        } else if ($(this).attr('type') === 'file') {
            const files = $(this).prop('files');
            for (let i = 0; i < files.length; i++) {
                formData.append(name, files[i]);
            }
        } else if ($(this).hasClass('select2')) {
            const values = $(this).val();
            values.forEach(val => formData.append(name, isNaN(val) ? val : parseInt(val)));
        } else {
            formData.append(name, $(this).val());
        }
    });

    const api_method = formElement.find('#api_method').val();
    const api_url = formElement.find('#api_url').val();
    formData.append('api_method', api_method);
    formData.append('api_url', api_url);

    const proxy_url = formElement.find('#proxy_url').val();
    const redirect_url = formElement.find('#redirect_url').val();
    send_request(proxy_url, formData, redirect_url);
});

function form_validation(form_id) {
    let is_valid = true;
    const inputs = $(`#${form_id} .input-fields`);
    inputs.each(function () {
        const input = $(this);
        if (!input.prop('required')) return;

        if (input.attr('type') === 'file' && !input.prop('files').length) {
            input.addClass('is-invalid');
            is_valid = false;
        } else if (!input.val()) {
            input.addClass('is-invalid');
            is_valid = false;
        }
    });

    return is_valid;
}

async function send_request(proxy_url, form_data, redirect_url) {
    try {
        Swal.fire({
            title: 'Submitting...',
            html: 'Please wait, your request is being processed.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        const response = await fetch(proxy_url, {
            method: "POST",
            body: form_data
        });

        const data = await response.json();

        const swalConfig = {
            success: {
                icon: 'success',
                title: data.msg,
                text: redirect_url ? `Redirecting...` : '',
                timer : 1500,
                timerProgressBar: true
            },
            unauthorized: {
                icon: 'error',
                title: 'Unauthorized',
                text: `${data.msg}\nLogging out...`,
                timer : 1500,
                timerProgressBar: true
            },
            error: {
                icon: 'warning',
                title: 'Oopsssss...',
                text: data.msg
            }
        };

        let config;
        let shouldRedirect = false;
        let redirectPath = redirect_url;

        if (response.ok) {
            config = swalConfig.success;
            shouldRedirect = !!redirect_url;
        } else if (response.status === 401) {
            config = swalConfig.unauthorized;
            shouldRedirect = true;
            redirectPath = '/logout';
        } else {
            config = swalConfig.error;
        }

        await Swal.fire(config).then(
            (result) => {
                if (result.dismiss === Swal.DismissReason.timer && shouldRedirect) {
                    window.location.href = redirectPath
                }
            }
        );

    } catch (error) {
        console.error('Request failed:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An unexpected error occurred. Please try again.'
        });
    }
}
