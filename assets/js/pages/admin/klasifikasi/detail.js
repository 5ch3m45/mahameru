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
        axios.post(`/api/dashboard/klasifikasi/${KLASIFIKASI_ID}/update`, data)
            .then(res => {
                location.reload()
            })
            .catch(e => {
                $('meta[name=token_hash]').attr('content', e.response.data.csrf)
            })
            .finally(() => {
                $(':input').attr('disabled', false)
            })
    })
});

$(function() {
    $('#current-page').on('keyup paste', function() {
        $(this).val($(this).val().replace(/[^0-9]/gi, ''));
    })
    $('#current-page').on('keyup paste', debounce(function() {
        $('#page-input').val($('#current-page').val());
        $('#filter-form').submit();
    }, 300))
})