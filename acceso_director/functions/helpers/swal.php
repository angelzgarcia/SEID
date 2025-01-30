<?php

function swal($icon, $title, $type = 'toast', $time = 3000)
{
    return match ($type) {
        'toast' => <<<HTML
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: "{$time}",
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                    });
                    Toast.fire({
                        icon: "{$icon}",
                        title: "{$title}"
                    });
            </script>
        HTML,
        'fire' => '',
        'modal' => '',
        'confirm' => '',
        default => <<<HTML
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: "{$time}",
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                    });
                    Toast.fire({
                        icon: "{$icon}",
                        title: "{$title}"
                    });
            </script>
        HTML
    };
}
