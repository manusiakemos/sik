<template>
    <div class="small">
        <bar-chart ref="barChart" v-if="show" :chart-data="chartData" :options="options"></bar-chart>
    </div>
</template>

<script>
    import BarChart from './BarChart.js'

    export default {
        props: ["result", "label"],
        components: {
            BarChart
        },
        data() {
            return {
                show: false,
                colors: [
                    "rgba(255, 99, 132, 1)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(75, 192, 192, 1)",
                    "rgba(153, 102, 255, 1)",
                    "rgba(255, 159, 64, 1)"
                ],
                chartData: {
                    labels: [],
                    datasets: [
                        {
                            label: this.label,
                            backgroundColor: [],
                            borderColor: [],
                            borderWidth: 1,
                            data: []
                        }
                    ]
                },
                options: {
                    plugins: {
                        // Change options for ALL labels of THIS CHART
                        datalabels: {
                            color: "#FFFFFF",
                            font: {
                                weight: "bold"
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true
                                }
                            }
                        ]
                    }
                }
            }
        },
        watch: {
            result: function (newValue, oldValue) {
                this.initData();
            },
        },
        created() {
            this.chartData.datasets[0].backgroundColor = this.colors;
            this.chartData.datasets[0].borderColor = this.colors;
        },
        mounted() {
            this.initData();
        },
        methods: {
            initData() {
                this.show = false;
                this.chartData.labels = [];
                this.chartData.datasets[0].data = [];

                if(this.result && this.result.length > 0){
                    this.result.forEach((v, i) => {
                        this.chartData.labels.push(v.label);
                        this.chartData.datasets[0].data.push(v.value);
                    });
                    this.show = true;
                    if(this.$refs.barChart){
                        this.$refs.barChart.$data._chart.update();
                    }
                }
            },
        }
    }
</script>
