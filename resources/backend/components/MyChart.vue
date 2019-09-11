<template>
    <bar-chart v-if="chartData && chartData.datasets.length > 0" :chart-data="chartData"></bar-chart>
</template>

<script>
    import BarChart from './BarChart.js'
    export default {
        components:{
            BarChart
        },
        props: ["result", "label"],
        data() {
            return {
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
            };
        },
        methods: {
            initData() {
                this.result.forEach((v, i) => {
                    this.chartData.labels.push(v.label);
                    this.chartData.datasets[0].data.push(v.value);
                });
            }
        },
        created() {
            this.chartData.datasets[0].backgroundColor = this.colors;
            this.chartData.datasets[0].borderColor = this.colors;
            this.initData();
        }
    };
</script>
