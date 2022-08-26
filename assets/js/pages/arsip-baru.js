$(document).ready(function() {
    const informasiField = $('textarea[name=informasi]');
    const nomorField = $('input[name=nomor]');
    const klasifikasiField = $('select[name=klasifikasi]');
    const penciptaField = $('select[name=pencipta]');
    const tahunField = $('input[name=tahun]')

    const informasiError = $('#informasi-error');
    const nomorError = $('#nomor-error');
    const klasifikasiError = $('#klasifikasi-error');
    const penciptaError = $('#pencipta-error');
    const tahunError = $('#tahun-error');

    const submitBtn = $('#simpan-arsip-btn')
    const tambahLampiranBtn = $('#tambah-lampiran-btn');

    tahunField.on('keyup', function() {
        tahunError.text('').hide();
    })

    submitBtn.on('click', function() {
        if(!tahunField.val()) {
            tahunError.text('Tahun tidak boleh kosong').show()
            return;
        }

        let data = {
            informasi   : informasiField.val(),
            nomor       : nomorField.val(),
            klasifikasi : klasifikasiField.val(),
            pencipta    : penciptaField.val(),
            tahun       : tahunField.val()
        };

        console.log(data);
    })
})