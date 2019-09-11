export const mixin = {
  computed: {
    isMobile() {
      return screen.width < 800 ? true : false;
    }
  },
  methods: {
    showModal: function (selector) {
      $(selector).modal("show");
      if(this.errors){
        this.errors = [];
      }
    },
    hideModal: function (selector) {
      $(selector).modal("hide");
      if(this.errors){
        this.errors = [];
      }
    },
    sendData(config) {
      this.errors = [];
      this.$noty.warning("loading...");

      this.$http(config)
        .then(res => {
          if (res.data.status) {
            this.errors = [];
            this.$noty.warning(res.data.message).on("onClose", () => {
              this.refresh();
              this.hideModal(".modal");
            });
          }
        })
        .catch(error => {
          var res = error.response;
          if (res && res.data) {
            this.$noty.error(res.data.message);
            this.errors = res.data.errors;
          } else {
            console.error(error);
          }
        });
    }
  },
};
