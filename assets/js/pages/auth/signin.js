$(function() {
    $('#signin-form').on('submit', function(e) {
        e.preventDefault();
        $(':input').attr('disabled', true)
        let data = new FormData();
        data.append('email', $('#email-input').val().trim());
        data.append('password', $('#password-input').val());
        data.append('phrase', $('#captcha-input').val());
        data.append($('#csrf-token').attr('name'), $('#csrf-token').val());

        axios.post(`/api/signin`, data)
            .then(res => {
                if(res.data.success) {
                    window.location.href = '/dashboard';
                }
            })
            .catch(e => {
                if(e.response.data.validation) {
                    Object.entries(e.response.data.validation).forEach(([k, v]) => {
                        $('#'+k+'-error').text(v)
                    })
                }
                $('#captcha-image').attr('src', e.response.data.captcha)
                $('#csrf-token').val(e.response.data.csrf)
            })
            .finally(() => {
                $(':input').attr('disabled', false)
            })
    })

    $('#email-input').on('keyup', function(){
        $('#login-error').hide()
    })
    $('#password-input').on('keyup', function(){
        $('#login-error').hide()
    })

    let show_pass = false;
    $('#show-pass').on('click', function() {
        if(show_pass) {
            $(this).html('<i class="bi bi-eye-fill"></i>');
            $('#password-input').attr('type', 'text');
        } else {
            $(this).html('<i class="bi bi-eye-slash-fill"></i>');
            $('#password-input').attr('type', 'password');
        }
        show_pass = !show_pass;
    })
})