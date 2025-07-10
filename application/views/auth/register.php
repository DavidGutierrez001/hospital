<main class="bg-form">
    <div class="d-flex w-100 min-vh-100 justify-content-center align-items-center">
        <section id="containForm" class="form start-in px-3 py-5 m-3">
            <div class="d-flex flex-column text-secondary pb-4">
                <h6 id="stepInfo" class="text-pass1 fw-bold">PASO 1 DE 2</h6>
                <h3 id="stepTitle" class="fw-bold fs-3">Crea tu cuenta</h3>
            </div>

            <form action="<?php echo base_url('register_user'); ?>" method="POST" class="gap-5 d-flex position-relative">
                <div id="step1" class="d-flex flex-column w-100 gap-4 step-1 position-relative active">
                    <span id="errorEmail" class="error-email d-none d-flex gap-2"><i class="bi bi-exclamation-circle"></i>Este correo ya existe en el sistema.</span>
                    <div>
                        <label for="email" class="form-label">Correo Electrónico<span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <input type="email" class="form-control ps-5" id="email" name="email" placeholder="Ingresa un correo" required autocomplete="off">
                            <i class="bi bi-envelope-at-fill text-purple position-absolute top-50 translate-middle"></i>
                        </div>
                    </div>
                    <div>
                        <label for="password" class="form-label">Contraseña<span class="text-danger">*</span></label>
                        <div class="position-relative">
                            <i class="bi bi-shield-lock-fill text-purple position-absolute top-50 translate-middle"></i>
                            <i id="showPassword" class="bi bi-eye-slash-fill text-purple position-absolute top-50 translate-middle"></i>
                            <input type="password" class="form-control ps-5" id="password" name="password" placeholder="Ingresa una contraseña" required>
                        </div>
                    </div>
                    <div>
                        <button type="button" id="btnNext" class="d-flex lh-3 justify-content-center align-items-center bg-purple w-100 text-white my-3">
                            <span id="btnText">Continuar</span>
                        </button>
                    </div>
                    <div class="d-flex justify-content-center">
                        <span class="fs-8 text-secondary opacity-50">¿Ya tienes una cuenta? <a href="<?php echo base_url('login') ?>" class="login-link">Iniciar sesión</a></span>
                    </div>
                </div>
                <div id="step2" class="d-flex flex-column w-100 h-100 gap-4 step-2"></div>
            </form>
        </section>
    </div>
</main>
