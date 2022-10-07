$(function() {
    let current_page = 1;
    let total_page = 1;
    let is_fetching = false;

    const getData = (page) => {
        if(is_fetching) {
            return;
        }
        $('#prev-table').attr('disabled', false)
        $('#next-table').attr('disabled', false)
        is_fetching = true;
        
        axios.get(`/api/aduan?page=${page}`)
            .then(res => {
                console.log(res);
                // reset table
                $('#aduan-table>tbody').html('')

                // set page
                current_page = res.data.current_page;
                total_page = res.data.total_page;
                $('#page-table').text(current_page+'/'+total_page)

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
                res.data.data.forEach((item) => {
                    $('#aduan-table>tbody').append(`
                        <tr role="button" data-id="${item.id}">
                            <td>${item.kode}</td>
                            <td>
                                ${item.aduan.substr(0, 100)}${item.aduan.length > 100 ? '...' : '' }
                            </td>
                            <td>${item.nama}</td>
                            <td>${item.email}</td>
                            <td>${item.status ? statusAduanRender(item.status.status) : ''}</td>
                        </tr>
                    `)
                })
            })
            .catch(e => {
                console.log(e)
            })
            .finally(() => {
                is_fetching = false;
            })
    }

    const statusAduanRender = (status) => {
        if(status == 1) {
            return `<span class="badge fw-0 bg-danger text-white">Dikirim</span>`
        } else if(status == 2) {
            return `<span class="badge fw-0 bg-warning text-white">Dibaca</span>`
        } else if(status == 3) {
            return `<span class="badge fw-0 bg-success text-white">Ditindaklanjuti</span>`
        } else {
            return `<span class="badge fw-0 bg-info text-white">Selesai</span>`
        }
    }

    // get data on ready
    getData(current_page);

    // get data on prevpage
    $('#prev-table').on('click', function() {
        getData(current_page-1);
    });

    // get data on nextpage
    $('#next-table').on('click', function() {
        getData(current_page-1);
    })

    // delegate tr click
    $(document).on('click', 'tr', function() {
        let id = $(this).data('id');
        if(id) {
            window.location.href = '/admin/aduan/detail/'+id;
        }
    })
})