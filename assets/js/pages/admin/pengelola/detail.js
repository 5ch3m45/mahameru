$(function() {
    const adminID = window.location.pathname.split('/')[4]
    console.log(adminID)
    const load = () => {
        axios.get(`/api/admin/${adminID}`)
            .then(res => {
                $('#admin-nama-breadcrumb').text(res.data.data.nama ? res.data.data.nama : '')
                $('#admin-nama-title').text(res.data.data.nama ? res.data.data.nama : '')
                $('#admin-email').text(res.data.data.email ? res.data.data.email : '')
                $('#admin-arsip-count').text(res.data.data.arsip_count ? res.data.data.arsip_count : '')
                $('#admin-last-login').text(res.data.data.last_login ? res.data.data.last_login : '')
            })
    }

    load();
})