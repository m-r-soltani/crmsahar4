/* ------------------------------------------------------------------------------
 *
 *  # D3.js - bar chart with tooltip
 *
 *  Demo d3.js bar chart setup with tooltip and .tsv data source
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var D3BarTooltip = function() {


    //
    // Setup module components
    //

    // Chart
    var _barTooltip = function() {
        if (typeof d3 == 'undefined') {
            console.warn('Warning - d3.min.js is not loaded.');
            return;
        }

        // Main variables
        var element = document.getElementById('d3-bar-tooltip'),
            height = 400;


        // Initialize chart only if element exsists in the DOM
        if(element) {

            // Basic setup
            // ------------------------------

            // Define main variables
            var d3Container = d3.select(element),
                margin = {top: 5, right: 10, bottom: 20, left: 40},
                width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right,
                height = height - margin.top - margin.bottom - 5;



            // Construct scales
            // ------------------------------

            // Horizontal
            var x = d3.scale.ordinal()
                .rangeRoundBands([0, width], .1, .5);

            // Vertical
            var y = d3.scale.linear()
                .range([height, 0]);

            // Color
            var color = d3.scale.category20c();



            // Create axes
            // ------------------------------

            // Horizontal
            var xAxis = d3.svg.axis()
                .scale(x)
                .orient("bottom");

            // Vertical
            var yAxis = d3.svg.axis()
                .scale(y)
                .orient("left")
                .ticks(10, "%");



            // Create chart
            // ------------------------------

            // Add SVG element
            var container = d3Container.append("svg");

            // Add SVG group
            var svg = container
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
                .append("g")
                    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");



            // Create tooltip
            // ------------------------------

            // Create tooltip
            var tip = d3.tip()
                .attr('class', 'd3-tip')
                .offset([-10, 0])
                .html(function(d) {
                    return d.frequency;
                });

            // Initialize tooltip
            svg.call(tip);



            // Load data
            // ------------------------------

            d3.tsv("global_assets/demo_data/d3/bars/bars_tooltip.tsv", function(error, data) {

                // Pull out values
                data.forEach(function(d) {
                    d.frequency = +d.frequency;
                });


                // Set input domains
                // ------------------------------

                // Horizontal
                x.domain(data.map(function(d) { return d.letter; }));

                // Vertical
                y.domain([0, d3.max(data, function(d) { return d.frequency; })]);


                //
                // Append chart elements
                //

                // Append axes
                // ------------------------------

                // Horizontal
                svg.append("g")
                    .attr("class", "d3-axis d3-axis-horizontal d3-axis-strong")
                    .attr("transform", "translate(0," + height + ")")
                    .call(xAxis);

                // Vertical
                var verticalAxis = svg.append("g")
                    .attr("class", "d3-axis d3-axis-vertical d3-axis-strong")
                    .call(yAxis);

                // Add text label
                verticalAxis.append("text")
                    .attr("transform", "rotate(-90)")
                    .attr("y", 10)
                    .attr("dy", ".71em")
                    .style("text-anchor", "end")
                    .style("fill", "#999")
                    .style("font-size", 12)
                    .text("Frequency");


                // Append bars
                svg.selectAll(".d3-bar")
                    .data(data)
                    .enter()
                    .append("rect")
                        .attr("class", "d3-bar")
                        .style("fill", function(d) { return color(d.letter); })
                        .attr("x", function(d) { return x(d.letter); })
                        .attr("width", x.rangeBand())
                        .attr("y", function(d) { return y(d.frequency); })
                        .attr("height", function(d) { return height - y(d.frequency); })
                        .on('mouseover', tip.attr('class', 'tooltip-inner in').show)
                        .on('mouseout', tip.hide);
            });



            // Resize chart
            // ------------------------------

            // Call function on window resize
            $(window).on('resize', resize);

            // Call function on sidebar width change
            $('.sidebar-control').on('click', resize);

            // Resize function
            // 
            // Since D3 doesn't support SVG resize by default,
            // we need to manually specify parts of the graph that need to 
            // be updated on window resize
            function resize() {

                // Layout variables
                width = d3Container.node().getBoundingClientRect().width - margin.left - margin.right;


                // Layout
                // -------------------------

                // Main svg width
                container.attr("width", width + margin.left + margin.right);

                // Width of appended group
                svg.attr("width", width + margin.left + margin.right);


                // Axes
                // -------------------------

                // Horizontal range
                x.rangeRoundBands([0, width], .1, .5);

                // Horizontal axis
                svg.selectAll('.d3-axis-horizontal').call(xAxis);


                // Chart elements
                // -------------------------

                // Bars
                svg.selectAll('.d3-bar').attr("x", function(d) { return x(d.letter); }).attr("width", x.rangeBand());
            }
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _barTooltip();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    D3BarTooltip.init();
});
