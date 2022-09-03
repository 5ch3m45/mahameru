$(function() {
    let current_page = 1;
    let is_last_page = 0;

    const loadAdmin = (page) => {
        if(page == 1) {
            $('#admin-table>tbody').html('')
            $('#prev-table').attr('disabled', true)
        } else {
            $('#prev-table').attr('disabled', true)
        }

        if(is_last_page) {
            return;
        }

        axios.get(`/api/admin?page=${page}`)
            .then(res => {
                if(res.data.data.length < 10) {
                    is_last_page = 1;
                }

                if(is_last_page) {
                    $('#next-table').attr('disabled', true)
                } else {
                    $('#next-table').attr('disabled', false)
                }

                res.data.data.forEach(item => {
                    $('#admin-table>tbody').append(`
                        <tr>
                            <td>
                                <a href="/admin/pengelola/detail/${item.id}">${item.name}</a>
                            </td>
                            <td>${item.email}</td>
                            <td>${item.arsip_count}</td>
                            <td>${item.last_login_formatted}</td>
                        </tr>
                    `)
                })
            })
            .catch(e => {
                alert(e.response.data.message)
            })
            .finally(() => {
                //
            })
    }

    loadAdmin(current_page);

    $('#orev-table').on('click', function() {
        current_page--;
        loadAdmin(current_page);
    });
    $('#next-table').on('click', function() {
        current_page++;
        loadAdmin(current_page);
    });

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