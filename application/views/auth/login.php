<main class="bg-form">
    <div class="d-flex w-100 p-3 min-vh-100 justify-content-center align-items-center">
        <section id="containForm" class="form start-in px-3 py-5">
            <div class="d-flex flex-column text-secondary pb-4">
                <h3 id="stepTitle" class="fw-bold fs-3">¡Bienvenido!</h3>
            </div>

            <form id="form" action="<?php echo base_url('login_user'); ?>" method="POST" class="gap-3 d-flex position-relative">
                <div id="step1" class="d-flex flex-column w-100 gap-4 step-1 position-relative active">
                    <span id="errorEmail" class="error-email d-none d-flex gap-3"><i class="bi bi-exclamation-circle"></i>No hemos encontrado este correo en el sistema.</span>
                    <div>
                        <label for="email" class="form-label">Correo Electrónico<span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <input type="email" class="form-control ps-5" id="email" name="email" placeholder="Ingresa tu correo" required autocomplete="username">
                            <i class="bi bi-envelope-at-fill text-purple position-absolute top-50 translate-middle"></i>
                        </div>
                    </div>
                    <div>
                        <label for="password" class="form-label">Contraseña<span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <i class="bi bi-shield-lock-fill text-purple position-absolute top-50 translate-middle"></i>
                            <input type="password" class="form-control ps-5" id="password" name="password" placeholder="Ingresa tu contraseña" required autocomplete="current-password">
                        </div>
                        <div class="d-flex w-100 justify-content-end">
                            <a class="fs-8 my-2 opacity-50" href="">¿Olvidaste tu contraseña?</a>
                        </div>
                    </div>
                    <div>
                        <button id="btnLogin" type="submit" class="d-flex lh-3 justify-content-center align-items-center bg-purple w-100 text-white my-3 position-relative">
                            <span class="" id="btnText">Iniciar sesión</span>
                        </button>
                    </div>
                    <div class="d-flex justify-content-center mt-auto">
                        <span class="fs-8 text-secondary opacity-50">¿No tienes una cuenta? <a href="<?php echo base_url('register') ?>" class="login-link">Crear una cuenta</a></span>
                    </div>
            </form>
        </section>
    </div>
</main>