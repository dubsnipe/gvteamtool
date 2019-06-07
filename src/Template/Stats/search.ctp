<!-- File: src/Template/Stats/search.ctp -->

<?php use Cake\Routing\Router; ?>

<!-- <div id="map"></div> -->

<div class="container">

    
    <?php
    if ($queryParams){
        $dateAfter = ( array_key_exists('arrivalAfter', $queryParams) ?  $queryParams['arrivalAfter'] : '—' );
        $dateBefore = ( array_key_exists('arrivalBefore', $queryParams) ? $queryParams['arrivalBefore'] : '—' );
        $text = '<h1>Results: refined</h1><h2>Period: ' . $dateAfter . ' to ' . $dateBefore . '</h2>'; 
    } else{
        $text = '<h1>Results: all teams</h1>'; 
    }
    echo $text;
    ?>
    
    <h2>Refine search</h2>
    <div class="section white z-depth-1 container-2">
        <div class="search-control row">
            <form role="search">
                <div class="col s3 m12">
                        Arriving after
                        <input type="date" id="arrivalAfter" name="arrivalAfter" label="Arrival after">
                    </div>
                <div class="col s3 m12">
                    Arriving before
                    <input type="date" id="arrivalBefore" name="arrivalBefore" label="Arrival before">
                </div>
                <div class="col s3 m12">
                    Team Type
                    <input type="text" id="team_type" name="team_type" label="Team Type", placeholder="Team type, e.g. Affiliate">
                </div>
                <div class="center-align col s3">
                        <?php echo $this->Form->button(__('Search'), ['class' => 'btn waves-effect waves-light habitat-blue z-depth-0']);?>
                </div>
            </form>
        </div>
        
    </div>

    <h1>Teams</h1>  
    
    <div class="row white z-depth-1 container-2">
        <div class="col s6 m12 center-align">
            <h2>Teams cancelled: <?php echo $teamSumCancelled; ?></h2>
        </div>
        <div class="col s6 m12 center-align">
            <h2>Average team size: <?php echo round($queryMembers, 1); ?></h2>
        </div>
    </div>
    
    <h2>Total by region</h2>

        <div class="container-2 col s12 l6">
            <table class="highlight summary white z-depth-1">
                <tr>
                    <th>Region</th>
                    <th>Teams</th>
                    <th>Volunteers</th>
                    <th>Hours</th>
                    <th>Days</th>
                </tr>
                <?php foreach($summary as $month=>$total){
                    echo '<tr><td>'.$month.'</td><td>' . $total[0] . '</td><td>' . $total[1] . '</td><td>' . $total[1]*40 . '</td><td>' . $total[1]*5 . '</td></tr>';
                } ?>

                <tr class="habitat-blue white-text">
                    <td>Total</td>
                    <td><?php echo $teamSum; ?></td>
                    <td><?php echo $volSum; ?></td>
                    <td><?php echo $volSum*40; ?></td>
                    <td><?php echo $volSum*5; ?></td>
                </tr>
            </table>
        </div>
        <div class="container-2 col s12 white z-depth-1">
            <svg class="chart2"></svg>
        </div>
    
    
    <h2>Teams by type</h2>
    <!-- Type -->
    <div class="container-2 col s12 l6">
        <!-- Type -->
        <table class="highlight summary white z-depth-1">
            <tr>
                <th>Tipo</th>
                <th>Total</th>
            </tr>
            <?php foreach($queryType as $key => $q){
                if ($key == null||$key === null){
                    $q->team_type = 'N/A';
                };
                echo '<tr><td>' . $q->team_type . '</td><td>' . $q->total . '</td></tr>';
            } ?>
        </table>
    </div>
    <div class="container-2 col s12 white z-depth-1">
        <div id="byType"></div>
    </div>

    
    <h1>Volunteers</h1>
    
    <h2>Teams by gender</h2>
    <!-- Gender -->
    <div class="container-2">
        <table class="highlight summary white z-depth-1">
            <tr>
                <th>Male</th>
                <th>Female</th>
            </tr>
            <tr class="">
                <td><?php echo $queryMale; ?></td>
                <td><?php echo $queryFemale; ?></td>
            </tr>
            <tr class="habitat-blue white-text">
                <?php 
                    if ($queryMale+$queryFemale <= 0){
                        echo "<td>" . "0" . "%</td>"; 
                        echo "<td>" . "0" . "%</td>"; 
                    } else{
                        echo "<td>" .(int)($queryMale/($queryMale+$queryFemale)*100+0.5) . "%</td>"; 
                        echo "<td>" .(int)($queryFemale/($queryMale+$queryFemale)*100+0.5) . "%</td>"; 
                    }
                ?>
            </tr>
        </table>
    </div>
    
    <div class="container-2 white z-depth-1">
        <div id="gender" class="row "></div>
    </div>
    
    <h2>Volunteers by state</h2>
    <!-- Type -->
    <div class="container-2">
            <!-- Type -->
            <table class="highlight summary white z-depth-1">
                    <tr>
                        <th>#</th>
                        <th>State</th>
                        <th>Total</th>
                        <th>%</th>
                    </tr>
                    
                    <?php 
                    $i = 0;
                    $total = 0;
                    foreach ($queryState as $q){
                        $total += $q->total;
                    }
                    $total += 0.00000001;
                    foreach($queryState as $key => $q){
                        if ($q->_matchingData['Voluntarios']['state'] == ''){
                            $q->_matchingData['Voluntarios']['state'] = 'N/A';
                        };
                        $keyIndex = $key+1;
                        echo '<tr>
                            <th>' . $keyIndex . '</th>
                            <th>' . $q->_matchingData['Voluntarios']['state'] . '</th>
                            <td>' . $q->total . '</td><td class="habitat-blue white-text right-align">' . 100*round($q->total/$total,2) . '%' . '</td>
                        </tr>';
                        if (++$i == 10) break;
                    } ?>
            </table>
    </div>
    <div class="container-2 white z-depth-1">
        <div id="byState"></div>
    </div>
    
    
    <!-- <div class="row center-align">
    <?php echo $this->Html->link('Download results', [
                                'controller' => 'Stats', 
                                'action' => 'export', 
                                '_full' => true, 
                                '?' => $queryParams
                                ], 
                                        ['class' => 
                                            'waves-effect waves-light btn habitat-blue z-depth-0'
                                            ]);?>
    
    </div> -->

    <!-- <div id="chart1" class="row container">
        <?php 
        $data1 = array_keys($monthVolSummary); 
        $data2 = array_values($monthVolSummary); 
        ?>
        <div class="center-align col s12">
            <canvas id="myChart" class="center-align" width="80%" height="30"></canvas> 
            <div></div>
    </div> -->
    
    
    
    <div class="row">
        <div class="center-align col s12">
            <canvas id="myChart2" class="center-align"></canvas>
        </div>
    </div>


