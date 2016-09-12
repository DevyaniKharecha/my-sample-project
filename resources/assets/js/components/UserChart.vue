<template>

    <div class="form-group pull-left">
        <label for="type">chart type:</label>
        <select class="form-control" id="type" v-model="type" v-on:change="changeType">
            <option>line</option>
            <option>bar</option>

        </select>


        <label for="period" id="label">chart periods:</label>
        <select class="form-control" id="period" v-model="period" v-on:change="changePeriod">
            <option value="1year">1 year</option>
            <option value="3months">3 months</option>
            <option value="30days">30 days</option>
            <option value="1week">1 week</option>

        </select>

    </div>

    <canvas id="canvass"></canvas>

</template>

<script>

    var $myChart;



    export default {


        data: function(){

            return {
                labels: [],
                values1: [],
                values2: [],
                name: 'User',
                compare: 'Widget',
                type: 'line',
                period: '1year'
            };

        },

        ready: function () {

            this.loadData();

        },

        methods: {

            changeType: function () {

                this.setConfig();

            },

            loadData: function () {

                $.getJSON('api/user-chart', function (data) {

                    this.labels = data.data.labels;
                    this.values1 = data.data.values1;
                    this.values2 = data.data.values2;
                    this.setConfig();

                }.bind(this));

            },

            changePeriod: function () {

                $.getJSON('api/user-chart?period=' + this.period, function (data) {

                    this.labels = data.data.labels;
                    this.values1 = data.data.values1;
                    this.values2 = data.data.values2;
                    this.setConfig();

                }.bind(this));

            },

            setConfig : function () {

                var ctx = document.getElementById('canvass').getContext('2d');
                var config = {
                    type: this.type,
                    data: {
                        labels: this.labels,
                        datasets: [{
                            label: this.name,
                            data: this.values1,
                            fill: true,
                            borderDash: [5, 5]
                        },

                            {

                                label: this.compare,
                                data: this.values2,
                                fill: true


                            }


                        ]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'bottom'
                        },
                        hover: {
                            mode: 'label'
                        },
                        scales: {
                            xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: false,
                                    labelString: 'months'
                                }
                            }],
                            yAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: '# of ' + this.name
                                }
                            }]
                        },
                        title: {
                            display: true,
                            text: this.name
                        }
                    }
                };

                // destroy existing chart

                if (typeof $myChart !== "undefined") {
                    $myChart.destroy();
                }

                // set instance, so we can destroy when rendering new chart

                $myChart = new Chart( ctx, { type: this.type, data: config.data, options:config.options });
            }

        }


    }


</script>