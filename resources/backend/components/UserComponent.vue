<template>
    <div class="card author-box bg-info shadow-info shadow-lg">
        <div class="card-body">
            <div class="author-box-left">
                <img alt="image" :src="value.user.avatar" class="rounded-circle author-box-picture" style="width: 80px;">
                <div class="clearfix"></div>
            </div>
            <div class="author-box-details">
                <div class="author-box-name">
                    {{value.data.bidan_nama}} ({{value.data.bidan_nik}})
                </div>
                <div class="author-box-job text-white text-uppercase">
                    {{value.desc}}
                </div>
                <div class="author-box-description">
                    <p>{{ value.data.bidan_pns ? 'NIP' : 'Nomor Bidan'}} {{value.nomor}} </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props : ['value']
    }
</script>
