$(function () {
    $("#btnLogout").on("click", function () {
        $.post("index.php", { option: "logout" }, function (data) {
            if (data.response === "00") {
                window.location.href = "index.php?page=login";
            } else {
                alert("Error al cerrar sesión");
            }
        }, "json");
    });
});