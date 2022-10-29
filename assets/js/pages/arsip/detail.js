$(function() {
    $('.my-masonry-grid').masonryGrid({
        'columns': 3
    })

    $('.card-body-lampiran').height($('.card-body-lampiran').width() * 1)

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

    $(document).on('click', '.lampiran', function() {
        if($(this).data('type') == 'video/mp4') {
            $('#lampiranFile').html(`
                <video id="lampiranVideo" width="640" height="360" controls>
                    <source src="${$(this).data('url')}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            `)
        } else if($(this).data('type') == 'application/pdf') {
            $('#lampiranFile').html(`<iframe src="${$(this).data('url')}" style="width: 80vw; height: 80vh">`)
        } else {
            $('#lampiranFile').html(`<img src="${$(this).data('url')}" style="max-width: 100%; max-height: 80vh">`)
        }
        $('#lampiranDetailModal').modal('show')
    })
})