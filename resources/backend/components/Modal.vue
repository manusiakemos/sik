<template>
  <div class="modal fade" tabindex="-1" role="dialog" :id="id">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form action="#" method="post" v-on:submit.prevent="callback" novalidate>
          <div class="modal-header">
            <h5 class="modal-title">{{ title }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <slot></slot>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-dark" data-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
      props: ["title", "id", "callback"],
}
</script>

