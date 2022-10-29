$(function() {
    const ADUAN_ID = window.location.pathname.split('/')[4]
    
    const statusAduanRender = (status) => {
        if(status == 1) {
            $('#diterima-btn').attr('disabled', true);
            return `<span class="badge fw-0 bg-danger text-white">Diterima</span>`
        } else if(status == 2) {
            $('#dibaca-btn').attr('disabled', true);
            return `<span class="badge fw-0 bg-warning text-white">Dibaca</span>`
        } else if(status == 3) {
            $('#ditindaklanjuti-btn').attr('disabled', true);
            return `<span class="badge fw-0 bg-success text-white">Ditindaklanjuti</span>`
        } else {
            $('#selesai-btn').attr('disabled', true);
            return `<span class="badge fw-0 bg-info text-white">Selesai</span>`
        }
    }

    const load = () => {
        $('#diterima-btn').attr('disabled', false);
        $('#dibaca-btn').attr('disabled', false);
        $('#ditindaklanjuti-btn').attr('disabled', false);
        $('#selesai-btn').attr('disabled', false);
        axios.get(`/api/dashboard/aduan/${ADUAN_ID}`)
        .then(res => {
            console.log(res)
            $('#nomor-aduan-breadcrumb').text(res.data.data.kode ? '#'+res.data.data.kode : '-');
            $('#nomor-aduan-title').text(res.data.data.kode ? '#'+res.data.data.kode : '-');
            $('#nama-aduan-text').text(res.data.data.nama ? res.data.data.nama : '-')
            $('#email-aduan-text').text(res.data.data.email ? res.data.data.email : '-')
            $('#status-aduan-text').html(res.data.data.status ? statusAduanRender(res.data.data.status) : '-')
            $('#last-updated-aduan-text').html(res.data.data.updated_at ? res.data.data.updated_at : '-')
            $('#aduan-text').html(res.data.data.aduan ? res.data.data.aduan : '-')
        })
        .catch(e => {
            alert(e.response.data.message)
        })
        .finally(() => {
        })
    }

    load();

    $(document).on('click', '.update-btn', function() {
        $(this).html('<image src="/assets/images/loader/loading.svg"/>')
        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        data.append('status', $(this).data('status'))
        
        axios.post(`/api/dashboard/aduan/${ADUAN_ID}/update`, data)
            .then(res => {
                load();
                $('meta[name=token_hash]').attr('content', res.data.csrf)
            })
            .catch(e => {
                alert(e.response.data.message)
                $('meta[name=token_hash]').attr('content', e.response.data.csrf)
            })
            .finally(() => {
                $(this).html($(this).data('text'))
            })
    })
})