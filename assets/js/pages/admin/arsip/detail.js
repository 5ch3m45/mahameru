Dropzone.autoDiscover = false;
$(async function() {
    const ARSIP_ID = window.location.pathname.split('/')[4];
    const loadKlasifikasiOption = () => {
        axios.get(`/api/klasifikasi`)
            .then(res => {
                $('#klasifikasiSelect').html('<option>Pilih kode klasifikasi</option>');
                res.data.data.forEach(item => {
                    $('#klasifikasiSelect').append(`
                    <option value="${item.id}">${item.kode} | ${item.nama}</option>
                    `)
                })
            })
            .finally(() => {
                $('#klasifikasiSelect').select2({
                    theme: 'bootstrap-5'
                })
            })
    }
    const lampiranParser = (lampiran) => {
        if(['image/jpeg', 'image/png'].includes(lampiran.type)) {
            return `<img 
                data-id="${lampiran.id}" 
                data-url="${lampiran.url}" 
                class="lampiran lampiran-${lampiran.id} my-masonry-grid-item p-1" 
                style="max-width: 100%;" 
                src="${lampiran.url}">`
        } else if(['video/mp4'].includes(lampiran.type)) {
            return `<img 
                data-id="${lampiran.id}" 
                data-url="${lampiran.url}" 
                data-type="${lampiran.type}" 
                class="lampiran lampiran-${lampiran.id} my-masonry-grid-item p-1" 
                style="max-width: 100%" 
                src="/assets/images/mp4.png">`
        }
    }
    const loadArsip = () => {
        axios.get(`/api/arsip/${ARSIP_ID}`)
            .then(res => {
                let item = res.data.data;
                $('#nomor-arsip-breadcrumb').text(item.nomor ? '#'+item.nomor : '');
                $('#nomor-arsip-title').text(item.nomor ? '#'+item.nomor : '');

                if(item.is_published == 1) {
                    $('#draftBtn').show();
                } else {
                    $('#is-draft-flag').show();
                    $('#publikasiBtn').show();
                }

                $('#informasi-text').html(item.informasi ? item.informasi : '<em class="text-secondary">Belum ada informasi</em>');
                $('#nomor-arsip-text').html(item.nomor ? item.nomor : '-');
                $('#klasifikasi-arsip-text').html(item.klasifikasi.id ? item.klasifikasi.kode+' | '+item.klasifikasi.nama : '-');
                $('#pencipta-arsip-text').html(item.pencipta ? item.pencipta : '-')
                $('#tahun-arsip-text').html(item.tahun ? item.tahun : '-')
                $('#last-updated-text').html(item.last_updated);
                $('#level-text').html(item.level == 'public' ? '<span class="badge bg-success">Publik</span>' : '<span class="badge bg-danger">Rahasia</span>')

                // set form value
                $('#nomorInput').val(item.nomor);
                $('#tahunInput').val(item.tahun);
                if(item.klasifikasi_id) {
                    $('#klasifikasiSelect').val(item.klasifikasi_id).trigger('change')
                }
                $('#level-select').val(item.level)
                $('#penciptaInput').val(item.pencipta);
                $('#informasiTextarea').val(item.informasi);

                // lampiran
                if(item.lampirans.length) {
                    $('.my-masonry-grid').html('')
                    item.lampirans.forEach(lampiran => {
                        $('.my-masonry-grid').append(lampiranParser(lampiran))
                    })
                    $('.my-masonry-grid').masonryGrid({
                        'columns': 3
                    });
                } else {
                    $('.my-masonry-grid').html('')
                    $('.my-masonry-grid').html('<em>Belum ada lampiran</em>')
                }

            })
            .finally(() => {
                
            })
    }
    
    await loadKlasifikasiOption();
    loadArsip();

    $("#my-awesome-dropzone").dropzone({ 
        url: `/api/arsip/${ARSIP_ID}/lampiran`, 
        init: function() {
            this.on('sending', function(filex, xhr, formData) {
                formData.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
            })

            this.on('success', function(res) {
                let response = JSON.parse(res.xhr.response)
                $('meta[name=token_hash]').attr('content', response.csrf)
                setTimeout(() => {
                    if(res.type == 'image/png') {
                        // todo data-id lampiran
                        let random = Math.floor(Math.random() * 2) + 1;
                        $('.masonry-grid-column-'+random).append(`
                            <img data-id="${response.data.id}" data-url="${response.data.url}" class="lampiran my-masonry-grid-item p-1" style="max-width: 100%;" src="${response.data.url}" alt="">
                        `)
                    }
                    if(res.type == 'image/jpeg') {
                        // todo data-id lampiran
                        let random = Math.floor(Math.random() * 2) + 1;
                        $('.masonry-grid-column-'+random).append(`
                            <img data-id="${response.data.id}" data-url="${response.data.url}" class="lampiran my-masonry-grid-item p-1" style="max-width: 100%;" src="${response.data.url}" alt="">
                        `)
                    }
                    if(res.type == 'video/mp4') {
                        // todo data-id lampiran
                        let random = Math.floor(Math.random() * 2) + 1;
                        $('.masonry-grid-column-'+random).append(`
                            <img data-id="${response.data.id}" data-url="/assets/images/mp4.png" class="lampiran my-masonry-grid-item p-1" style="max-width: 100%;" src="/assets/images/mp4.png" alt="">
                        `)
                    }
                }, 1000);
                
            })

            this.on('error', function(file, response) {
                alert(JSON.stringify(response))
            })
        }
    });

    $(document).on('click', '.lampiran', function() {
        if($(this).data('type') == 'video/mp4') {
            $('#lampiranFile').html(`
                <video id="lampiranVideo" width="640" height="360" controls>
                    <source src="${$(this).data('url')}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            `)
        } else {
            $('#lampiranFile').html(`<img src="${$(this).data('url')}" style="max-width: 100%; max-height: 80vh">`)
        }
        $('#hapusLampiranBtn').data('id', $(this).data('id'))
        $('#lampiranDetailModal').modal('show')
    })

    $('#hapusLampiranBtn').on('click', function() {
        $('#hapusLampiranSubmit').data('id', $(this).data('id'))
        $('#hapusLampiranConfirmModal').modal('show')
    })
    $('#hapusLampiranSubmit').on('click', function() {
        const LAMPIRAN_ID = $(this).data('id');
        $(':input').attr('disabled', true)
        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        axios.post(`/api/arsip/${ARSIP_ID}/lampiran/${LAMPIRAN_ID}/hapus`, data)
            .then(res => {
                setTimeout(() => {
                    $('#hapusLampiranConfirmModal').modal('hide');
                    $('#lampiranDetailModal').modal('hide');
                    $('.lampiran-'+LAMPIRAN_ID).hide()
                }, 1000);
                $('meta[name=token_hash]').attr('content', res.data.csrf)
            })
            .catch(e => {
                alert(e.response.data.message)
                $('meta[name=token_hash]').attr('content', e.response.csrf)
            })
            .finally(() => {
                $(':input').attr('disabled', false)
            })
    })
    $('#ubahInformasiBtn').on('click', function() {
        $('#ubahInformasiModal').modal('show')
    })
    $('#uploadNewImageBtn').on('click', function() {
        $('#uploadNewImageModal').modal('show')
    })

    $('#nomorInput').on('keyup', function() {
        $('#nomorError').html('')
    })
    $('#tahunInput').on('keyup', function() {
        $('#tahunError').html('')
    })

    $('#informasiTextarea').on('keyup', function() {
        $('#informasiError').html('')
    })

    $('#submitArsipBtn').on('click', function() {
        $(this).html('<div class="spinner-border spinner-border-sm"></div> Menyimpan').attr('disabled', true);
        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        data.append('nomor', $('#nomorInput').val());
        data.append('tahun', $('#tahunInput').val());
        data.append('informasi', $('#informasiTextarea').val());
        data.append('pencipta', $('#penciptaInput').val());
        data.append('klasifikasi', $('#klasifikasiSelect').val());
        data.append('level', $('#level-select').val());
        axios.post(`/api/arsip/${ARSIP_ID}/update`, data)
            .then(res => {
                let item = res.data.data;
                if(item.level == 'private') {
                    location.reload()
                }
                if(item.informasi) {
                    $('#informasi-text').html(item.informasi);
                }
                $('#nomor-arsip-text').html(item.nomor);
                $('#nomor-arsip-title').html('#'+item.nomor);
                $('#nomor-arsip-breadcrumb').html('#'+item.nomor);
                $('#tahun-arsip-text').html(item.tahun ? item.tahun : '-');
                if(item.klasifikasi_id) {
                    $('#klasifikasi-arsip-text').html(item.klasifikasi.kode+' | '+item.klasifikasi.nama)
                }
                $('#pencipta-arsip-text').html(item.pencipta ? item.pencipta : '-');
                $('#level-text').html(item.level == 'public' ? '<span class="badge bg-success">Publik</span>' : '<span class="badge bg-danger">Rahasia</span>')
                $('#ubahInformasiModal').modal('hide');

                $('meta[name=token_hash]').attr('content', res.data.csrf)
                console.log($('meta[name=token_hash]').attr('content'))
            })
            .catch(e => {
                console.log(e)
                if(e.response.data.validation) {
                    if(e.response.data.validation.nomor) {
                        $('#nomorError').html(`<span>${e.response.data.validation.nomor}</span>`);
                    }
                    if(e.response.data.validation.tahun) {
                        $('#tahunError').html(`<span>${e.response.data.validation.tahun}</span>`);
                    }
                    if(e.response.data.validation.klasifikasi) {
                        $('#klasifikasiError').html(`<span>${e.response.data.validation.klasifikasi}</span>`);
                    }
                    if(e.response.data.validation.pencipta) {
                        $('#penciptaError').html(`<span>${e.response.data.validation.pencipta}</span>`);
                    }
                    if(e.response.data.validation.informasi) {
                        $('#informasiError').html(`<span>${e.response.data.validation.informasi}</span>`);
                    }
                }
                $('meta[name=token_hash]').attr('content', e.response.data.csrf)
                console.log($('meta[name=token_hash]').attr('content'))
            })
            .finally(() => {
                $(this).html('Simpan').attr('disabled', false);
            })
    })

    $('#publikasiBtn').on('click', function() {
        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        $(this).attr('disabled', true)
        axios.post(`/api/arsip/${ARSIP_ID}/publikasi`, data)
            .then(res => {
                setTimeout(() => {
                    location.reload()
                }, 1000);
                $('meta[name=token_hash]').attr('content', res.data.csrf)
            })
            .catch(e => {
                alert(e.response.message)
            })
            .finally(() => {
                setTimeout(() => {
                    $(this).attr('disabled', false)
                }, 1000);
            })
    })

    $('#draftBtn').on('click', function() {
        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        $(this).attr('disabled', true)
        axios.post(`/api/arsip/${ARSIP_ID}/draft`, data)
            .then(res => {
                setTimeout(() => {
                    location.reload()
                }, 1000);
                $('meta[name=token_hash]').attr('content', res.data.csrf)
            })
            .catch(e => {
                alert(e.response.message)
            })
            .finally(() => {
                setTimeout(() => {
                    $(this).attr('disabled', false)
                }, 1000);
            })
    })

    $('#delete-btn').on('click', function() {
        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        $(this).attr('disabled', true)
        axios.post(`/api/arsip/${ARSIP_ID}/hapus`, data)
            .then(res => {
                setTimeout(() => {
                    window.location.href = '/admin/arsip';
                }, 1000);
                $('meta[name=token_hash]').attr('content', res.data.csrf)
            })
            .catch(e => {
                alert(e.response.message)
            })
            .finally(() => {
                setTimeout(() => {
                    $(this).attr('disabled', false)
                }, 1000);
            })
    })
})