<template>
  <div style="height:300px;">
    <Bar :data="datacollection" :options="chartOptions" />
  </div>
</template>

<script>
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js'

import { Bar } from 'vue-chartjs'

// Register chart.js components
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
  
export default {

    props: ["chartData"],
    components: { Bar },
     
    data () {
        return {
            
            datacollection: {
              labels: this.chartData.labels,
              datasets: [
                {
                  label: 'Total Assigned',
                  data: this.chartData.data,
                  backgroundColor: this.randColors(this.chartData.labels.length),
                  pointBackgroundColor: "red",
                  borderWidth: 1,
                  pointBorderColor: "green",
                }
              ]
            },

            chartOptions: {
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
              maintainAspectRatio: false
            },

        }
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
  
    mounted(){
  
    }

  }
</script>