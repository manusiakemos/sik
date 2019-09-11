<template>
   <div id="select-pegawai-componenent">
       <div class="card card-primary">
           <div class="card-body">
               <div class="card-header">
                   <h4>{{ selected.pegawai_nama }}</h4>
                   <div class="card-header-action">
                       <button type="button" class="btn btn-primary">Tambahkan Sebagai Admin</button>
                   </div>
               </div>
               <div class="card-body">
                   <table class="table">
                       <tr>
                           <td>NIP</td>
                           <td>{{selected.pegawai_nip}} </td>
                       </tr>
                       <tr>
                           <td>SKPD</td>
                           <td>{{selected.skpd_nama}} </td>
                       </tr>
                   </table>
               </div>
           </div>
       </div>

       <div class="card">
           <div class="card-body">
               <data-tables :url="configDt.url" :columns="configDt.columns" selector="dt-select-pegawai"
                            ref="dt-select-pegawai"></data-tables>
           </div>
       </div>
   </div>
</template>

<script>
    import DataTables from "./DataTablesPost";
    export default {
        components:{
            DataTables
        },
        computed:{
          selected(){
              return this.$store.state.selected;
          }
        },
        data() {
            return {
                configDt: {
                    url: "/api/select-pegawai",
                    columns: [
                        {title: "Nama", data: "pegawai_nama"},
                        {title: "NIP", data: "pegawai_nip"},
                        {title: "Action", data: "action", class: "text-center"}
                    ]
                }
            };
        },
        mounted(){
            this.initActionDt();
        },
        methods:{
            initActionDt(){
                var me = this;
                $("#dt-select-pegawai").on('click','.btn-pilih', function (e) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    me.$store.commit( '_selected',$(this).data('value'));
                })
            }
        }
    }
</script>
