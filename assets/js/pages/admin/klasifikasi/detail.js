$(function() {
    const load = () => {
        axios.get(`/api/dashboard/klasifikasi/${window.location.pathname.split('/')[4]}`)
            .then(res => {
                const { kode, nama, deskripsi, arsip_count, last_updated } = res.data.data;
                $('#breadcrumb-nama').text(nama);
                $('#klasifikasi-title').text(kode+': '+nama);
                $('#kode-text').text(kode);
                $('#nama-text').text(nama);
                $('#deskripsi-text').text(deskripsi);
                $('#arsip-count-text').text(arsip_count);
                $('#last-updated-text').text(last_updated);

                $('#kode-input').val(kode);
                $('#nama-input').val(nama);
                $('#deskripsi-textarea').val(deskripsi);
            })
    }

    load();

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
                $('#klasifikasi-title').text($('#kode-input').val()+': '+$('#nama-input').val());
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
});

$(function() {
    let _page = 1;
    let _is_fetching = 0;
    let _search = '';
    let _status = 'semua';
    let _level = 'semua';
    let _sort = 'terbaru';

    const lampiranParser = (lampiran) => {
        if(['image/jpeg', 'image/png'].includes(lampiran.type)) {
            return `<img src="${lampiran.url}" class="avatars__img avatars__img-sm" />`
        } else if(['video/mp4'].includes(lampiran.type)) {
            return `<img src="/assets/images/mp4.png" class="avatars__img avatars__img-sm" />`
        } else if(['application/pdf'].includes(lampiran.type)) {
                return `<img src="/assets/images/pdf.png" class="avatars__img avatars__img-sm" />`
        } else {
            return `<span class="avatars__others">+${lampiran.url}</span>`
        }
    }
    const statusParser = (status) => {
        switch (status) {
            case '1':
                return '<span class="badge bg-warning">Draft</span>';

            case '2':
                return '<span class="badge bg-success">Terpublikasi</span>';
                
            case '3':
                return '<span class="badge bg-danger text-light">Dihapus</span>';
        
            default:
                break;
        }
    }

    const load = () => {
        if(_is_fetching) {
            return;
        }

        $('#arsip-table>tbody').html('<tr><td colspan="8" class="text-center"><image src="/assets/images/loader/loading.svg"/></td></tr>')
        $('#prev-table').attr('disabled', false)
        $('#next-table').attr('disabled', false)
        _is_fetching = 1;
        
        axios.get(`/api/dashboard/klasifikasi/${window.location.pathname.split('/')[4]}/arsip?page=${_page}&search=${_search}&status=${_status}&level=${_level}&sort=${_sort}`)
            .then(res => {
                $('#arsip-table>tbody').html('');

                if(res.data.data.length < 10) {
                    $('#next-table').attr('disabled', true)
                } else {
                    $('#next-table').attr('disabled', false)
                }
                if(_page == 1) {
                    $('#prev-table').attr('disabled', true)
                } else {
                    $('#prev-table').attr('disabled', false)
                }

                res.data.data.forEach(item => {
                    $('#arsip-table>tbody').append(`
                        <tr role="button" data-id="${item.id}">
                            <td>${item.nomor ? item.nomor : ''}</td>
                            <td>${item.admin_id ? item.admin_detail.name : '-'}</td>
                            <td>
                                <small class="d-inline-block text-truncate" style="max-width: 250px;">${item.informasi ? item.informasi : ''}</small>
                            </td>
                            <td>
                                <ul class="avatars">
                                    ${item.lampirans.map(l => lampiranParser(l)).join('')}
                                </ul>
                            </td>
                            <td>${item.pencipta ? item.pencipta : ''}</td>
                            <td>${item.tanggal_formatted ? item.tanggal_formatted : ''}</td>
                            <td>${statusParser(item.status)}</td>
                            <td>${item.level == '2'
                                ? `<span class="badge bg-success">Publik</span>`
                                : `<span class="badge bg-danger">Rahasia</span>`
                            }</td>
                        </tr>
                    `)
                })
            })
            .finally(() => {
                _is_fetching = 0
            })
    }

    load();

    $('#search-table').on('keyup', debounce(function() {
        _search = $('#search-table').val();
        _page = 1;
        load();
    }, 300));

    $('#status-table').on('change', function() {
        _status = $('#status-table').val();
        load();
    });

    $('#level-table').on('change', function() {
        _level = $('#level-table').val();
        load();
    })

    $('#sort-table').on('change', function() {
        _sort = $('#sort-table').val();
        load();
    })

    $('#prev-table').on('click', function() {
        _page--;
        load();
    })
    $('#next-table').on('click', function() {
        _page++;
        load();
    })

    $(document).on('click', 'tr', function() {
        let id = $(this).data('id');
        if(id) {
            window.location.href = '/dashboard/arsip/detail/'+id;
        }
    })
})