var indexQuest = 0;

var currentQuest = 0;

if(localStorage.getItem("indexQuest") != null){
    var indexQuest = parseInt(localStorage.getItem("indexQuest"));
}

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

    // Shortcut
    $("#listSoal"+indexQuest).removeClass('btn-outline-dark');
    $("#listSoal"+indexQuest).addClass('btn-current');
    
    // Position
    position.textContent = indexQuest + 1 + "/" + lengthQuest;
    currentQuest = indexQuest;

    return;
}

function loadQuesList() {
    var htmlSoal = "";
    for (let i = 0; i < lengthQuest; i++) {
        htmlSoal += '<div class="p-0 col-lg-2 mr-1 mb-1"><button name="shortcutSoal" id="listSoal'+i+'" type="button" name="btnList" onclick="goToIndex(' + i + ')" class="btn btn-outline-dark quiz-list">' + (i + 1) + '</button></div>'
    }
    questList.innerHTML = htmlSoal;

    $("#listSoal"+indexQuest).removeClass('btn-outline-dark');
    $("#listSoal"+indexQuest).addClass('btn-current');
}

function getChoice(currentQuest) {
    var choice = $("input:radio[name ='jawaban"+currentQuest+"']:checked").val();
    answerArr[currentQuest] = choice;
}

function goToIndex(index){
    localStorage.setItem("indexQuest", index);
    getChoice(currentQuest);
    document.getElementById("question"+currentQuest).classList.remove('show');

    $("#listSoal"+currentQuest).removeClass('btn-current');
    $("#listSoal"+currentQuest).addClass('btn-outline-dark');
    indexQuest = index;
    loadQuest(indexQuest);
}

$("#btn-lanjut").on('click', function () {
    indexQuest++;
    goToIndex(indexQuest);
    // loadQuest(indexQuest);
});

$("#btn-kembali").on('click', function () {
    indexQuest--;
    goToIndex(indexQuest);
    // loadQuest(indexQuest);
});

loadQuest(indexQuest);
loadQuesList();