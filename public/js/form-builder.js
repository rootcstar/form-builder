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
        Swal.fire({
            icon: 'info',
            title: 'Please fill out empty field !'
        });
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
        if ($(this).prop('required') && !$(this).val()) {
            $(this).addClass('is-invalid');
            is_valid = false;
        }
    });
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
var loadFile = function (event) {
    var output = document.getElementById('new-img');
    var imageInfo = document.getElementById('image-info');
    var file = event.target.files[0];

    if (file) {
        output.src = URL.createObjectURL(file);

        // Görsel yüklendikten sonra boyutlarını alıp ekrana yazdır
        var img = new Image();
        img.onload = function () {
            const width = this.width;
            const height = this.height;

            imageInfo.textContent = Uploaded image size: ${width}x${height};
        };
        img.src = output.src;

        // Görsel yüklendiğinde bellekten kaldırmak için
        output.onload = function () {
            URL.revokeObjectURL(output.src);
        };
    } else {
        // Dosya seçilmezse
        imageInfo.textContent = "No file selected.";
        output.src = "";
    }
};
