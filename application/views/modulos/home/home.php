<div class="main-home flex-wrap">
    <div class="main-target rounded-4 position-relative">
        <h3 class="text-white">Buenos días!</h3>
        <span class="fs-2 fw-medium text-white">
            <?= htmlspecialchars(
                $this->session->userdata['primer_nombre'] . ' ' .
                    $this->session->userdata['segundo_nombre'] . ' ' .
                    $this->session->userdata['primer_apellido']
            ) ?>
        </span>
        <h1 class="position-absolute end-0 bottom-0 text-white p-4 fs-2"><?php echo date('h:i A') ?></h1>
    </div>
    <div class="calendar-home">
        <div id='calendar'></div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "dayGridMonth",
            themeSystem: "bootstrap5",
            height: "100%",
            selectable: false,
            locale: "es",
            buttonText: {
                today: "Hoy",
                month: "Mes",
                week: "Semana",
                day: "Día",
            },
        });
        calendar.render();
    });
</script>