chartColors = [
    'rgb(255, 99, 132)',
    'rgb(255, 159, 64)',
    'rgb(255, 205, 86)',
    'rgb(75, 192, 192)',
    'rgb(54, 162, 235)',
    'rgb(153, 102, 255)',
    'rgb(201, 203, 207)',
    'rgb(0, 238, 255)',
    'rgb(234, 98, 183)',
    'rgb(234, 100, 98)',
    'rgb(164, 234, 98)',
    'rgb(234, 98, 164)',
    'rgb(234, 121, 98)'
];
chartColorsVS = [
    'rgb(40, 167, 69)',
    'rgb(220, 53, 69)'
];

function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

function makeChart(el) {
    loader(true);
    console.log("Make Chart");
    var id = $(el).attr('id');
    var type = $(el).attr('data-chart');
    var dataid = $(el).attr('data-id');
    var dt = $(el).attr('data-date');
    console.log(" - Element: "+ id);
    console.log(" - Type: "+type);
    var url = "ajax/charts/" + $(el).attr('data-name');
    if(dataid !== undefined) {
        console.log(" - Data ID: "+dataid);
        url = url + "/" + dataid;
    }
    if(dt !== undefined){
        console.log(" - Date: "+dt);
        url = url + "/" + dt;
    }
    $.ajax({
        url: url,
        method: 'GET',
        success: function(datas,status){
            chart = new Chart(
                document.getElementById(id),
                {
                    type: type,
                    data: {
                        labels: datas.labels,
                        datasets: [{
                            data: datas.datas,
                            backgroundColor: chartColors
                        }]
                    }
                }
            )
            loader(false);
        }
    })
}

function loadPlayerStats(id){
    console.log("Load Player Stats...");
    console.log(" - Player ID: "+ id);
    loader(true,true);
    window.location.hash = id;
    $.get("/views/stats/"+id,function(d){
        $(".players-stats").html(d);
        postLoad();
    });
}

function loadVersusStats(id1,id2){
    console.log("Load Versus Stats...");
    console.log(" - Player1 ID: "+ id1);
    console.log(" - Player2 ID: "+ id2);
    loader(true,true);
    window.location.hash = id1+"-"+id2;
    $.get("/views/vs/"+id1+"/"+id2,function(d){
        $(".versus-stats").html(d);
        postLoad();
    });
}

function loadHome(){
    console.log("Load Home Stats...");
    loader(true,true);
    $.get("/views/home",function(d){
        $(".home-stats").html(d);
        postLoad();
    });
}

function loadGamesList(dt,id){
    console.log("Load Games List...");
    console.log(" - Date: "+ dt);
    loader(true);
    $.get("/views/games/"+dt,function(d){
        $(".games-list").html(d);
        if(id !== undefined){
            $(".btn-gamescores").removeClass("active");
            $(".btn-gamescores[data-id="+id+"]").addClass("active");
        }
        postLoad(false);
    });
}

function loadGameStats(dt){
    console.log("Load Game Stats...");
    console.log(" - Date: "+dt);
    loader(true,true);
    $.get("/views/gamestats/"+dt,function(d){
        $(".games-scores").html(d);
        postLoad();
    });
}

function loadGameScores(id){
    console.log("Load Game Score...");
    console.log(" - GameID: "+id);
    loader(true,true);
    $.get("/views/gamescores/"+id,function(d){
        $(".games-scores").html(d);
        postLoad();
    });
}

function loader(status,overlay){
    if(overlay === undefined){
        overlay = false;
    }
    if(status){
        $(".loader").fadeIn(200);
        if(overlay){ $(".overlay").fadeIn(10); }
    }else{
        if($(".overlay").is(":visible")){ $(".overlay").fadeOut(10); }
        $(".loader").fadeOut(200);
    }
}

function postLoad(loaderstop) {
    $(".chart").each(function(){
        console.log("Loaded Chart [" + $(this).attr('id') + "]");
        makeChart(this);
    });
    // Tooltips
    $('[data-toggle="tooltip"]').tooltip();
    if(loaderstop === undefined){ loaderstop = true; }
    if(loaderstop){
        loader(false);
    }
}

$(document).ready(function(){
    // Manage Anchors for dynamic loading
    href = window.location.href.split("/")
    console.log(href)
    if(href[href.length - 1]== ""){
        console.log("Home Page");
        loadHome();
    }
    if(href[href.length - 1].search("player") != -1 && window.location.hash.length > 1){
        console.log("Mode Player " + window.location.hash);
        $("#player_choose").val(window.location.hash.replace("#",""));
        loadPlayerStats(window.location.hash.replace("#",""))
    }
    if(href[href.length - 1].search("vs") != -1 && window.location.hash.length > 1){
        $("#player_choose").val(window.location.hash.replace("#",""));
        hash = window.location.hash.replace("#","").split("-");
        if(hash.length == 2){
            console.log("Mode VS " + window.location.hash);
            $("#player_choose1").val(hash[0]);
            $("#player_choose2").val(hash[1]);
            loadVersusStats(hash[0],hash[1]);
        }
    }
    if(href[href.length - 1].search("games") != -1 && window.location.hash.length > 1){
        hash = window.location.hash.replace("#","").split("-");
        if(hash.length == 1){
            date = hash[0].substr(0,4)+"-"+hash[0].substr(4,2)+"-"+hash[0].substr(6,2)
            $("#gamesdate").val(date);
            loadGamesList(date);
        }
        if(hash.length == 2){
            date = hash[0].substr(0,4)+"-"+hash[0].substr(4,2)+"-"+hash[0].substr(6,2)
            $("#gamesdate").val(date);
            loadGamesList(date,hash[1]);
            loadGameScores(hash[1]);
        }
    }

    // Tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Charts
    $(".chart").each(function(){
        console.log("Loaded Chart [" + $(this).attr('id') + "]");
        makeChart(this);
    });

    $(this)
        .on("change","#player_choose",function(e){
            loadPlayerStats($(this).val());
        })
        .on("change","#player_choose1",function(e){
            id1 = $(this).val();
            $("#player_choose2 > option").removeAttr("disabled");
            if(id1 != "0"){
                $("#player_choose2 > option[value="+id1+"]").attr("disabled","disabled");
                id2 = $("#player_choose2").val();
                if(id2 != "0"){
                    loadVersusStats(id1,id2);
                }
            }
        })
        .on("change","#player_choose2",function(e){
            id2 = $(this).val();
            $("#player_choose1 > option").removeAttr("disabled");
            if(id2 != "0"){
                $("#player_choose1 > option[value="+id2+"]").attr("disabled","disabled");
                id1 = $("#player_choose1").val();
                if(id1 != "0"){
                    loadVersusStats(id1,id2);
                }
            }
        })
        .on("change","#gamesdate",function(e){
            var dt = $(this).val();
            if(dt != "0"){
                loadGamesList(dt);
                loadGameStats(dt);
            }else{
                $(".games-scores").html("");
                $(".games-list").html("");
            }
        })
        .on("click",".btn-gamescores",function(e){
            var id = $(this).attr('data-id');
            $(".btn-gamescores").removeClass("active");
            $(this).addClass("active");
            if(id == "global"){
                loadGameStats($(this).attr('data-date'));
            }else {
                loadGameScores(id);
            }
        })
});