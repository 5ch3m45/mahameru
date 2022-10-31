$(function() {
    function getProfile() {
        axios.get('/api/dashboard/profile')
            .then(res => {
                console.log(res)
                const { name, email } = res.data.data;
                $('input[name=name]').val(name);
                $('input[name=email]').val(email);
            })
            .catch(e => {
                console.log(e);
                $.notify('Terjadi kesalahan', 'error');
            });
    }

    getProfile();

    $('#form-profile').on('submit', function(e) {
        $("#form-profile [type=submit]").html('<image src="/assets/images/loader/loading-light.svg"/>');
        e.preventDefault();

        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        data.append('name', $('input[name=name]').val());
        axios.post('/api/dashboard/profile/update/name', data)
            .then(res => {
                $('meta[name=token_hash]').attr('content', res.data.csrf);
                $.notify('Berhasil disimpan.', 'success');
            })
            .catch(err => {
                $('meta[name=token_hash]').attr('content', err.response.data.csrf);
                $.notify('Terjadi kesalahan.', 'error');
                getProfile();
            })
            .finally(() => {
                $("#form-profile [type=submit]").html('Simpan');
            });
    });

    $('#form-keamanan').on('submit', function(e) {
        $("#form-keamanan [type=submit]").html('<image src="/assets/images/loader/loading-light.svg"/>');

        e.preventDefault();

        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        data.append('new_password', $('input[name=new_password]').val());
        data.append('new_password_confirm', $('input[name=new_password_confirm]').val());
        axios.post('/api/dashboard/profile/update/password', data)
            .then(res => {
                $('meta[name=token_hash]').attr('content', res.data.csrf);
                $('input[name=new_password]').val('');
                $('input[name=new_password_confirm]').val('');
                $.notify('Berhasil disimpan.', 'success');
            })
            .catch(err => {
                $('meta[name=token_hash]').attr('content', err.response.data.csrf);
                $.notify('Terjadi kesalahan.', 'error');
                if(err.response.data.validation) {
                    $('#error_new_password').html(err.response.data.validation.new_password);
                    $('#error_new_password_confirm').html(err.response.data.validation.new_password_confirm);
                }
            })
            .finally(() => {
                $("#form-keamanan [type=submit]").html('Simpan');
            });
    });

    $('input[name=new_password]').on('keyup', function() {
        $('#error_new_password').html('');
    });
    $('input[name=new_password_confirm]').on('keyup', function() {
        $('#error_new_password_confirm').html('');
    });
});