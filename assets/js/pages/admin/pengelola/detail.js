$(function() {
    const adminID = window.location.pathname.split('/')[4];
    
    const load = () => {
        axios.get(`/api/dashboard/admin/${adminID}`)
            .then(res => {
                $('#admin-nama-breadcrumb').text(res.data.data.name ? res.data.data.name : '')
                $('#admin-status').html(res.data.data.active == "1" ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Nonaktif</span>')
                $('#admin-nama-title').text(res.data.data.name ? res.data.data.name : '')
                $('#admin-email').text(res.data.data.email ? res.data.data.email : '')
                $('#admin-arsip-count').text(res.data.data.arsip_count ? res.data.data.arsip_count+' arsip' : '0 arsip')
                $('#admin-last-login').text(res.data.data.last_login ? res.data.data.last_login : '')

                if(res.data.data.active == "1") {
                    $('#nonaktif-menu-btn').show();
                } else {
                    $('#aktif-menu-btn').show();
                }

                $('#admin-otoritas').html('');
                res.data.data.roles.forEach(role => {
                    // parse background {bg}
                    switch (role.group_id) {
                        case '1':
                            $('#otoritas-pengelola').attr('checked', true);
                            bg = 'danger';
                            break;
                        case '2':
                            $('#otoritas-arsip-publik').attr('checked', false);
                            $('#otoritas-arsip-rahasia').attr('checked', true);
                            bg = 'warning text-dark';
                            break;
                        case '3':
                            $('#otoritas-arsip-publik').attr('checked', true);
                            $('#otoritas-arsip-rahasia').attr('checked', false);
                            bg = 'success';
                            break;
                        case '4':
                            $('#otoritas-aduan').attr('checked', true);
                            bg = 'info';
                            break;
                        case '5':
                            $('#otoritas-klasifikasi').attr('checked', true);
                            bg = 'dark text-light';
                            break;
                    
                        default:
                            bg = 'dark text-light'
                            break;
                    }
                    $('#admin-otoritas').append(`<span class="badge bg-${bg} m-1">${role.description}</span>`)
                })
            })
            .finally(() => {
            })
    }

    load();

    $('#ubah-otoritas-menu-btn').on('click', function() {
        $('#ubahOtoritasModal').modal('show')
    })

    $('#nonaktif-menu-btn').on('click', function() {
        $('#nonaktifModal').modal('show')
    })

    $('#aktif-menu-btn').on('click', function() {
        $('#aktifModal').modal('show')
    })

    $('#ubah-otoritas-form').on('submit', function(e) {
        $("#ubah-otoritas-form button[type=submit]").html('<image src="/assets/images/loader/loading-light.svg"/>')
        e.preventDefault();
        let roles = {
            pengelola: $('#otoritas-pengelola').is(':checked'),
            arsip: $('#otoritas-arsip-publik').is(':checked') ? 'publik' : 'semua',
            klasifikasi: $('#otoritas-klasifikasi').is(':checked'),
            aduan: $('#otoritas-aduan').is(':checked'),
        };

        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        data.append('roles', JSON.stringify(roles));
        axios.post($(this).attr('action'), data)
            .then(res => {
                // set csrf
                $('meta[name=token_hash]').attr('content', res.data.csrf)
                $('#ubahOtoritasModal').modal('hide');
                load();
            })
            .catch(err => {
                $('meta[name=token_hash]').attr('content', err.response.data.csrf)
            })
            .finally(() => {
                $('#ubah-otoritas-form button[type=submit]').html('Simpan')
            })
    });

    $('#nonaktif-form').on('submit', function(e) {
        $("#nonaktif-form button[type=submit]").html('<image src="/assets/images/loader/loading-light.svg"/>')
        e.preventDefault();
        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        axios.post($(this).attr('action'), data)
            .then(res => {
                alert('Pengelola berhasil dinonaktifkan.');
                location.reload();
            })
            .catch(e => {
                alert(e.response.data.message);
                $('#nonaktifModal').modal('hide');
            })
            .finally(() => {
                $("#nonaktif-form button[type=submit]").html('Yakin')
            })
    });

    $('#aktif-form').on('submit', function(e) {
        $("#aktif-form button[type=submit]").html('<image src="/assets/images/loader/loading-light.svg"/>')
        e.preventDefault();
        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        axios.post($(this).attr('action'), data)
            .then(res => {
                alert('Pengelola berhasil aktifkan.');
                location.reload();
            })
            .catch(e => {
                alert(e.response.data.message);
                $('#aktifModal').modal('hide');
            })
            .finally(() => {
                $("#aktif-form button[type=submit]").html('Yakin')
            })
    })

})
// load arsio by pengelola
$(function() {
    let _page = $('#current-page').val();
    let _query = '';
    let _status = '';
    let _level = '';
    let _sort = 'terbaru';
    let _is_fetching = 0;

    const lampiranParser = (lampiran) => {
        if(['image/jpeg', 'image/png'].includes(lampiran.type)) {
            return `<img src="${lampiran.url}" class="avatars__img" />`
        } else if(['video/mp4'].includes(lampiran.type)) {
            return `<img src="/assets/images/mp4.png" class="avatars__img" />`
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
        $('#arsip-table>tbody').html('<tr><td colspan="8" class="text-center"><image src="/assets/images/loader/loading.svg"/></td></tr>')
        if(_is_fetching) {
            return;
        }
        
        _is_fetching = 1;
        axios.get(`/api/dashboard/arsip?user=${window.location.pathname.split('/')[4]}&page=${_page}&query=${_query}&status=${_status}&sort=${_sort}&level=${_level}`)
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
                if($('#current-page').val() < 1) {
                    $('#current-page').val(1);
                    _is_fetching = false;
                    load();
                    return;
                }
                if($('#current-page').val() > total_page) {
                    $('#current-page').val(total_page);
                    _is_fetching = false;
                    load();
                    return;
                }
                $('#total-page').html('dari '+ total_page);
                let counter = 10 * (_page - 1);
                res.data.data.forEach(item => {
                    counter++;
                    $('#arsip-table>tbody').append(`
                        <tr role="button" data-id="${item.id}">
                            <td>${item.nomor ? item.nomor : ''}</td>
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
                _is_fetching = 0;
            })
    }

    load();

    $('#search-table').on('keyup', debounce(function() {
        _query = $('#search-table').val();
        _page = 1;
        load();
    }));

    $('#status-table').on('change', function() {
        _status = $('#status-table').val();
        load();
    });

    $('#sort-table').on('change', function() {
        _sort = $('#sort-table').val();
        load();
    });

    $('#level-table').on('change', function() {
        _level = $('#level-table').val();
        load();
    });

    $('#prev-page').on('click', function() {
        $('#current-page').val($('#current-page').val()*1-1)
        load();
    })
    $('#next-page').on('click', function() {
        $('#current-page').val($('#current-page').val()*1+1)
        load();
    });

    $('#current-page').on('keyup paste', function() {
        $(this).val($(this).val().replace(/[^0-9]/gi, ''))
    })
    $('#current-page').on('keyup paste', debounce(function() {
        load();
    }, 300))

    $(document).on('click', 'tr', function() {
        let id = $(this).data('id');
        if(id) {
            window.location.href = '/dashboard/arsip/detail/'+id;
        }
    })
})