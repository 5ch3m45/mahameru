$(function() {
    let current_page = 1;
    let total_page = 1;
    let is_fetching = false;
    let query = $('#search-input').val();
    let sort = $('#sort-input').val();

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

    const getData = (page, q, s) => {
        if(is_fetching) {
            return;
        }

        // set fetching state
        $('#prev-table').attr('disabled', true);
        $('#next-table').attr('disabled', true);
        is_fetching = true;

        axios.get(`/api/public/arsip?q=${q}&s=${s}&p=${page}`)
            .then(res => {
                // reset table
                $('#arsip-table>tbody').html('')
                
                // set page
                current_page = res.data.current_page;
                total_page = res.data.total_page;
                $('#page-table').text(current_page+'/'+total_page);

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
                    $('#arsip-table>tbody').append(`
                    <tr data-id="${item.id}" role="button">
                        <td>${item.nomor}</td>
                        <td>${item.klasifikasi.kode}. ${item.klasifikasi.nama.toUpperCase()}</td>
                        <td>${item.informasi}</td>
                        <td>
                            <ul class="avatars">
                                ${item.lampirans.map(lampiran => lampiranParser(lampiran)).join('')}
                            </ul>
                        </td>
                        <td>${item.pencipta}</td>
                        <td>${item.tahun}</td>
                    </tr>
                    `)
                })
            })
            .finally(() => {
                is_fetching = false;
            })
    }

    // delegate tr click
    $(document).on('click', 'tr', function() {
        let id = $(this).data('id');
        if(id) {
            window.open('/arsip/'+id)
        }
    })

    // get data on ready
    getData(current_page, query, sort);

    // get data on search
    $('#search-input').on('keyup', debounce(function() {
        current_page = 1;
        query = $('#search-input').val();
        sort = $('#sort-input').val();
        getData(1, query, sort);
    }))

    // get data on sort
    $('#sort-input').on('change', function() {
        query = $('#search-input').val();
        sort = $('#sort-input').val();
        getData(current_page, query, sort);
    })

    // get data on prev click
    $('#prev-table').on('click', function() {
        getData(current_page-1, query, sort);
    })

    // get data on next click
    $('#next-table').on('click', function() {
        getData(current_page+1, query, sort);
    })

    //reset table
    $('#reset-table').on('click', function() {
        current_page = 1;
        $('#search-input').val('');
        $('#sort-input').val('terbaru');
        getData(1, '', 'terbaru');
    })
})