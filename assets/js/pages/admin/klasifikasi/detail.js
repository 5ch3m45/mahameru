$(function() {
    $('#edit-klasifikasi-form').on('submit', function(e) {
        e.preventDefault();

        const KLASIFIKASI_ID = window.location.pathname.split('/')[4]
        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        data.append('kode', $('#kode-input').val())
        data.append('nama', $('#nama-input').val())
        data.append('deskripsi', $('#deskripsi-textarea').val())

        $(':input').attr('disabled', true)
        axios.post(`/api/klasifikasi/${KLASIFIKASI_ID}/update`, data)
            .then(res => {
                $('#kode-text').text($('#kode-input').val())
                $('#nama-text').text($('#nama-input').val())
                $('#deskripsi-text').text($('#deskripsi-textarea').val())
                $('meta[name=token_hash]').attr('content', res.data.csrf)
                $('#editKodeKlasifikasiModal').modal('hide')
            })
            .catch(e => {
                $('meta[name=token_hash]').attr('content', e.response.data.csrf)
            })
            .finally(() => {
                $(':input').attr('disabled', false)
            })
            
    })
})