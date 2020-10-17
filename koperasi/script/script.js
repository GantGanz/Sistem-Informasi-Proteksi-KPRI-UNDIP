var keyword = document.getElementById("keyword");
var tombolCari = document.getElementById("tombolCari");
var tabelPencarian = document.getElementById("tabelPencarian");

keyword.addEventListener("keyup", function () {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            tabelPencarian.innerHTML = xhr.responseText;
        }
    };

    xhr.open("GET", "../ajax/anggota.php?keyword=" + keyword.value, true);
    xhr.send();
});