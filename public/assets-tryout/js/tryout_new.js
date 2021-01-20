var indexQuest = 0;
var currentQuest = 0;


// localStorage.removeItem(`marked-${gelombang_id}-${user}-${paket_slug}`)

var answerArr = [];
var lengthQuest = total_soal;

var position = document.getElementById("posisi-soal");
var questList = document.getElementById("daftar-soal");

// if(localStorage.getItem(`indexQuest-${gelombang_id}-${user}-${paket_slug}`) != null){
//     var indexQuest = parseInt(localStorage.getItem(`indexQuest-${gelombang_id}-${user}-${paket_slug}`));
//     position.textContent = indexQuest + 1 + "/" + lengthQuest;
// }

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
    console.log("HELLO")
    position.textContent = indexQuest + 1 + "/" + lengthQuest;

    document.getElementById("question"+indexQuest).classList.add('show');
    updateMarked(indexQuest)
    updateShortcut()

    // Shortcut
    $("#listSoal"+indexQuest).removeClass('btn-outline-dark');
    $("#listSoal"+indexQuest).addClass('btn-current');
    
    
    // Position
    currentQuest = indexQuest;
    return;
}

function loadQuesList() {
    var htmlSoal = "";
    for (let i = 0; i < lengthQuest; i++) {
        htmlSoal += '<div class="p-0 col-xl-2 col-auto mr-1 mb-1"><button name="shortcutSoal" id="listSoal'+i+'" type="button" name="btnList" onclick="goToIndex(' + i + ')" class="btn btn-outline-dark quiz-list">' + (i + 1) + '</button></div>'
    }
    questList.innerHTML = htmlSoal;
    // console.log(localStorage.getItem(`answered-${gelombang_id}-${user}-${paket_slug}`))

    $("#listSoal"+indexQuest).removeClass('btn-outline-dark');
    $("#listSoal"+indexQuest).addClass('btn-current');
}

function getChoice(currentQuest) {
    var choice = $("input:radio[name ='jawaban"+currentQuest+"']:checked").val();
    answerArr[currentQuest] = choice;
}

function goToIndex(index){
    localStorage.setItem(`indexQuest-${gelombang_id}-${user}-${paket_slug}`, index);
    getChoice(currentQuest);
    document.getElementById("question"+currentQuest).classList.remove('show');

    $("#listSoal"+currentQuest).removeClass('btn-current');
    $("#listSoal"+currentQuest).addClass('btn-outline-dark');

    indexQuest = index;
    // loadQuesList()
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

function updateShortcut(){
    Object.values(shortcutGroups).forEach(function(listSoalId){
       $("#listSoal"+listSoalId).addClass('btn-answered');
    })

    Object.values(markedGroups).forEach(function(listSoalId){
        $("#listSoal"+listSoalId).addClass('btn-marked');
     })
 }

 function updateMarked(index){
    if(markedGroups[index] != null){
        $("#btn-marked").addClass('text-dark');
        $("#btn-marked").html('<i class="fa fa-bookmark"></i> Hapus Tanda');
    }else{
        $("#btn-marked").removeClass('text-dark');
        $("#btn-marked").html('<i class="fa fa-bookmark"></i> Tandai');
    }
 }

 $(document).ready(function() {
    loadQuesList();
    loadQuest(indexQuest);
    
 })