</div>

<?php

echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.10/d3.js', ['block' => 'script']); 
echo $this->Html->script('https://d3js.org/d3-color.v1.min.js', ['block' => 'script']); 
echo $this->Html->script('https://d3js.org/d3-interpolate.v1.min.js', ['block' => 'script']); 
echo $this->Html->script('https://d3js.org/d3-scale-chromatic.v1.min.js', ['block' => 'script']); 
echo $this->Html->script('https://d3js.org/d3-axis.v1.min.js', ['block' => 'script']); 
echo $this->Html->script('https://d3js.org/d3-queue.v3.min.js', ['block' => 'script']); 

echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/topojson/3.0.2/topojson.js', ['block' => 'script']);

// https://bl.ocks.org/almccon/410b4eb5cad61402c354afba67a878b8
?>


<?php $this->Html->scriptStart(['block' => 'bottomScript']); ?>


<?php $this->Html->scriptEnd(); ?>


<?php $this->Html->scriptStart(['block' => 'bottomScript']); ?>
// Pie chart by gender
var data = [
    {type: "Male", total: <?php echo $queryMale; ?>},
    {type: "Female", total: <?php echo $queryFemale; ?>},
];

var margin2 = {top: 60, right: 60, bottom: 60, left: 60},

width = (window.innerWidth * 0.45) - margin2.left - margin2.right,
height = width;

// var width = 600,
    // height = 600;
    
var svgPie = d3.select("#gender").append("svg")
  .attr("width", width)
  .attr("height", height)
    .attr('viewBox','0 0 ' + Math.max(width,height) + ' ' + Math.max(width,height))
    .attr('preserveAspectRatio','xMinYMin'),
    radius = Math.min(width, height) / 2.5,
    g = svgPie.append("g").attr("transform", "translate(" + (width/2+margin2.right) + "," + height/2 + ")");

var color = d3.scale.ordinal().range(["#A32900", "#007CA4"]);

var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) { return d.total; });

var pathPie = d3.svg.arc()
    .outerRadius(radius - 10)
    .innerRadius(0);

var label = d3.svg.arc()
    .outerRadius(radius - 40)
    .innerRadius(radius - 40);


// d3.csv("data.csv", function(d) {
  // d.population = +d.population;
  // return d;
// }, function(error, data) {
  // if (error) throw error;
  
// data[total] = <?php echo $queryMale; ?> + <?php echo $queryFemale; ?>;

  // d.total = +d.total;
  
  var arc = g.selectAll(".arc")
    .data(pie(data))
    .enter().append("g")
      .attr("class", "arc");

  arc.append("path")
      .attr("d", pathPie)
      .attr("fill", function(d) { return color(d.data.type); });
      
    arc.append("text")
      .attr("transform", function(d) { return "translate(" + label.centroid(d) + ")"; })
      // .attr("dy", "0.5em")
      .text(function(d) { return d.data.type; })
      .style("fill", "white")
      .style("font-size", "12px")
      .style("text-anchor", "middle");

