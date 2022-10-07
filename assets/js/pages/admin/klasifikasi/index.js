$(function() {
    var current_page = 1;
    var total_page = 1;
    var is_fetching = false;
    var search = $('#search-table').val();
    var sort = $('#sort-table').val();

    const getData = (page, query, sort) => {
        if(is_fetching) {
            return;
        }

        // set fetching state
        $('#prev-table').attr('disabled', true);
        $('#next-table').attr('disabled', true);
        is_fetching = true;

        axios.get(`/api/klasifikasi?page=${page}&search=${query}&sort=${sort}`)
        .then(res => {
            // reset table
            $('#klasifikasi-table>tbody').html('');

            // set page
            $('#page-table').text(res.data.current_page+'/'+res.data.total_page);
            current_page = res.data.current_page;
            total_page = res.data.total_page;

            // batasin min page
            if(current_page == 1) {
                $('#prev-table').attr('disabled', true);
            } else {
                $('#prev-table').attr('disabled', false);
            }

            // batasin max page
            if(current_page == total_page) {
                $('#next-table').attr('disabled', true);
            } else {
                $('#next-table').attr('disabled', false);
            }

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
                    <td>${item.arsip_count}</td>
                </tr>
                `)
            })
        })
        .finally(() => {
            is_fetching = false;
        })
    }

    // get data on ready
    getData(current_page, search, sort);

    // get data on prevpage
    $('#prev-table').on('click', function() {
        getData(current_page-1, search, sort);
    })

    // get data on nextpage
    $('#next-table').on('click', function() {
        getData(current_page+1, search, sort);
    })

    // get data on pencarian
    $('#search-table').on('keyup', debounce(function() {
        search = $('#search-table').val();
        getData(1, search, sort);
    }))

    // get data on sort
    $('#sort-table').on('change', function() {
        sort = $('#sort-table').val();
        getData(current_page, search, sort);
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
        window.location.href = '/admin/kode-klasifikasi/detail/'+$(this).data('id')
    })

    $('#submitKodeBtn').on('click', function() {
        $(this).html('<div class="spinner-border spinner-border-sm"></div> Menyimpan').attr('disabled', true);

        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'));
        data.append('kode', $('#kodeInput').val());
        data.append('nama', $('#namaInput').val());
        data.append('deskripsi', $('#deskripsiTextarea').val());

        axios.post(`/api/klasifikasi/baru`, data)
            .then(res => {
                if(res.data.success == true) {
                    setTimeout(() => {
                        window.location.href = '/admin/kode-klasifikasi/detail/'+res.data.data.id;
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