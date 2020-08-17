function getGraph(){
    currentParity = $("#parity").val();
    drawGraph(currentParity);
}

function drawGraph(pair) {

    $.ajax({
        url: 'graphdata.php?pair=' + pair,
        success: function(response) {
            drawChart(pair,response);
        }
    });
}

function drawChart(pair,response) {

    
    response = JSON.parse(response);

    if (typeof(k) !== 'undefined') {
        k = undefined;
    }
    response.forEach( element => myPoints = dataPointWriter(element));
    
    if (typeof(chart) === 'undefined') {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: pair
            },
            data: [{
                type: "line",
                indexLabelFontSize: 16,
                dataPoints: myPoints
            }]
        });
        
        chart.render();
    }

    else {

        chart.destroy();
        chart = null; //Memory errors happen
        chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: pair
            },
            data: [{
                type: "line",
                indexLabelFontSize: 16,
                dataPoints: myPoints
            }]
        });
        
        chart.render();
    
    }


}

function dataPointWriter(element) {
    if (typeof(k) === 'undefined') {
        k = new Array();
    }

    position = parseFloat(element.totalBuy);
    k.push({y : position});
    return k;
}