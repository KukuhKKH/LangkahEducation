var indexQuest = 0;
var currentQuest = 0;
var answerArr = [];
var lengthQuest = total_soal;
var position = document.getElementById("posisi-soal");
var questList = document.getElementById("daftar-soal");

function loadQuest(indexQuest) {
    if (indexQuest == 0) {
        $("#btn-kembali").prop("disabled", true);
        $("#btn-kumpulkan").prop("disabled", true);
        $("#btn-lanjut").prop("disabled", false);
    } else if (indexQuest == lengthQuest - 1) {
        $("#btn-lanjut").prop("disabled", true);
        $("#btn-kumpulkan").prop("disabled", false);
        $("#btn-kembali").prop("disabled", false);
    } else {
        $("#btn-kumpulkan").prop("disabled", true);
        $("#btn-lanjut").prop("disabled", false);
        $("#btn-kembali").prop("disabled", false);
    }
    document.getElementById("question"+indexQuest).classList.add('show');

    $("#listSoal"+indexQuest).removeClass('btn-outline-dark');
    $("#listSoal"+indexQuest).addClass('btn-primary');
    position.textContent = indexQuest + 1 + "/" + lengthQuest;
    currentQuest = indexQuest;
    return;
}

function loadQuesList() {
    var htmlSoal = "";
    for (let i = 0; i < lengthQuest; i++) {
        htmlSoal += '<div class="p-0 col-lg-2 mr-1 mb-1"><button id="listSoal'+i+'" type="button" name="btnList" onclick="goToIndex(' + i + ')" class="btn btn-outline-dark quiz-list">' + (i + 1) + '</button></div>'
    }
    questList.innerHTML = htmlSoal;

    $("#listSoal"+indexQuest).removeClass('btn-outline-dark');
    $("#listSoal"+indexQuest).addClass('btn-primary');
}

function getChoice(currentQuest) {
    var choice = $("input:radio[name ='jawaban"+currentQuest+"']:checked").val();
    answerArr[currentQuest] = choice;
}

function goToIndex(index){
    getChoice(currentQuest);
    document.getElementById("question"+currentQuest).classList.remove('show');

    $("#listSoal"+currentQuest).removeClass('btn-primary');
    $("#listSoal"+currentQuest).addClass('btn-outline-dark');
    indexQuest = index;
    loadQuest(indexQuest);
}

$("#btn-lanjut").on('click', function () {
    let indexNow = currentQuest
    let now = document.getElementById("question"+indexNow).getAttribute('data-kategori')
    let indexNext = indexNow + 1
    let next = document.getElementById("question"+indexNext).getAttribute('data-kategori')

    if(now != next) {
        swal.fire({
            title: 'Yakin?',
            text: "Yakin ingin pindah kategori ke "+next,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.isConfirmed) {
                indexQuest++;
                indexwaktu++;
                // variabel di file
                let indexsekarang_js = indexwaktu
                localStorage.setItem(`waktu-index-${user}-${paket_slug}`, indexsekarang_js)
                waktu_sekarang = moment().add(WAKTU[indexwaktu], 'minutes').format('YYYY-MM-D H:mm:ss')

                localStorage.setItem(`waktu-${user}-${paket_slug}`, waktu_sekarang)
                compSiswaWaktu.setAttribute('data-time', waktu_sekarang)
                // Var Lokal
                let waktu_componen_js = $('.sisawaktu')[0].getAttribute('data-time')
                sisawaktu(waktu_componen_js)
                goToIndex(indexQuest);
            }
         })
    } else {
        indexQuest++;
        goToIndex(indexQuest);
    }
    // loadQuest(indexQuest);
});

$("#btn-kembali").on('click', function () {
    let indexNow = currentQuest
    let now = document.getElementById("question"+indexNow).getAttribute('data-kategori')
    let indexPrev = indexNow - 1
    let prev = document.getElementById("question"+indexPrev).getAttribute('data-kategori')

    if(now != prev) {
        swal.fire({
            icon: 'error',
            text: 'anda tidak bisa kembali ke kategori '+prev
         })
    } else {
        indexQuest--;
        goToIndex(indexQuest);
    }
    // loadQuest(indexQuest);
});

loadQuest(indexQuest);
loadQuesList();