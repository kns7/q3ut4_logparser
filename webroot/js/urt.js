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

function getRandomColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

function makeChart(el) {
    console.log("Make Chart");
    var url  = "ajax/charts/"+ $(el).attr('data-name');
    var id = $(el).attr('id');
    var type = $(el).attr('data-chart');
    console.log(" - Element: "+ id);
    console.log(" - Type: "+type);
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
        }
    })
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
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();

    $(".chart").each(function(){
        console.log("Loaded Chart [" + $(this).attr('id') + "]");
        makeChart(this);
    })
});