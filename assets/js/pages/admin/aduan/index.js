$(function() {
    let currenct_page = 1;
    let is_last_page = 0;
    let is_fetching = 0;

    const loadAduan = (page) => {
        // $(':input').attr('disabled', true);
        $('#aduan-table>tbody').html('')

        axios.get(`/api/aduan?page=${page}`)
            .then(res => {
                $('#prev-table').attr('disabled', false)
                $('#next-table').attr('disabled', false)
                if(res.data.data.length < 10) {
                    $('#next-table').attr('disabled', true)
                }
                if(page == 1) {
                    $('#prev-table').attr('disabled', true)
                }

                res.data.data.forEach((item) => {
                    $('#aduan-table>tbody').append(`
                        <tr>
                            <td class="">
                                <a href="/admin/aduan/detail/${item.id}">
                                ${item.kode}
                                </a>
                            <td class="">
                                ${item.aduan.substr(0, 100)}${item.aduan.length > 100 ? '...' : '' }
                            </td>
                            <td class="">${item.nama}</td>
                            <td class="">${item.email}</td>
                            <td class="">${statusAduanRender(item.status.status)}</td>
                        </tr>
                    `)
                })
            })
            .catch(e => {
                console.log(e.response)
            })
            .finally(() => {
                // $(':input').attr('disabled', false)
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

    // $('#prev-table').on('click')

    loadAduan(currenct_page)
})