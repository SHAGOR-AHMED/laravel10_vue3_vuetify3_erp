<template>
    <div>
       <h2>All Vue Charts</h2>
        <v-card>
            <v-row>
                <v-col cols="12" lg="6" md="6">
                    <bar-chart v-if="barChartRender && allChartData" :chartData="allChartData" :key="barChartKey"></bar-chart>
                </v-col>

                 <v-col cols="12" lg="6" md="6">
                    <pie-chart v-if="pieChartRender && allChartData" :chartData="allChartData" :key="pieChartKey"></pie-chart>
                </v-col>

                <v-col cols="12" lg="6" md="6">
                    <doughnut-chart v-if="doughuntChartRender && allChartData" :chartData="allChartData" :key="doughunutChartKey"></doughnut-chart>
                </v-col>

                <v-col cols="12" lg="6" md="6">
                    <line-chart v-if="lineChartRender && allChartData" :chartData="allChartData" :key="lineChartKey"></line-chart>
                </v-col>
            </v-row>
        </v-card>
    </div>
</template>

<script>

import barChart from './vue-chartjs/bar/BarChart.vue'
import doughnutChart from './vue-chartjs/doughnut/DoughnutChart.vue'
import pieChart from './vue-chartjs/pie/PieChart.vue'
import lineChart from './vue-chartjs/line/LineChart.vue'

export default {

    components: { barChart, pieChart, doughnutChart, lineChart },
   
    data(){
        return{
            currentUrl: "/admin/user",
            chartData: {},
            allChartData:[],

            barChartKey: 1,
            barChartRender: false,

            doughunutChartKey: 1,
            doughuntChartRender: false,

            pieChartKey: 1,
            pieChartRender: false,

            lineChartKey: 1,
            lineChartRender : false,
        }
    },

    methods:{

        getContent(){

            axios.get(this.currentUrl + "/roleWiseUser").then(response => {

                this.allChartData = response.data.chart_data;
                console.log('Formated array = ', this.allChartData);

                this.barChartKey++;
                this.barChartRender = true;

                this.doughunutChartKey++;
                this.doughuntChartRender = true;

                this.pieChartKey++
                this.pieChartRender = true;

                this.lineChartRender = true
                this.lineChartKey++;

            }).catch(function(error){
                console.log(error);
            })

        },

    },

  created(){
    this.getContent()
  },


}

</script>