$(function() {
    $('#signin-form').on('submit', function(e) {
        e.preventDefault();
        $(':input').attr('disabled', true)
        let data = new FormData();
        data.append('identity', $('#email-input').val());
        data.append('password', $('#password-input').val());
        data.append($('#csrf-token').attr('name'), $('#csrf-token').val());

        axios.post(`/api/signin`, data)
            .then(res => {
                window.location.href = '/admin';
            })
            .catch(e => {
                $('#login-error').html('<small class="text-danger">Email atau password salah.</small>').show();
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
})