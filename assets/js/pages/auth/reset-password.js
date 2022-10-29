$(function() {
    $('#reset-password-form').on('submit', function(e) {
        e.preventDefault();
        $(':input').attr('disabled', true)
        let data = new FormData();
        data.append('password', $('#password-input').val());
        data.append('confirm_password', $('#confirm-password-input').val());
        data.append('forgot_password_token', $('#forgot-password-token').val());
        data.append($('#csrf-token').attr('name'), $('#csrf-token').val());

        axios.post(`/api/reset-password`, data)
            .then(res => {
                $('#success-body').show();
                $('#reset-password-form').hide();
            })
            .catch(e => {
                if(e.response.data.validation) {
                    $('#password-error').html(e.response.data.validation.password).show();
                    $('#confirm-password-error').html(e.response.data.validation.confirm_password).show();
                }
                $('#csrf-token').val(e.response.data.csrf)
            })
            .finally(() => {
                $(':input').attr('disabled', false)
            })
    })

    $('#password-input').on('keyup', function(){
        $('#password-error').hide()
    })
    $('#confirm-password-input').on('keyup', function(){
        $('#confirm-password-error').hide()
    })
})