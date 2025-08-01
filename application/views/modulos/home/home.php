<style>
    .main-target {
        width: 100%;
        max-width: 55rem;
        height: 15rem;
        background-image: url(<?= base_url('assets/img/backgrounds/Sprinkle2.svg') ?>);
        background-size: cover;
        background-position: center;
    }
</style>

<div class="main-target rounded-4 ps-5 pt-5">
    <h3 class="text-white">Buenos días!</h3>
    <span class="fs-2 fw-medium text-white">
        <?= htmlspecialchars(
            $this->session->userdata['primer_nombre'] . ' ' .
                $this->session->userdata['segundo_nombre'] . ' ' .
                $this->session->userdata['primer_apellido']
        ) ?>
    </span>
</div>