document.addEventListener('DOMContentLoaded', function() {
    var openModalLink = document.getElementById('openModalLink');
    var closeModalBtn = document.getElementById('closeModalBtn');
    var modal = document.getElementById('myModal');
    var backdrop = document.getElementById('modalBackdrop');

    var openRegisterModalLink = document.getElementById('openRegisterModalLink');
    var registerModal = document.getElementById('registerModal');
    var closeRegisterModalBtn = document.getElementById('closeRegisterModalBtn');
    var registerBackdrop = document.getElementById('registerModalBackdrop');

    // Abrir el Modal de Inicio de Sesión
    openModalLink.addEventListener('click', function(event) {
        event.preventDefault();
        modal.style.display = 'block';
        backdrop.style.display = 'block';
    });

    // Cerrar el Modal de Inicio de Sesión
    closeModalBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        backdrop.style.display = 'none';
    });

    // Cerrar el Modal de Inicio de Sesión al hacer clic fuera de él
    backdrop.addEventListener('click', function() {
        modal.style.display = 'none';
        backdrop.style.display = 'none';
    });

    // Abrir el Modal de Registro
    openRegisterModalLink.addEventListener('click', function(event) {
        event.preventDefault();
        modal.style.display = 'none';
        backdrop.style.display = 'none';
        registerModal.style.display = 'block';
        registerBackdrop.style.display = 'block';
    });

    // Cerrar el Modal de Registro
    closeRegisterModalBtn.addEventListener('click', function() {
        registerModal.style.display = 'none';
        registerBackdrop.style.display = 'none';
    });

    // Cerrar el Modal de Registro al hacer clic fuera de él
    registerBackdrop.addEventListener('click', function() {
        registerModal.style.display = 'none';
        registerBackdrop.style.display = 'none';
    });

    // Abrir el Modal de Inicio de Sesión desde el Modal de Registro
    var openLoginFromRegisterLink = document.querySelector('#registerModal .signup-link');
    openLoginFromRegisterLink.addEventListener('click', function(event) {
        event.preventDefault();
        registerModal.style.display = 'none';
        registerBackdrop.style.display = 'none';
        modal.style.display = 'block';
        backdrop.style.display = 'block';
    });



    document.querySelectorAll('.togglePassword').forEach(icon => {
        icon.addEventListener('click', function() {
            const passwordInputId = this.dataset.target;
            const passwordInput = document.getElementById(passwordInputId);

            if (passwordInput) {
                passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
            }

            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
    
    

});
