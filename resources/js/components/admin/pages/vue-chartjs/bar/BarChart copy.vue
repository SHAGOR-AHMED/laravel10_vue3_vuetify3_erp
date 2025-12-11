<script>
    // Pie, Doughnut, Line, Bar, PolarArea
    
    import { Bar } from "vue-chartjs";
    
    export default {
      props: ["chartData"],
    
      extends: Bar,
      data() {
        return {
          datacollection: {
            labels: this.chartData.labels,
    
            datasets: [
              {
                label: "Total Content",
                //backgroundColor: ['#f87979', 'green'],
                backgroundColor: this.randColors(this.chartData.labels.length),
                pointBackgroundColor: "red",
                borderWidth: 1,
                pointBorderColor: "green",
                //data: [60, 40, 20, 50, 90, 10, 20, 40, 50, 70, 90, 100],
                data: this.chartData.data,
              },
            ],
          },
          options: {
            scales: {
              yAxes: [
                {
                  ticks: {
                    beginAtZero: true,
                  },
                  gridLines: {
                    display: true,
                  },
                },
              ],
              xAxes: [
                {
                  gridLines: {
                    display: true ,
                  },
                },
              ],
            },
            legend: {
              display: true,
            },
            responsive: true,
            maintainAspectRatio: false,
          },
        };
      },
    
      methods: {
        // random color generator
        randColors(val = 2) {
          // empty Array
          const colors = [];
          for (let i = 1; i <= val; i++) {
            let color = "#" + (Math.random().toString(16) + "0000000").slice(2, 8);
            // colors push in array
            colors.push(color);
          }
          return colors;
        },
      },
    
      mounted() {
        this.renderChart(this.datacollection, this.options);
      },
    };
</script>