// config Dropzone
Dropzone.autoDiscover = false;
// arsip
$(function() {
    let _id = window.location.pathname.split('/')[4];

    function _templateResult(res) {
        return res.kode+'. '+(res.nama ? res.nama.toUpperCase() : res.nama);
    }
    
    function _templateSelection(res) {
        if(res.text) {
            return res.text.toUpperCase();
        }

        return res.kode+'. '+(res.nama ? res.nama.toUpperCase() : res.nama);
    }

    function _levelParser(level) {
        if(level == 1) {
            return '<span class="badge bg-danger">Rahasia</span>';
        }
        if(level == 2) {
            return '<span class="badge bg-success">Publik</span>';
        }
    }

    $('#klasifikasiSelect').select2({
        ajax: {
            delay: 300,
            url: '/api/dashboard/klasifikasi',
            data: function(params) {
                var query = {
                    search: params.term,
                }

                return query;
            },
            processResults: function(data) {
                return {
                    results: data.data
                }
            }
        },
        theme: 'bootstrap-5',
        dropdownParent: $('#ubahInformasiModal'),
        placeholder: 'Cari klasifikasi',
        templateResult: _templateResult,
        templateSelection: _templateSelection
    })

    function _statusParser(status) {
        switch (status) {
            case '1':
                return '<span class="badge bg-warning">Draft</span>';

            case '2':
                return '<span class="badge bg-success">Terpublikasi</span>';
                
            case '3':
                return '<span class="badge bg-danger text-light">Dihapus</span>';
        
            default:
                break;
        }
    }

    function _lampiranParser(lampiran) {
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
        } else if(['application/pdf'].includes(lampiran.type)) {
            return `<img 
                data-id="${lampiran.id}" 
                data-url="${lampiran.url}" 
                data-type="${lampiran.type}" 
                class="lampiran lampiran-${lampiran.id} my-masonry-grid-item p-1" 
                style="max-width: 100%" 
                src="/assets/images/pdf.png">`
        }
    }

    function getArsip() {
        axios.get('/api/dashboard/arsip/'+_id)
            .then(res => {
                const { 
                    nomor, 
                    status, 
                    informasi, 
                    klasifikasi, 
                    pencipta, 
                    tanggal,
                    tanggal_formatted, 
                    last_updated,
                    level,
                    lampirans
                } = res.data.data;

                // set text
                $('#nomor-arsip-breadcrumb').text(nomor ? '#'+nomor : '');
                $('#nomor-arsip-title').text(nomor ? '#'+nomor : '');
                $('#nomor-arsip-text').text(nomor ? nomor : '');
                $('#informasi-text').html(informasi ? informasi : '<em class="text-secondary">Belum ada informasi</em>');
                $('#klasifikasi-arsip-text').html(klasifikasi.id ? klasifikasi.kode+'. '+klasifikasi.nama : '-');
                $('#pencipta-arsip-text').html(pencipta ? pencipta : '-');
                $('#tanggal-arsip-text').html(tanggal_formatted ? tanggal_formatted : '-');
                $('#last-updated-text').html(last_updated);
                $('#level-text').html(_levelParser(level));
                $('#status-flag').html(_statusParser(status));
                // status
                if(status == 1) {
                    $('#publikasiBtn').show();
                    $('#draftBtn').hide();
                    $('#delete-arsip-btn').show();
                    $('#restore-btn').hide();
                }
                if(status == 2) {
                    $('#publikasiBtn').hide();
                    $('#draftBtn').show();
                    $('#delete-arsip-btn').show();
                    $('#restore-btn').hide();
                }
                if(status == 3) {
                    $('#publikasiBtn').hide();
                    $('#draftBtn').hide();
                    $('#delete-arsip-btn').hide();
                    $('#restore-btn').show();
                }
                if(lampirans.length) {
                    $('.my-masonry-grid').html('');
                    lampirans.forEach(lampiran => {
                        $('.my-masonry-grid').append(_lampiranParser(lampiran));
                    });
                    $('.my-masonry-grid').masonryGrid({
                        'columns': 3
                    });
                } else {
                    $('.my-masonry-grid').html('');
                    $('.my-masonry-grid').html('<em>Belum ada lampiran</em>');
                }
                // set form value
                $('#nomorInput').val(nomor);
                $('#tanggalInput').val(tanggal);
                if(klasifikasi.id) {
                    let option = new Option(klasifikasi.kode+'. '+klasifikasi.nama, klasifikasi.id, true, true);
                    $('#klasifikasiSelect').append(option).trigger('change');
                }
                $('#level-select').val(level);
                $('#penciptaInput').val(pencipta);
                $('#informasiTextarea').val(informasi);
            })
            .catch(e => {
                console.log(e.response)
            })
            .finally(function() {
                
            })
    }

    getArsip();

    // show detail lampiran
    $(document).on('click', '.lampiran', function() {
        if($(this).data('type') == 'video/mp4') {
            $('#lampiranFile').html(`
                <video id="lampiranVideo" width="640" height="360" controls>
                    <source src="${$(this).data('url')}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            `)
        }else if($(this).data('type') == 'application/pdf') {
            $('#lampiranFile').html(`<iframe src="${$(this).data('url')}" style="width: 80vw; height: 80vh">`)
        } else {
            $('#lampiranFile').html(`<img src="${$(this).data('url')}" style="max-width: 100%; max-height: 80vh">`)
        }
        $('#hapusLampiranBtn').data('id', $(this).data('id'))
        $('#lampiranDetailModal').modal('show')
    })

    // delete lampiran
    $('#hapusLampiranBtn').on('click', function() {
        $('#hapusLampiranSubmit').data('id', $(this).data('id'))
        $('#hapusLampiranConfirmModal').modal('show')
    })
    $('#hapusLampiranSubmit').on('click', function() {
        $(this).html('<image src="/assets/images/loader/loading-light.svg"/> Hapus').attr('disabled', true);
        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        axios.post(`/api/dashboard/arsip/${_id}/lampiran/${$(this).data('id')}/hapus`, data)
            .then(res => {
                $('#hapusLampiranConfirmModal').modal('hide');
                $('#lampiranDetailModal').modal('hide');
                $('meta[name=token_hash]').attr('content', res.data.csrf)
                $.notify('Berhasil dihapus', 'success');
            })
            .catch(e => {
                $('meta[name=token_hash]').attr('content', e.response.csrf)
                $.notify('Terjadi kesalahan', 'error');
            })
            .finally(() => {
                $(this).html('Hapus').attr('disabled', false);
                getArsip();
            })
    })

    // upload lampiran
    $('#uploadNewImageBtn').on('click', function() {
        $('#uploadNewImageModal').modal('show')
    })
    $("#my-awesome-dropzone").dropzone({ 
        url: `/api/dashboard/arsip/${_id}/lampiran`, 
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
                $.notify('Berhasil tersimpan', 'success');
            })

            this.on('error', function(file, response) {
                $('meta[name=token_hash]').attr('content', response.csrf);
                if(response.validation) {
                    $.notify(response.validation.replace(/(<([^>]+)>)/ig, ''), 'error');
                } else {
                    $.notify('Terjadi kesalahan', 'error');
                }
            })
        }
    });
    $('#doneUploadLampiran').on('click', function() {
        $('#uploadNewImageModal').modal('hide');
        getArsip();
    })

    // edit info
    $('#ubahInformasiBtn').on('click', function() {
        $('#ubahInformasiModal').modal('show')
    })
    $('#nomorInput').on('keyup', function() {
        $('#nomorError').html('')
    })
    $('#tanggalInput').on('keyup', function() {
        $('#tanggalError').html('')
    })

    $('#informasiTextarea').on('keyup', function() {
        $('#informasiError').html('')
    })
    $('#submitArsipBtn').on('click', function() {
        $(this).html('<image src="/assets/images/loader/loading-light.svg"/> Simpan').attr('disabled', true);
        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        data.append('nomor', $('#nomorInput').val());
        data.append('tanggal', $('#tanggalInput').val());
        data.append('informasi', $('#informasiTextarea').val());
        data.append('pencipta', $('#penciptaInput').val());
        data.append('klasifikasi', $('#klasifikasiSelect').val());
        data.append('level', $('#level-select').val());
        axios.post(`/api/dashboard/arsip/${_id}/update`, data)
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
                $('#tanggal-arsip-text').html(item.tanggal_formatted ? item.tanggal_formatted : '-');
                if(item.klasifikasi_id) {
                    $('#klasifikasi-arsip-text').html(item.klasifikasi.kode+' | '+item.klasifikasi.nama)
                }
                $('#pencipta-arsip-text').html(item.pencipta ? item.pencipta : '-');
                $('#level-text').html(item.level == '2' ? '<span class="badge bg-success">Publik</span>' : '<span class="badge bg-danger">Rahasia</span>')

                $('meta[name=token_hash]').attr('content', res.data.csrf);

                $.notify('Berhasil tersimpan', 'success');
            })
            .catch(e => {
                console.log(e)
                if(e.response.data.validation) {
                    if(e.response.data.validation.nomor) {
                        $('#nomorError').html(`<span>${e.response.data.validation.nomor}</span>`);
                    }
                    if(e.response.data.validation.tanggal) {
                        $('#tanggalError').html(`<span>${e.response.data.validation.tanggal}</span>`);
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
            })
            .finally(() => {
                $(this).html('Simpan').attr('disabled', false);
            })
    })

    // publish
    $('#publikasiBtn').on('click', function() {
        $(this).html('<image src="/assets/images/loader/loading-light.svg"/>').attr('disabled', true);

        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))

        axios.post(`/api/dashboard/arsip/${_id}/publikasi`, data)
            .then(res => {
                $('meta[name=token_hash]').attr('content', res.data.csrf)
                $.notify('Berhasil tersimpan', 'success');
            })
            .catch(e => {
                console.log(e);
                $.notify('Terjadi kesalahan', 'error');
            })
            .finally(() => {
                $(this).html('<i class="bi bi-share-fill"></i> Publikasi').attr('disabled', false);
                getArsip();
            })
    })

    //draft
    $('#draftBtn').on('click', function() {
        $(this).html('<image src="/assets/images/loader/loading.svg"/>').attr('disabled', true);

        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
        
        axios.post(`/api/dashboard/arsip/${_id}/draft`, data)
            .then(res => {
                $('meta[name=token_hash]').attr('content', res.data.csrf)
                getArsip();
                $.notify('Berhasil tersimpan', 'success');
            })
            .catch(e => {
                console.log(e);
                $.notify('Terjadi kesalahan', 'error');
            })
            .finally(() => {
                $(this).html('<i class="bi bi-input-cursor-text"></i> Simpan sebagai draft').attr('disabled', false);
            })
    })

    //delete
    $('#delete-arsip-btn').on('click', function() {
        $('#deleteArsipModal').modal('show');
    });
    $('#delete-arsip-form').on('submit', function(e) {
        e.preventDefault();

        $('#delete-arsip-form [type=submit]').html('<image src="/assets/images/loader/loading.svg"/>').attr('disabled', true);

        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))

        axios.post($(this).attr('action'), data)
            .then(res => {
                $('meta[name=token_hash]').attr('content', res.data.csrf);
                $.notify('Berhasil dihapus', 'success');
                $('#deleteArsipModal').modal('hide');
            })
            .catch(e => {
                console.log(e);
                $.notify('Terjadi kesalahan', 'error');
            })
            .finally(() => {
                getArsip();
                $('#delete-arsip-form [type=submit]').html('Hapus').attr('disabled', false);
            })
    })

    // restore
    $('#restore-btn').on('click', function() {
        $('#restoreModal').modal('show');
    });
    $('#restore-form').on('submit', function(e) {
        e.preventDefault();

        $('#restore-form [type=submit]').html('<image src="/assets/images/loader/loading.svg"/>').attr('disabled', true);

        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))

        axios.post($(this).attr('action'), data)
            .then(res => {
                $('meta[name=token_hash]').attr('content', res.data.csrf);
                $.notify('Berhasil dikembalikan', 'success');
                $('#restoreModal').modal('hide');
            })
            .catch(e => {
                console.log(e);
                $.notify('Terjadi kesalahan', 'error');
            })
            .finally(() => {
                getArsip();
                $('#restore-form [type=submit]').html('Kembalikan').attr('disabled', false);
            })
    })
})