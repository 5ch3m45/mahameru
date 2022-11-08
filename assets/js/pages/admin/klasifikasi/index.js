$(function() {
    var _page = $('#current-page').val();
    var _is_fetching = false;
    var _search = $('#search-table').val();
    var _sort = $('#sort-table').val();

    const load = () => {
        $('#klasifikasi-table>tbody').html('<tr><td colspan="2" class="text-center"><image src="/assets/images/loader/loading.svg"/></td></tr>');
        if(_is_fetching) {
            return;
        }

        // set fetching state
        $('#prev-page').attr('disabled', true);
        $('#next-page').attr('disabled', true);
        _is_fetching = true;

        axios.get(`/api/dashboard/klasifikasi?page=${$('#current-page').val()}&search=${_search}&sort=${_sort}`)
        .then(res => {
            const { total_page } = res.data;
            // reset table
            $('#klasifikasi-table>tbody').html('');

            // batasin min page
            if($('#current-page').val() == 1) {
                $('#prev-page').attr('disabled', true);
            } else {
                $('#prev-page').attr('disabled', false);
            }

            // batasin max page
            if($('#current-page').val() == total_page) {
                $('#next-page').attr('disabled', true);
            } else {
                $('#next-page').attr('disabled', false);
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

            $('#total-page').html('dari '+total_page)

            // set content
            res.data.data.forEach(item => {
                $('#klasifikasi-table>tbody').append(`
                    <tr role="button" data-id="${item.id}">
                        <td>
                            <div>
                                <strong>${item.kode}: ${item.nama}</strong>
                            </div>
                            <div>
                                <small>${item.deskripsi}</small>
                            </div>
                        </td>
                        <td>${item.arsip_count} arsip</td>
                    </tr>
                `)
            })
        })
        .catch(e => {
            console.log(e)
        })
        .finally(() => {
            _is_fetching = false;
        })
    }

    // get data on ready
    load();

    // get data on prevpage
    $('#prev-page').on('click', function() {
        $('#current-page').val($('#current-page').val() * 1 - 1);
        load();
    })

    // get data on nextpage
    $('#next-page').on('click', function() {
        $('#current-page').val($('#current-page').val() * 1 + 1);
        load();
    });

    $('#current-page').on('keyup paste', function() {
        $(this).val($(this).val().replace(/[^0-9]/gi, ''));
    })

    $('#current-page').on('keyup paste', debounce(function() {
        load();
    }, 300))

    // get data on pencarian
    $('#search-table').on('keyup', debounce(function() {
        _search = $('#search-table').val();
        _page =1;
        load();
    }))

    // get data on sort
    $('#sort-table').on('change', function() {
        _sort = $('#sort-table').val();
        load();
    })

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

    // delegate tr click
    $(document).on('click', 'tr', function() {
        window.location.href = '/dashboard/kode-klasifikasi/detail/'+$(this).data('id')
    })

    $('#submitKodeBtn').on('click', function() {
        $(this).html('<div class="spinner-border spinner-border-sm"></div> Menyimpan').attr('disabled', true);

        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'));
        data.append('kode', $('#kodeInput').val());
        data.append('nama', $('#namaInput').val());
        data.append('deskripsi', $('#deskripsiTextarea').val());

        axios.post(`/api/dashboard/klasifikasi/baru`, data)
            .then(res => {
                if(res.data.success == true) {
                    setTimeout(() => {
                        window.location.href = '/dashboard/kode-klasifikasi/detail/'+res.data.data.id;
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