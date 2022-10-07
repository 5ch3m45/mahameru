$(function() {
    let current_page = 1;
    let total_page = 1;
    let is_fetching = false;

    const getData = (page) => {
        if(is_fetching) {
            return;
        }

        // set fetching state
        $('#prev-table').attr('disabled', true);
        $('#next-table').attr('disabled', true);
        is_fetching = true;

        axios.get(`/api/admin?page=${page}`)
            .then(res => {
                // reset table
                $('#admin-table>tbody').html('');

                // set page
                current_page = res.data.current_page;
                total_page = res.data.total_page;
                $('#page-table').text(current_page+'/'+total_page);

                // batasin min page
                if(current_page == 1) {
                    $('#prev-page').attr('disabled', true);
                } else {
                    $('#prev-page').attr('disabled', false);
                }

                // batasin max page
                if(current_page == 1) {
                    $('#next-page').attr('disabled', true);
                } else {
                    $('#next-page').attr('disabled', false);
                }

                // set content
                res.data.data.forEach(item => {
                    $('#admin-table>tbody').append(`
                        <tr role="button" data-id="${item.id}">
                            <td>${item.name}</td>
                            <td>${item.email}</td>
                            <td>${item.arsip_count}</td>
                            <td>${item.last_login ? item.last_login : '-'}</td>
                        </tr>
                    `)
                })
            })
            .catch(e => {
                alert(e.response.data.message)
            })
            .finally(() => {
                is_fetching = false;
            })
    }

    // load data on ready;
    getData(current_page);

    // get data on prev click
    $('#prev-table').on('click', function() {
        getData(current_page-1);
    });

    // get data on next click
    $('#next-table').on('click', function() {
        getData(current_page+1);
    });

    // delegate tr click to detail
    $(document).on('click', 'tr', function() {
        let id = $(this).data('id');
        if(id) {
            window.location.href = '/admin/pengelola/detail/'+id;
        }
    })

    $('#pengelolaBaruBtn').on('click', function() {
        $('#pengelolaBaruModal').modal('show')
    })

    $('#pengelola-baru-form').on('submit', function(e) {
        e.preventDefault();

        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        data.append('nama', $('#nama-input').val())
        data.append('email', $('#email-input').val())

        $('#pengelolaBaruModal :input').attr('disabled', true)

        axios.post(`/api/admin/baru`, data)
            .then(res => {
                $('meta[name=token_hash]').attr('content', res.data.csrf)
                $('#pengelolaBaruModal').modal('hide')
                $('#nama-input').val('')
                $('#email-input').val('')
                loadAdmin(1)
            })
            .catch(e => {
                $('meta[name=token_hash]').attr('content', e.response.data.csrf)
                if(e.response.data.validation) {
                    Object.entries(e.response.data.validation).forEach(([k, v]) => {
                        $(`#${k}Error`).html(v);
                    })
                }
            })
            .finally(() => {
                $('#pengelolaBaruModal :input').attr('disabled', false)
            })
    })
})