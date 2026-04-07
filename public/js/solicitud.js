$(function () {
    const urlBase = "index.php";

    function cargarSolicitudes() {
        $.get(urlBase, { option: "solicitudes_json" }, function (data) {
            const tbody = $("#solicitudes-body");
            tbody.empty();
            if (data.length === 0) {
                tbody.append('<tr><td colspan="5" class="text-center">No hay solicitudes pendientes</td></tr>');
                return;
            }
            $.each(data, function (i, solicitud) {
                const row = $("<tr>");
                row.append($("<td>").text(solicitud.id));
                row.append($("<td>").text(solicitud.taller_nombre));
                row.append($("<td>").text(solicitud.solicitante));
                row.append($("<td>").text(solicitud.fecha_solicitud));
                const btnAprobar = $("<button>")
                    .text("Aprobar")
                    .addClass("btn btn-success btn-sm me-2")
                    .data("id", solicitud.id);
                const btnRechazar = $("<button>")
                    .text("Rechazar")
                    .addClass("btn btn-danger btn-sm")
                    .data("id", solicitud.id);
                btnAprobar.on("click", function () { procesarSolicitud($(this).data("id"), "aprobar"); });
                btnRechazar.on("click", function () { procesarSolicitud($(this).data("id"), "rechazar"); });
                const actions = $("<td>").append(btnAprobar).append(" ").append(btnRechazar);
                row.append(actions);
                tbody.append(row);
            });
        }, "json").fail(function () {
            $("#solicitudes-body").html('<tr><td colspan="5" class="text-center text-danger">Error al cargar solicitudes</td></tr>');
        });
    }

    function procesarSolicitud(id, accion) {
        const data = { option: accion, id_solicitud: id };
        $.post(urlBase, data, function (resp) {
            if (resp.success) {
                $("#mensaje").removeClass("alert-danger").addClass("alert-success").text("Solicitud " + (accion === "aprobar" ? "aprobada" : "rechazada") + " correctamente").show();
                cargarSolicitudes();
            } else {
                $("#mensaje").removeClass("alert-success").addClass("alert-danger").text(resp.error || "Error al procesar").show();
            }
            setTimeout(function () { $("#mensaje").fadeOut(); }, 3000);
        }, "json").fail(function () {
            $("#mensaje").removeClass("alert-success").addClass("alert-danger").text("Error de conexión").show();
            setTimeout(function () { $("#mensaje").fadeOut(); }, 3000);
        });
    }

    cargarSolicitudes();
});