<?php $this->Html->scriptEnd(); ?>


<?php $this->Html->scriptStart(['block' => 'bottomScript']); ?>
// Pie chart by type

var dataType = <?php echo json_encode($queryType); ?>;

var widthType = 800,
    heightType = 700;
    
var svgType = d3.select("#byType").append("svg")
  .attr("width", widthType)
  .attr("height", heightType),
    radius = (Math.min(widthType, heightType) / 2) - 150,
    heightType2 = heightType + 50
    g = svgType.append("g").attr("transform", "translate(" + widthType / 3 + "," + heightType2 / 2 + ")");

// https://stackoverflow.com/questions/12217121/continuous-color-scale-from-discrete-domain-of-strings
var categories = dataType.map(a => a.team_type);
var colorType = d3.scale.ordinal()
    .domain(categories)
    .range(d3.range(categories.length).map(d3.scale.linear()
      .domain([0, categories.length - 1])
      .range(["#A32900", "#007CA4"])
      .interpolate(d3.interpolateHclLong)));

var pieType = d3.layout.pie()
    .sort(null)
    .value(function(d) { return d.total; });

var pathType = d3.svg.arc()
    .outerRadius(radius - 10)
    .innerRadius(0);

var labelType = d3.svg.arc()
    .outerRadius(radius - 40)
    .innerRadius(radius - 40);
  
var arcType = g.selectAll(".arc")
    .data(pie(dataType))
    .enter().append("g")
      .attr("class", "arc");

arcType.append("path")
  .attr("d", pathType)
  .attr("fill", function(d) { return colorType(d.data.team_type); });

// Regular labels, without rotation
// arcType.append("text")
  // .attr("transform", function(d) { return "translate(" + labelType.centroid(d) + ")"; })
  // .attr("dy", "0.5em")
  // .text(function(d) { return d.data.team_type; });

pie(dataType).forEach(function(d, i) {
    [x, y] = labelType.centroid(d);
    let label = d.data.team_type;
    var rotation = d.endAngle-90 < Math.PI ? 
        (d.startAngle / 2 + d.endAngle / 2) * 180 / Math.PI :
        (d.startAngle / 2 + d.endAngle / 2 + Math.PI) * 180 / Math.PI;
    arcType.append("text")
      .attr("transform", function(d) { return "translate(" + labelType.centroid(d) + ")"; })
      .attr("transform", "translate(" + [1.4 * x, 1.4 * y] + ") rotate(-90) rotate(" + rotation + ")")
      .text(label)
      .style("text-anchor", "start")
}) 

<?php $this->Html->scriptEnd(); ?>


<?php $this->Html->scriptStart(['block' => 'bottomScript']); ?>
// https://bost.ocks.org/mike/bar/
var names = <?php echo json_encode($data1); ?>;
var data = <?php echo json_encode($data2); ?>;

var x = d3.scale.linear()
    .domain([0, d3.max(data)])
    .range([15, 420]);

d3.select("#chart1")
  .selectAll("div")
    .data(data)
  .enter().append("div")
    .style("width", function(d) { return x(d) + "px"; })
    .text(function(d) { return d; });
    
<?php $this->Html->scriptEnd(); ?>


<?php $this->Html->scriptStart(['block' => 'bottomScript']); ?>
//1.5
// https://bost.ocks.org/mike/bar/3

var margin = {top: 40, right: 60, bottom: 150, left: 80},

width = (window.innerWidth * 0.45) - margin.left - margin.right,
height = window.innerHeight > 700 ? window.innerHeight - margin.top - margin.bottom : 700;

var data = <?php echo json_encode($summary2); ?>;

var x = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);
    
var y = d3.scale.linear()
    .range([height, 0]);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left");

var chart = d3.select(".chart2")
    .attr("width", width)
    .attr("height", height)
    .attr("viewBox", "0 0 " + Math.max(width,height) + " " + Math.min(width,height))
    .attr('preserveAspectRatio','xMinYMin')
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
    
    
x.domain(data.map(function(d) { return d.region; }));
y.domain([0, d3.max(data, function(d) { return d.brigadas; })]);

chart.append("g")
    .attr("class", "x axis")
    .attr("transform", "translate(0," + height + ")")
    .call(xAxis)
  .selectAll("text")
    .attr("y", 0)
    .attr("x", 9)
    .attr("dy", ".35em")
    .attr("transform", "rotate(90)")
    .style("text-anchor", "start");


