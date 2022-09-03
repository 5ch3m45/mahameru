$(function() {
    let current_page = 1;
    let is_fetching = 0;

    const lampiranParser = (lampiran) => {
        if(['image/jpeg', 'image/png'].includes(lampiran.type)) {
            return `<img src="${lampiran.url}" class="avatars__img" />`
        } else if(['video/mp4'].includes(lampiran.type)) {
            return `<img src="/assets/images/mp4.png" class="avatars__img" />`
        } else {
            return `<span class="avatars__others">+${lampiran.url}</span>`
        }
    }

    const getInitialName = (name) => {
        if(name) {
            return name.split(" ").map((n)=>n[0]).join(".");
        } 
        return '-';
    }

    const load = (page) => {
        console.log(page)
        $('#arsip-table>tbody').html('')
        if(is_fetching) {
            return;
        }
        
        is_fetching = 1;
        axios.get(`/api/arsip?page=${page}`)
            .then(res => {
                $('#prev-table').attr('disabled', false)
                $('#next-table').attr('disabled', false)
                if(res.data.data.length < 10) {
                    $('#next-table').attr('disabled', true)
                }
                if(page == 1) {
                    $('#prev-table').attr('disabled', true)
                }
                let counter = 10 * (page - 1);
                res.data.data.forEach(item => {
                    counter++;
                    $('#arsip-table>tbody').append(`
                        <tr role="button" data-id="${item.id}">
                            <td>${counter}</td>
                            <td>${item.nomor ? item.nomor : ''}</td>
                            <td>${item.admin_id ? getInitialName(item.admin.name) : '-'}</td>
                            <td>
                                ${item.klasifikasi_id
                                    ? `
                                        <span class="badge bg-primary">
                                            ${item.klasifikasi.kode} | ${item.klasifikasi.nama}
                                        </span>
                                    `
                                    : ''
                                }
                            </td>
                            <td>
                                <small class="d-inline-block text-truncate" style="max-width: 250px;">${item.informasi ? item.informasi : ''}</small>
                            </td>
                            <td>
                                <ul class="avatars">
                                    ${item.lampirans.map(l => lampiranParser(l)).join('')}
                                </ul>
                            </td>
                            <td>${item.pencipta ? item.pencipta : ''}</td>
                            <td>${item.tahun ? item.tahun : ''}</td>
                            <td>
                                ${item.is_published == 1
                                    ? `
                                    <span class="badge bg-success">Terpublikasi</span>
                                    `
                                    : `
                                    <span class="badge bg-warning">Draft</span>
                                    `
                                }
                            </td>
                            <td>${item.level == 'public'
                                ? `<span class="badge bg-success">Publik</span>`
                                : `<span class="badge bg-danger">Rahasia</span>`
                            }</td>
                        </tr>
                    `)
                })
            })
            .finally(() => {
                is_fetching = 0
            })
    }

    load(current_page)

    $('#prev-table').on('click', function() {
        current_page--;
        load(current_page);
    })
    $('#next-table').on('click', function() {
        current_page++;
        load(current_page);
    })

    $(document).on('click', 'tr', function() {
        window.location.href = '/admin/arsip/detail/'+$(this).data('id')
    })
})