<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://d3js.org/d3.v4.js"></script>
<script src="https://cdn.jsdelivr.net/gh/holtzy/D3-graph-gallery@master/LIB/d3.layout.cloud.js"></script>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 80%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>

<body>
    <input type="submit" id="gather_tweets" name="Obtener tweets" value="Obtener tweets" />
    <input type="submit" id="show_tweets" name="Enseñar tweets" value="Enseñar tweets" />
    <input type="submit" id="show_chart_number_tweets" name="Gráfica número tweets" value="Gráfica número tweets" />
    <input type="submit" id="show_chart_tweets_length_distribution" name="Gráfica distribución longitud" value="Gráfica distribución longitud" />
    <input type="submit" id="show_word_cloud" name="Enseñar nube de palabras" value="Enseñar nube de palabras" />
    
    <div id="world_cloud"></div>
    <canvas id="chart_number_tweets"></canvas>
    <canvas id="chart_tweets_length_distribution"></canvas>
    <div id='tweets_table'></div>
</body>
<script>
//AJAX functions that detect the click on a button and call the corresponding PHP file to perform an action.
    $(document).ready(function(){
        $('input[id="gather_tweets"]').click(function(){
           $.ajax({
                cache: false,
                url: 'gather_tweets.php',
                type: "POST",
                data: {'hashtag': 'farina'} ,
                success: function (response) {
                    alert(response);
                },
                error: function (r) {
                    alert('Error! ' + r.responseText);
                   console.log(r);    
                }
            }); 
        });
    });

    $(document).ready(function(){
        $('input[id="show_tweets"]').click(function(){
           $.ajax({
                cache: false,
                url: 'show_tweets.php',
                type: "POST",
                data: {'hashtag': 'farina'} ,
                success: function (response) {
                    if (response.length > 0) {
                       var tweets = JSON.parse(response);
                       //Inicio de la tabla
                       var tweets_tabla = '<table><tr> <th>Date</th> <th>Username</th> <th>Tweet</th> </tr>';
                       //Contenido de la tabla
                       for (var i in tweets){
                            tweets_tabla = tweets_tabla + '<tr><td>' + tweets[i]['date'] + '</td><td>' + tweets[i]['text'] + '</td><td>' + tweets[i]['username'] + '</td></tr>';  
                       }
                       //Fin de la tabla
                       tweets_tabla = tweets_tabla + '</table>';
                       console.log(tweets_tabla);
                       document.getElementById("tweets_table").innerHTML = tweets_tabla;
                    }
                    else {
                        console.log("NO HAY TWEETS")
                    }
                },
                error: function (r) {
                    alert('Error! ' + r.responseText);
                   console.log(r);    
                }
            }); 
        });
    });

    $(document).ready(function(){
        $('input[id="show_chart_number_tweets"]').click(function(){
           $.ajax({
                cache: false,
                url: 'info_graph_n_tweets.php',
                type: "POST",
                success: function (response) {
                    if (response.length > 0) {
                       var contador = JSON.parse(response);
                       console.log(contador);
                       dates = []
                       contadores = []
                       for (var i in contador){
                           dates.push(contador[i]['date']);
                           contadores.push(contador[i]['counter']);
                       }
                       console.log(dates);
                       console.log(contadores);
                       grafica_n_tweets(dates,contadores);
                    }
                    else{
                        console.log("ERROR, tweets no encontrados");
                    }
                },
                error: function (r) {
                    alert('Error! ' + r.responseText);
                   console.log(r);    
                }
            }); 
        });
    });

    $(document).ready(function(){
        $('input[id="show_chart_tweets_length_distribution"]').click(function(){
           $.ajax({
                cache: false,
                url: 'tweets_length_distribution.php',
                type: "POST",
                success: function (response) {
                    if (response.length > 0) {
                       var distribucion = JSON.parse(response);
                       console.log(distribucion);
                       longitud = []
                       contadores = []
                       for (var i in distribucion){
                           longitud.push(distribucion[i]['longitud']);
                           contadores.push(distribucion[i]['cantidad']);
                       }
                       console.log(longitud);
                       console.log(contadores);
                       grafica_n_tweets(longitud,contadores);
                    }
                    else{
                        console.log("ERROR, tweets no encontrados");
                    }
                },
                error: function (r) {
                    alert('Error! ' + r.responseText);
                   console.log(r);    
                }
            }); 
        });
    });
   
    $(document).ready(function(){
        $('input[id="show_word_cloud"]').click(function(){
           $.ajax({
                cache: false,
                url: 'word_cloud.php',
                type: "POST",
                success: function (response) {
                    if (response.length > 0) {
                       var nube = JSON.parse(response);
                       console.log(nube);
                       grafica_cloud_words(nube);
                    }
                    else{
                        console.log("ERROR, tweets no encontrados");
                    }
                },
                error: function (r) {
                    alert('Error! ' + r.responseText);
                   console.log(r);    
                }
            }); 
        });
    });


//Functions to show the different graphs
    function grafica_length_distribution(dates,contadores){    
        var ctx = document.getElementById('chart_number_tweets').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Tweets per day',
                    data: contadores
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }
    function grafica_n_tweets(longitud,contadores){    
        var ctx = document.getElementById('chart_tweets_length_distribution').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [{
                    label: 'Distribución longitud tweets',
                    data: contadores
                }],
                labels: longitud,
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 5
                        }
                    }]
                }
            }
        });
    }
    
    function grafica_cloud_words(nube){    
        var myWords = nube;

        // set the dimensions and margins of the graph
        var margin = {top: 10, right: 10, bottom: 10, left: 10},
            width = 450 - margin.left - margin.right,
            height = 450 - margin.top - margin.bottom;

        // append the svg object to the body of the page
        var svg = d3.select("#world_cloud").append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
          .append("g")
            .attr("transform",
                  "translate(" + margin.left + "," + margin.top + ")");

        // Constructs a new cloud layout instance. It run an algorithm to find the position of words that suits your requirements
        // Wordcloud features that are different from one word to the other must be here
        var layout = d3.layout.cloud()
          .size([width, height])
          .words(myWords.map(function(d) { return {text: d.word, size:d.size}; }))
          .padding(5)        //space between words
          .rotate(function() { return ~~(Math.random() * 2) * 90; })
          .fontSize(function(d) { return d.size; })      // font size of words
          .on("end", draw);
        layout.start();

        // This function takes the output of 'layout' above and draw the words
        // Wordcloud features that are THE SAME from one word to the other can be here
        function draw(words) {
          svg
            .append("g")
              .attr("transform", "translate(" + layout.size()[0] / 2 + "," + layout.size()[1] / 2 + ")")
              .selectAll("text")
                .data(words)
              .enter().append("text")
                .style("font-size", function(d) { return d.size; })
                .style("fill", "#69b3a2")
                .attr("text-anchor", "middle")
                .style("font-family", "Impact")
                .attr("transform", function(d) {
                  return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
                })
                .text(function(d) { return d.text; });
        }
    }
</script>
