const btn_menu = document.querySelector('#btn_menu');
const menu = document.querySelector('nav>div>div');
const menu_black = document.querySelector('.menu-black');

btn_menu.addEventListener("click", () => {
    menu.classList.toggle("menu-active");
    menu_black.classList.toggle("menu-active");
});

menu_black.addEventListener("click", () => {
    menu.classList.remove("menu-active");
    menu_black.classList.remove("menu-active");

    if (menu_black.classList.contains("menu-active")) {
        menu_black.classList.remove("menu-active");
    }
});


const abrir_submenu = document.querySelectorAll('#icon_right');

abrir_submenu.forEach((data)=>{
    data.addEventListener('click',()=>{
        data.parentElement.parentElement.classList.toggle("activate");
        
        if(data.classList[1]=='fa-angle-right'){
            data.classList = 'fa-solid fa-angle-down';
        }else{
            data.classList = 'fa-solid fa-angle-right';
        }

    })
})


function toggleList() {
    var floatingList = document.getElementById("floatingList");
    if (floatingList.style.display === "block") {
        floatingList.style.display = "none";
    } else {
        floatingList.style.display = "block";
    }
}

// Ojito de Contraseña de la pagina clavecamb
document.addEventListener('DOMContentLoaded', function() {
    const togglePasswordIcons = document.querySelectorAll('#togglePassword');
    
    togglePasswordIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const input = this.previousElementSibling;
            
            if (input.type === 'password') {
                input.type = 'text';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });
});



document.addEventListener("DOMContentLoaded", function() {
    const id = document.getElementById("idfoto").value;
    if (id) {
        cargarImagenPerfil(id);
    }
});

function cargarImagenPerfil(id) {
    const url = base_url + "HomeBibl/editarPerfil/" + id;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();

    http.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            try {
                const res = JSON.parse(this.responseText);
                const perfilImg = document.getElementById('img-perfil');
                perfilImg.src = res.foto && res.foto !== 'user.png'     
                    ? base_url + 'Assets/img/Foto_user/' + res.foto 
                    : base_url + 'Assets/img/Foto_user/user.png';
            } catch (e) {
                console.error('Error al parsear JSON:', e);
                alert('Error al procesar la respuesta del servidor.');
            }
        } else if (this.readyState === 4) {
            alert('Error en la solicitud: ' + this.status);
        }
    };
}

