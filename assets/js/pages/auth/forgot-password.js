$(function() {
    $('#forgot-password-form').on('submit', function(e) {
        e.preventDefault();
        $(':input').attr('disabled', true)
        let data = new FormData();
        data.append('email', $('#email-input').val());
        data.append($('#csrf-token').attr('name'), $('#csrf-token').val());

        axios.post(`/api/forgot-password`, data)
            .then(res => {
                $('#forgot-password-success').html(res.data.message).show();
                $('#csrf-token').val(res.data.csrf)
            })
            .catch(e => {
                switch (e.response.status) {
                    case 400:
                        $('#forgot-password-error').html(e.response.data.validation.email).show();
                        break;
                    default:
                        $('#forgot-password-error').html(e.response.data.message).show();
                        break;
                }
                $('#csrf-token').val(e.response.data.csrf)
            })
            .finally(() => {
                $(':input').attr('disabled', false)
            })
    })

    $('#email-input').on('keyup', function(){
        $('#forgot-password-error').hide()
        $('#forgot-password-success').hide()
    })
})