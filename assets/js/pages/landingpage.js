$(function() {
    AOS.init({
        duration: 500,
        once: true
    });

    $('.today-archive-card').on('click', function() {
        window.location.href = `/arsip/${$(this).data('id')}`
    })

    $('#aduan-form').on('submit', function(e) {
        e.preventDefault();

        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        data.append('email', $('#email-aduan-input').val())
        data.append('nama', $('#nama-aduan-input').val())
        data.append('aduan', $('#aduan-textarea').val())
        data.append('phrase', $('#captcha').val())

        axios.post(`/api/public/aduan/create`, data)
            .then(res => {
                $('#aduan-modal-body').html(`
                    <p class="mb-0">Aduan Anda berhasil disimpan dengan nomor:</p>
                    <div class="d-flex justify-content-center py-2">
                        <span class="text-info" style="font-size: 1.5rem; font-weight: 500">
                            ${res.data.data.kode}
                        </span>
                    </div>
                    <p style="font-size:.75rem; color: red">*) Harap simpan nomor aduan Anda untuk melakukan pemeriksanaan proses Aduan di tombol "Periksa Aduan" di atas atau <a href="/aduan">disini</a>.
                `)
                $('#aduanModal').modal('show')

                ('#email-aduan-input').val('')
                $('#nama-aduan-input').val('')
                $('#aduan-textarea').val('')
                $('#captcha').val('')

                $('#captcha-image').attr('src', res.data.captcha)
                $('meta[name=token_hash]').attr('content', res.data.csrf)
            })
            .catch(e => {
                if(e.response.data.error) {
                    Object.entries(e.response.data.error).forEach(([k, v]) => {
                        $('#'+k+'-error').text(v)
                    })
                }
                $('#captcha-image').attr('src', e.response.data.captcha)
                $('meta[name=token_hash]').attr('content', e.response.data.csrf)
            })
    })

    $('#aduan-textarea').on('keyup', function() {
        $('#aduan-counter').text($(this).val().length+' karakter')
    })

    $('.search-go').on('click', function() {
        let q = $('.search-arsip').val();
        if(q) {
            window.location.href = '/arsip?q='+q;
        }
    })
})