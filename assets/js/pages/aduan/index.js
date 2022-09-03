$(function() {
    const statusAduanRender = (status) => {
        return status.map(item => {
            if(item.status == 1) {
                return `<li>${item.created_at_formatted}: <span class="badge fw-0 bg-danger text-white">Dikirim</span></li>`
            } else if(item.status == 2) {
                return `<li>${item.created_at_formatted}: <span class="badge fw-0 bg-warning text-white">Dibaca</span></li>`
            } else if(item.status == 3) {
                return `<li>${item.created_at_formatted}: <span class="badge fw-0 bg-success text-white">Ditindaklanjuti</span></li>`
            } else {
                return `<li>${item.created_at_formatted}: <span class="badge fw-0 bg-info text-white">Selesai</span></li>`
            }
        }).join('')
    }
    $('#aduan-form').on('submit', function(e) {
        e.preventDefault();

        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        data.append('kode', $('#kode-input').val())
        data.append('phrase', $('#captcha').val())

        $(':input').attr('disabled', true)
        axios.post(`/api/aduan/find`, data)
            .then(res => {
                $('#aduan-container').html(`
                    <h1>${res.data.data.kode}</h1>
                    <p>${res.data.data.nama} | ${res.data.data.email}</p>
                    <p class="mb-3">${res.data.data.aduan}</p>
                    <h5>Status aduan:</h5>
                    <ul>
                        ${statusAduanRender(res.data.data.status)}
                    </ul>
                `)
            })
            .catch(e => {
                console.log(e)
                if(e.response.data.error) {
                    Object.entries(e.response.data.error).forEach(([k, v]) => {
                        $('#'+k+'-error').text(v)
                    })
                }
                $('#captcha-image').attr('src', e.response.data.captcha)
                $('meta[name=token_hash]').attr('content', e.response.data.csrf)
            })
            .finally(() => {
                $(':input').attr('disabled', false)
            })
    })
})