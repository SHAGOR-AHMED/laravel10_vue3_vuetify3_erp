<script>
  // Pie, Doughnut, Line, Bar, PolarArea, Radar
  
  import { Radar } from "vue-chartjs";
  
  export default {
    
    props: ["chartData"],
  
    extends: Radar,

    data() {
      return {

        datacollection: {
          labels: this.chartData.labels,
  
          datasets: [
            {
              label: "Total",
              fill: false,
              //backgroundColor: ['#f87979', 'green'],
              backgroundColor: this.randColors(this.chartData.labels.length),
              pointBackgroundColor: "red",
              borderWidth: 5,
              pointBorderColor: "green",

              pointStyle: 'circle',
              pointRadius: 10,
              pointHoverRadius: 15,

              borderColor: 'pink',
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
                  min: 0,
                  max: Math.max(...this.chartData.data),
                  stepSize: 1,
                  reverse: false,
                  beginAtZero: true
                },
                gridLines: {
                  display: true,
                },
              },
            ],
            xAxes: [
              {
                ticks:{
                  maxRotation: 30,
                  minRotation: 20,
                  fontStyle: "bold"
                },
                gridLines: {
                  display: true,
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