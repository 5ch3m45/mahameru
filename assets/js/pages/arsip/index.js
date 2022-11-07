$(function() {
    let is_fetching = false;
    let query = $('#search-input').val();
    let sort = $('#sort-input').val();
    let page = $('#current-page').val();

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

    const getData = (q, s) => {
        if(is_fetching) {
            return;
        }

        // set fetching state
        $('#prev-page').attr('disabled', true);
        $('#next-page').attr('disabled', true);
        is_fetching = true;

        axios.get(`/api/public/arsip?q=${q}&s=${s}&p=${$('#current-page').val()}`)
            .then(res => {
                const { total_page, data } = res.data;
                // reset table
                $('#arsip-table>tbody').html('')
                
                // set page
                $('#total-page').html('dari '+total_page)

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

                if(data.length == 0) {
                    $('#next-page').attr('disabled', true);
                    $('#prev-page').attr('disabled', true);
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
            window.location.href = '/arsip/'+id;
        }
    })

    // get data on ready
    getData(query, sort);

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
        getData(query, sort);
    })

    // get data on prev click
    $('#prev-page').on('click', function() {
        $('#current-page').val($('#current-page').val()*1 - 1);
        getData(query, sort);
    })

    // get data on next click
    $('#next-page').on('click', function() {
        $('#current-page').val($('#current-page').val()*1 + 1);
        getData(query, sort);
    });

    $('#current-page').on('keyup paste', function() {
        $(this).val($(this).val().replace(/[^0-9]/gi, ''))
    })
    $('#current-page').on('keyup paste', debounce(function() {
        getData(query, sort);
    }, 300))

    //reset table
    $('#reset-table').on('click', function() {
        $('#current-page').val(1);
        $('#search-input').val('');
        $('#sort-input').val('terbaru');
        getData('', 'terbaru');
    })
})