$(document).ready(function() {
    $('#kodeBaruBtn').on('click', function() {
        $('#kodeBaruModal').modal('show')
    })

    $('#kodeInput').on('keyup', function() {
        $('#kodeError').html('')
    })

    $('#namaInput').on('keyup', function() {
        $('#namaError').html('')
    })

    $('#deskripsiInput').on('keyup', function() {
        $('#deskripsiError').html('')
    })

    $('tr').on('click', function() {
        window.location.href = '/admin/kode-klasifikasi/detail/'+$(this).data('id')
    })

    $('#submitKodeBtn').on('click', function() {
        $(this).html('<div class="spinner-border spinner-border-sm"></div> Menyimpan').attr('disabled', true);

        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'));
        data.append('kode', $('#kodeInput').val());
        data.append('nama', $('#namaInput').val());
        data.append('deskripsi', $('#deskripsiTextarea').val());

        axios.post(`/api/klasifikasi/baru`, data)
            .then(res => {
                if(res.data.success == true) {
                    setTimeout(() => {
                        window.location.href = '/admin/kode-klasifikasi/detail/'+res.data.data.id;
                        $('#ubahInformasiModal').modal('hide');
                    }, 1000);
                }
                $('meta[name=token_hash]').attr('content', res.data.csrf)
            })
            .catch(e => {
                setTimeout(() => {
                    if(e.response.data.validation) {
                        if(e.response.data.validation.kode) {
                            $('#kodeError').html(`<span>${e.response.data.validation.kode}</span>`);
                        }
                        if(e.response.data.validation.nama) {
                            $('#namaError').html(`<span>${e.response.data.validation.nama}</span>`);
                        }
                        if(e.response.data.validation.keterangan) {
                            $('#keteranganError').html(`<span>${e.response.data.validation.keterangan}</span>`);
                        }
                    }
                }, 1000);
                $('meta[name=token_hash]').attr('content', e.response.data.csrf)
            })
            .finally(() => {
                setTimeout(() => {
                    $(this).html('Simpan').attr('disabled', false)
                }, 1000);
            })
    })
})