chart.append("g")
    .attr("class", "y axis")
    .call(yAxis)
  .append("text")
    .attr("x", 0)
    .attr("y", 0)
    .attr("dx", "-12em")
    .attr("dy", "-3.2em")
    .attr("transform", "rotate(-90)")
    .style("text-anchor", "end")
    .text("Number of teams");
  
  chart.selectAll(".bar")
      .data(data)
    .enter().append("rect")
      .attr("class", "bar")
      .attr("x", function(d) { return x(d.region); })
      .attr("y", function(d) { return y(d.brigadas); })
      .attr("height", function(d) { return height - y(d.brigadas); })
      .attr("width", x.rangeBand());
      
function type(d) {
  d.brigadas = +d.brigadas; // coerce to number
  return d;
}
<?php $this->Html->scriptEnd(); ?>


<?php $this->Html->scriptStart(['block' => 'bottomScript']); ?>
// US Map
// Inicio de segundo script 

// Map of El Salvador
var width = 860,
    height = 500;

// https://stackoverflow.com/questions/42906648/render-geojson-with-d3
// https://bost.ocks.org/mike/map/#installing-tools

/*
var projection = d3.geo.mercator()
    .center([-88.7036279,13.7493392])
    .scale(17000)
    .translate([width/2, height/2]);
*/

// http://bl.ocks.org/michellechandra/0b2ce4923dc9b5809922  
var margin = {top: 5, right: 5, bottom: 5, left: 5},

width = (window.innerWidth * 0.45) - margin.left - margin.right,
height = width/2 * 1.4;

var projection = d3.geo.albersUsa()
				   .translate([width/2, height/2])    // translate to center of screen
				   .scale([800]);          // scale things down so see entire US
                   
// console.log("projection", projection);
    
var path = d3.geo.path()
    .projection(projection);

    
// TEST

var svg = d3.select("#byState").append("svg")
    .attr("width", width)
    .attr("height", height)
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

// Administrative level 1 map shapes obtained at
// https://data.humdata.org/dataset/el-salvador-administrative-level-0-1-and-2-boundaries
// Converted with http://mapshaper.org/ and https://shancarter.github.io/distillery/

// var url = "http://localhost/projects/cakephp02/cakephp02/webroot/assets/us-states-2.json"
var url = "<?php echo $this->Url->build('/webroot/assets/us-states-2.json');?>"

var tooltip = d3.select("#byState").append("div") 
    .attr("class", "tooltip z-depth-2")       
    .style("opacity", 0);

// https://beta.observablehq.com/@mbostock/d3-choropleth
  
d3.json(url, function(error, topology) {
    if (error) throw error;
  
    // console.log("topojson", topology)
    var geojson = topojson.feature(topology, topology.objects.states);
    // console.log("geojson", geojson)

    var numbers = <?php echo json_encode($queryState); ?>;
    var states = [];
    var totals = [];
    for(var i=0; i<numbers.length; i++){
       var datum = {state: numbers[i]._matchingData.Voluntarios.state, total: numbers[i].total};
       totals.push(numbers[i].total);
       states.push(datum);
    }
    
    for(var i=0; i<geojson.features.length; i++){
       theState = geojson.features[i].properties.name;
       for(var j=0; j<states.length; j++){
           if(theState == states[j].state){
               geojson.features[i].properties.total = states[j].total;
           }
       }
    }
    
// https://stackoverflow.com/questions/12217121/continuous-color-scale-from-discrete-domain-of-strings

    var colorType = d3.scale.ordinal()
        .domain(totals)
        .range(d3.range(totals.length).map(d3.scale.linear()
          .domain([0, totals.length - 1])
          .range(["#00afd7", "#ffffff"])
          .interpolate(d3.interpolateHcl)));
    
    svg.selectAll("path")
        .data(geojson.features)
        .enter()
            .append("path")
            .attr("d", path)
            .attr("fill", function(d) { return colorType(d.properties.total); })
            .on("mouseover", function(d) {
            tooltip.transition()
                .duration(200)
                .style("opacity", .9);
                tooltip.html(d.properties.name + ": " + d.properties.total)
                .style("left", (d3.event.pageX) + "px")
                .style("top", (d3.event.pageY - 28) + "px");
            })
            .on("mouseout", function(d) {
                tooltip.transition()
                .duration(500)
                .style("opacity", 0);
            });
});
<?php $this->Html->scriptEnd(); ?>

<?php $this->Html->scriptStart(['block' => 'bottomScript']); ?>
// https://bost.ocks.org/mike/bar/
var names = <?php echo json_encode($data1); ?>;
var data = <?php echo json_encode($data2); ?>;

var x = d3.scale.linear()
    .domain([0, d3.max(data)])
    .range([15, 420]);

d3.select("#chart1")
  .selectAll("div")
    .data(data)
  .enter().append("div")
    .style("width", function(d) { return x(d) + "px"; })
    .text(function(d) { return d; });
    
<?php $this->Html->scriptEnd(); ?>
