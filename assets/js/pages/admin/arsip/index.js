$(function() {
    let _page = $('#current-page').val();
    let _is_fetching = 0;
    let _search = '';
    let _status = '';
    let _level = '';
    let _sort = 'terbaru';

    const lampiranParser = (lampiran) => {
        if(['image/jpeg', 'image/png'].includes(lampiran.type)) {
            return `<img src="${lampiran.url}" class="avatars__img" />`
        } else if(['video/mp4'].includes(lampiran.type)) {
            return `<img src="/assets/images/mp4.png" class="avatars__img" />`
        } else if(['application/pdf'].includes(lampiran.type)) {
                return `<img src="/assets/images/pdf.png" class="avatars__img" />`
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
        $('#arsip-table>tbody').html('<tr><td colspan="9" class="text-center"><image src="/assets/images/loader/loading.svg"/></td></tr>')
        if(_is_fetching) {
            return;
        }
        
        _is_fetching = 1;
        axios.get(`/api/dashboard/arsip?page=${$('#current-page').val()}&search=${_search}&status=${_status}&level=${_level}&sort=${_sort}`)
            .then(res => {
                const { total_page } = res.data;

                $('#arsip-table>tbody').html('')
                $('#prev-page').attr('disabled', false)
                $('#next-page').attr('disabled', false)
                if($('#current-page').val() == total_page) {
                    $('#next-page').attr('disabled', true)
                }
                if($('#current-page').val() == 1) {
                    $('#prev-page').attr('disabled', true)
                }

                if($('#current-page').val() > total_page) {
                    $('#current-page').val(total_page);
                    _is_fetching = 0;
                    load();
                    return;
                }
                if($('#current-page').val() < 1) {
                    $('#current-page').val(1);
                    _is_fetching = 0;
                    load();
                    return;
                }

                $('#total-page').html('dari '+total_page)

                res.data.data.forEach(item => {
                    
                    $('#arsip-table>tbody').append(`
                        <tr role="button" data-id="${item.id}">
                            <td>${item.nomor ? item.nomor : ''}</td>
                            <td>${item.admin_id ? item.admin.name : '-'}</td>
                            <td class="nowrap-td">
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
                            <td>${item.tanggal_formatted ? item.tanggal_formatted : ''}</td>
                            <td><i class="bi bi-eye"></i> ${Intl.NumberFormat('en', { notation: 'compact' }).format(item.viewers)}</td>
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
            });
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
    })

    $('#level-table').on('change', function() {
        _level = $('#level-table').val();
        load();
    })

    $('#sort-table').on('change', function() {
        _sort = $('#sort-table').val();
        load();
    })

    $('#prev-page').on('click', function() {
        $('#current-page').val($('#current-page').val() * 1 - 1);
        load();
    });

    $('#next-page').on('click', function() {
        $('#current-page').val($('#current-page').val() * 1 + 1);
        load();
    });

    $('#current-page').on('keyup paste', function() {
        $(this).val($(this).val().replace(/[^0-9]/gi, ''));
    })

    $('#current-page').on('keyup paste', debounce(function(){
        load();
    }, 300));

    $(document).on('click', 'tr', function() {
        let id = $(this).data('id');
        if(id) {
            window.location.href = '/dashboard/arsip/detail/'+id;
        }
    });
});