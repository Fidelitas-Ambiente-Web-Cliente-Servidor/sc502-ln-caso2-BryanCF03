$(function () {
    const urlBase = "index.php";

    function cargarTalleres() {
        $.get(urlBase, { option: "talleres_json" }, function (data) {
            const tbody = $("#talleres-body");
            tbody.empty();
            if (data.length === 0) {
                tbody.append('<tr><td colspan="6" class="text-center">No hay talleres con cupos disponibles</td></tr>');
                return;
            }
            $.each(data, function (i, taller) {
                const row = $("<tr>");
                row.append($("<td>").text(taller.id));
                row.append($("<td>").text(taller.nombre));
                row.append($("<td>").text(taller.descripcion || ""));
                row.append($("<td>").text(taller.cupo_maximo));
                row.append($("<td>").text(taller.cupo_disponible));
                const btn = $("<button>")
                    .text("Solicitar")
                    .addClass("btn btn-primary btn-sm")
                    .data("id", taller.id);
                btn.on("click", function () {
                    solicitarTaller($(this).data("id"));
                });
                row.append($("<td>").append(btn));
                tbody.append(row);
            });
        }, "json").fail(function () {
            $("#talleres-body").html('<tr><td colspan="6" class="text-center text-danger">Error al cargar talleres</td></tr>');
        });
    }

    function solicitarTaller(tallerId) {
        $.post(urlBase, { option: "solicitar", taller_id: tallerId }, function (resp) {
            if (resp.success) {
                $("#mensaje").removeClass("alert-danger").addClass("alert-success").text(resp.message).show();
                cargarTalleres();
            } else {
                $("#mensaje").removeClass("alert-success").addClass("alert-danger").text(resp.error).show();
            }
            setTimeout(function () { $("#mensaje").fadeOut(); }, 3000);
        }, "json").fail(function () {
            $("#mensaje").removeClass("alert-success").addClass("alert-danger").text("Error de conexión").show();
            setTimeout(function () { $("#mensaje").fadeOut(); }, 3000);
        });
    }

    cargarTalleres();
});