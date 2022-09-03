$(function() {
    let user = {};
    
    const getLoginInfo = () => {
        axios.get(`/api/login-info`)
            .then(res => {
                user = res.data.data;
            })
            .catch(e => {
                alert(e.response.data.message)
            })
            .finally(() => {
                revealProfileMenu()
            })
    }

    const revealProfileMenu = () => {
        $('#profile-menu-container').html(`
            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="#"
				id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				<img id="user-image" onerror="this.src = '/assets/images/default-user.png'" src="/assets/images/users/${user.image}" alt="user" class="rounded-circle"
					width="31">
			</a>
			<ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
				<a class="dropdown-item" id="logout" href="javascript:void(0)"><i class="mdi mdi-power m-r-5 m-l-5"></i>
					Logout</a>
			</ul>
        `)
    }

    $(document).on('click', '#logout', function() {
        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'));
    
        axios.post(`/api/logout`, data)
            .then(() => {
                setTimeout(() => {
                    window.location.href = '/signin';
                }, 1000);
                $('meta[name=token_hash]').attr('content', res.data.csrf)
            })
            .catch(e => {
                alert(e.response.data.message)
                $('meta[name=token_hash]').attr('content', e.response.data.csrf)
            })
    })

    getLoginInfo();
})