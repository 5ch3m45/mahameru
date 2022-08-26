$(function(){
    $('.my-masonry-grid').masonryGrid({
      'columns': 3
    });
});

Dropzone.autoDiscover = false;
$(document).ready(function() {
    const ARSIP_ID = window.location.pathname.split('/')[4];

    $("#my-awesome-dropzone").dropzone({ 
        url: `/api/arsip/${ARSIP_ID}/lampiran`, 
        init: function() {
            this.on('sending', function(filex, xhr, formData) {
                formData.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'))
            })

            this.on('success', function(res) {
                let response = JSON.parse(res.xhr.response)
                console.log(res)
                $('meta[name=token_hash]').attr('content', response.csrf)

                if(res.type == 'image/png') {
                    // todo data-id lampiran
                    let random = Math.floor(Math.random() * 2) + 1;
                    $('.masonry-grid-column-'+random).append(`
                        <img data-id="${response.data.id}" data-url="${response.data.url}" class="lampiran my-masonry-grid-item p-1" style="max-width: 100%" src="${res.dataURL}" alt="">
                    `)
                }
                if(res.type == 'image/jpeg') {
                    // todo data-id lampiran
                    let random = Math.floor(Math.random() * 2) + 1;
                    $('.masonry-grid-column-'+random).append(`
                        <img data-id="${response.data.id}" data-url="${response.data.url}" class="lampiran my-masonry-grid-item p-1" style="max-width: 100%" src="${res.dataURL}" alt="">
                    `)
                }
                if(res.type == 'video/mp4') {
                    // todo data-id lampiran
                    let random = Math.floor(Math.random() * 2) + 1;
                    $('.masonry-grid-column-'+random).append(`
                        <img data-id="${response.data.id}" data-url="/assets/images/mp4.png" class="lampiran my-masonry-grid-item p-1" style="max-width: 100%" src="/assets/images/mp4.png" alt="">
                    `)
                }
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
            $('#lampiranFile').html(`<img src="${$(this).data('url')}" style="max-width: 100%">`)
        }
        $('#fotoDetailModal').modal('show')
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
        axios.post(`/api/arsip/${ARSIP_ID}/update`, data)
            .then(res => {
                if(res.data.success == true) {
                    if(res.data.data.informasi) {
                        $('#informasiText').html(res.data.data.informasi);
                    }
                    $('#nomorText').html(res.data.data.nomor);
                    $('#nomorTitle').html('#'+res.data.data.nomor);
                    $('#nomorBreadcrumb').html('#'+res.data.data.nomor);
                    $('#tahunText').html(res.data.data.tahun);
                    $('#klasifikasiText').html(res.data.data.nomor);
                    $('#penciptaText').html(res.data.data.pencipta);

                    setTimeout(() => {
                        $('#ubahInformasiModal').modal('hide');
                    }, 1000);
                }
                $('meta[name=token_hash]').attr('content', res.data.csrf)
            })
            .catch(e => {
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
            })
            .finally(() => {
                setTimeout(() => {
                    $(this).html('Simpan').attr('disabled', false);
                }, 1000);
            })
    })
})