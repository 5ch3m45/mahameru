$(function() {
    let _page = $('#current-page').val();
    let _search = '';
    let _status = '';
    let _sort = 'terbaru';
    let _is_fetching = false;

    const load = () => {
        $('#aduan-table>tbody').html(`<tr><td colspan="5" class="text-center"><image src="/assets/images/loader/loading.svg"/></td></tr>`)

        if(_is_fetching) {
            return;
        }

        _is_fetching = true;
        $('#prev-table').attr('disabled', true);
        $('#next-table').attr('disabled', true);
        
        axios.get(`/api/dashboard/aduan?page=${$('#current-page').val()}&search=${_search}&status=${_status}&sort=${_sort}`)
            .then(res => {
                const { total_page } = res.data;
                // reset table
                $('#aduan-table>tbody').html('');
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

                if($('#current-page').val() < 1){
                    $('#current-page').val(1);
                    _is_fetching = false;
                    load();
                    return;
                }
                if($('#current-page').val() > total_page){
                    $('#current-page').val(total_page);
                    _is_fetching = false;
                    load();
                    return;
                }

                $('#total-page').html('dari '+total_page);

                // set content
                res.data.data.forEach((item) => {
                    $('#aduan-table>tbody').append(`
                        <tr role="button" data-id="${item.id}">
                            <td>
                                <div>${item.created_at}</div>
                                <strong>${item.kode}</strong>
                            </td>
                            <td>
                                ${item.aduan.substr(0, 100)}${item.aduan.length > 100 ? '...' : '' }
                            </td>
                            <td>${item.nama}</td>
                            <td>${item.email}</td>
                            <td>${item.status ? statusAduanRender(item.status) : ''}</td>
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

    const statusAduanRender = (status) => {
        if(status == "1") {
            return `<span class="badge fw-0 bg-danger text-white">Dikirim</span>`
        } else if(status == "2") {
            return `<span class="badge fw-0 bg-warning text-white">Dibaca</span>`
        } else if(status == "3") {
            return `<span class="badge fw-0 bg-success text-white">Ditindaklanjuti</span>`
        } else {
            return `<span class="badge fw-0 bg-info text-white">Selesai</span>`
        }
    }

    // get data on ready
    load(_page);

    // get data on prevpage
    $('#prev-page').on('click', function() {
        $('#current-page').val($('#current-page').val()*1 - 1)
        load();
    });

    // get data on nextpage
    $('#next-page').on('click', function() {
        $('#current-page').val($('#current-page').val()*1 + 1)
        load();
    });

    $('#current-page').on('keyup paste', function() {
        $(this).val($(this).val().replace(/[^0-9]/gi, ''))
    })

    $('#current-page').on('keyup paste', debounce(function(){
        load();
    },300))

    $('#search-table').on('keyup', debounce(function() {
        _search = $('#search-table').val();
        _page = 1;
        load();
    }, 300));

    $('#status-table').on('change', function() {
        _status = $('#status-table').val();
        load();
    });

    $('#sort-table').on('change', function() {
        _sort = $('#sort-table').val();
        load();
    });

    // delegate tr click
    $(document).on('click', 'tr', function() {

        let id = $(this).data('id');
        if(id) {
            window.location.href = '/dashboard/aduan/detail/'+id;
        }
    })
})