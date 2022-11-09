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

    const getData = () => {
        if(is_fetching) {
            return;
        }

        // set fetching state
        $('#prev-page').attr('disabled', true);
        $('#next-page').attr('disabled', true);
        is_fetching = true;

        axios.get(`/api/public/arsip?q=${$('#search-input').val()}&s=${$('#sort-input').val()}&p=${$('#current-page').val()}&date_start=${$('#date-start').val()}&date_end=${$('#date-end').val()}`)
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
    getData();

    // get data on search
    $('#search-input').on('keyup', debounce(function() {
        $('#current-page').val(1);
        getData();
    }))

    // get data on sort
    $('#sort-input').on('change', function() {
        getData();
    })

    // get data on prev click
    $('#prev-page').on('click', function() {
        $('#current-page').val($('#current-page').val()*1 - 1);
        getData();
    })

    // get data on next click
    $('#next-page').on('click', function() {
        $('#current-page').val($('#current-page').val()*1 + 1);
        getData();
    });

    $('#current-page').on('keyup paste', function() {
        $(this).val($(this).val().replace(/[^0-9]/gi, ''))
    })
    $('#current-page').on('keyup paste', debounce(function() {
        getData();
    }, 300))
    $('#date-start').on('change', function() {
        getData()
    })
    $('#date-end').on('change', function() {
        getData()
    })

    //reset table
    $('#reset-table').on('click', function() {
        $('#current-page').val(1);
        $('#search-input').val('');
        $('#sort-input').val('terbaru');
        getData('', 'terbaru');
    })
})