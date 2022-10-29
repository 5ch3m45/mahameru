$(function() {
    let user = {};
    
    const getUser = () => {
        axios.get(`/api/user`)
            .then(res => {
                user = res.data.user;
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
            <a 
                id="navbarDropdown" 
                class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" 
                href="#"
                role="button" 
                data-bs-toggle="dropdown" 
                aria-expanded="false">
				<img 
                    id="user-image" 
                    class="rounded-circle"
					width="31"
                    src="${user.image}" alt="user" 
                    onerror="this.src = '/assets/images/default-user.png'">
			</a>
			<ul 
                class="dropdown-menu dropdown-menu-end user-dd animated" 
                aria-labelledby="navbarDropdown">
				<a 
                    id="profile" 
                    class="dropdown-item" 
                    href="javascript:void(0)">
                    <i class="bi bi-person-circle m-r-5 m-l-5"></i> Profil Anda
                </a>
				<a 
                    id="logout" 
                    class="dropdown-item" 
                    href="javascript:void(0)">
                    <i class="bi bi-power m-r-5 m-l-5"></i> Logout
                </a>
			</ul>
        `)
    }

    $(document).on('click', '#logout', function() {
        let data = new FormData();
        data.append($('meta[name=token_name]').attr('content'), $('meta[name=token_hash]').attr('content'));
    
        axios.post(`/api/logout`, data)
            .then(() => {
                setTimeout(() => {
                    window.location.href = '/login';
                }, 1000);
                $('meta[name=token_hash]').attr('content', res.data.csrf)
            })
            .catch(e => {
                alert(e.response.data.message)
                $('meta[name=token_hash]').attr('content', e.response.data.csrf)
            })
    })

    getUser();
})