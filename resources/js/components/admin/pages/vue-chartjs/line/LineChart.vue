<template>
  <div style="height:300px;">
    <Line :data="datacollection" :options="chartOptions" />
  </div>
</template>

<script>
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale,
} from "chart.js";

import { Line } from "vue-chartjs";

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale
);
  
export default {

    props: ["chartData"],
    components: { Line },
     
    data () {
        return {
            
            datacollection: {
              labels: this.chartData.labels,
              datasets: [
                {
                  label: 'Total Assigned',
                  borderColor: "#42A5F5",
                  backgroundColor: "rgba(66,165,245,0.3)",
                  fill: true,
                  data: this.chartData.data,
                  
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

