<template>
  <div style="height:300px;">
    <Doughnut :data="datacollection" :options="chartOptions" />
  </div>
</template>

<script>
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
} from "chart.js";

import { Doughnut } from "vue-chartjs";

ChartJS.register(Title, Tooltip, Legend, ArcElement);
  
export default {

    props: ["chartData"],
    components: { Doughnut },
     
    data () {
        return {
            
            datacollection: {
              labels: this.chartData.labels,
              datasets: [
                {
                  label: 'Total Assigned',
                  data: this.chartData.data,
                  backgroundColor: this.randColors(this.chartData.labels.length),
                }
              ]
            },

            chartOptions: {
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

