<template>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 heading">
                <h4>{{ $t('general.sales.greet') }}</h4>
                <p>{{ $t('general.sales.tagline') }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-inline">
                    <input type="date" name="from" v-model="filter.start" class="form-control mr-2"/>
                    <input type="date" name="to" v-model="filter.end" :max="filter.end" class="form-control mr-2"/>
                    <button class="btn btn-primary" v-on:click="getReport()">Filter</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <Bar
                    :chart-options="chartOptions"
                    :chart-data="chartData"
                    :chart-id="chartId"
                    :dataset-id-key="datasetIdKey"
                    :plugins="plugins"
                    :css-classes="cssClasses"
                    :styles="styles"
                    :width="width"
                    :height="height"
                    />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <table class="table">
                    <tr>
                        <td>{{ $t('general.sales.order_per_period') }}:</td>
                        <td>{{ $t('general.sales.count_orders',{ count : totalOrders }) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
  </template>

  <script>
  import { Bar } from 'vue-chartjs/legacy'

  import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
  } from 'chart.js'

  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

  export default {
    name: 'BarChart',
    components: {
      Bar
    },
    props: {
      chartId: {
        type: String,
        default: 'bar-chart'
      },
      datasetIdKey: {
        type: String,
        default: 'label'
      },
      width: {
        type: Number,
        default: 400
      },
      height: {
        type: Number,
        default: 400
      },
      cssClasses: {
        default: '',
        type: String
      },
      styles: {
        type: Object,
        default: () => {}
      },
      plugins: {
        type: Array,
        default: () => []
      }
    },
    data() {
      return {
        filter:{
            start : null,
            end: null
        },
        chartData: {
          labels: [],
          datasets: [
            {
              label: this.$t('general.sales.orders'),
              backgroundColor: '#f87979',
              data: []
            }
          ]
        },
        chartOptions: {
          responsive: true,
          maintainAspectRatio: false
        },
        locale: 'en'
      }
    },
    mounted(){
        var d= new Date();
        d.setDate(d.getDate() - 7);
        this.filter.start = d.toJSON().slice(0,10).replace(/-/g,'-');
        this.filter.end = new Date().toJSON().slice(0,10).replace(/-/g,'-');

        this.getReport();
    },
    methods : {
        getReport : function(){
            axios.get('/reports/get',{
                params : {
                    start : this.filter.start,
                    end : this.filter.end
                }
            }).then((response) => {
                this.chartData.datasets[0].data = response.data.data.orders;
                this.chartData.labels = response.data.data.days;
            });
        }
    },
    computed : {
        totalOrders : function (){
            return eval(this.chartData.datasets[0].data.join('+'));
        }
    }
  }
  </script>
