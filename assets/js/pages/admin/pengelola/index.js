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
                                <a href="/admin/pengelola/detail/${item.id}">${item.nama}</a>
                            </td>
                            <td>${item.email}</td>
                            <td>${item.arsip_count}</td>
                            <td>${item.last_login}</td>
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

    $('#prev-table').attr('disabled', true);

    $('#next-table').on('click', function() {
        current_page++;
        loadAdmin(current_page);
    })
})