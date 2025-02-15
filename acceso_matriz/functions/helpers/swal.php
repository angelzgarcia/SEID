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
        
        'fire' => <<<HTML
        HTML,
        
        'modal' => <<<HTML
        HTML,
        
        'confirm_status' => <<<HTML
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.querySelectorAll(".destroy-btn button").forEach(button => {
                        button.addEventListener("click", function() {
                            const formId = this.dataset.form;
                            const form = document.getElementById(formId);
                            
                            if (!form) {
                                console.error("Formulario no encontrado:", formId);
                                return;
                            }

                            Swal.fire({
                                title: "{$title}",
                                toast: true,
                                icon: "{$icon}",
                                position: 'center',
                                iconColor: 'white',
                                showCancelButton: true,
                                showConfirmButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                cancelButtonText: 'Cancelar',
                                confirmButtonText: this.dataset.confirm || "Sí, modificar",
                                customClass: {
                                    popup: 'colored-toast',
                                },
                            }).then((result) => {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-start",
                                    showConfirmButton: false,
                                    timerProgressBar: true,
                                    iconColor: 'white',
                                    customClass: {
                                        popup: 'colored-toast',
                                    },
                                    didOpen: (toast) => {
                                        toast.onmouseenter = Swal.stopTimer;
                                        toast.onmouseleave = Swal.resumeTimer;
                                    }
                                });

                                if (result.isConfirmed) {
                                    form.submit();
                                } else {
                                    Toast.fire({
                                        icon: "info",
                                        title: "Operación cancelada",
                                        timer: 3000
                                    });
                                }
                            });
                        });
                    });
                });
            </script>
        HTML,

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
