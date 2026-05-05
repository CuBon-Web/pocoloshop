<template>
  <div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title" >Thuộc tính sản phẩm</h4>
              <router-link class="nav-link" :to="{name:'add_variant'}">
                <vs-button type="gradient" style="float:right;">Thêm mới</vs-button>
              </router-link>
              <vs-input icon="search" placeholder="Search" v-model="keyword" />
              <vs-table stripe :data="list" max-items="10" pagination>
                <template slot="thead">
                  <vs-th>Tên</vs-th>
                  <vs-th></vs-th>
                  <vs-th>Hành động</vs-th>
                </template>
                <template slot-scope="{data}">
                  <vs-tr :key="indextr" v-for="(tr, indextr) in data">
                    <vs-td :data="tr.name">{{tr.name}}</vs-td>
                    <vs-td>
                      <router-link :to="{name:'edit_variant',params:{id:tr.id}}"><vs-button color="primary" type="border">Quản lý biến thể</vs-button></router-link> &nbsp;
                    </vs-td>
                    <vs-td >
                      <vs-button vs-type="gradient" size="lagre" color="red" icon="delete_forever" @click="confirmDestroy(tr.id)"></vs-button>
                    </vs-td>
                  </vs-tr>
                </template>
              </vs-table>
            </div>
          </div>
        </div>
      </div>
  </div>
</template>


<script>
import Swal from "sweetalert2";
import { mapActions } from "vuex";
export default {
  data() {
    return {
      list:[],
      keyword:"",
      id_item:"",
    };
  },
  components: {},
  computed: {},
  watch: {},
  methods: {
    ...mapActions(['listVariant','loadings','deleteVariant']),
    listVariants(){
      this.listVariant({ keyword: this.keyword })
      .then(response => {
          this.loadings(false);
          this.list = response.data;
      }).catch(err => {
          this.loadings(false);
          this.list = err.data;
      });
    },
    confirmDestroy(id){
      this.id_item = id
      this.$vs.dialog({
        type:'confirm',
        color: 'danger',
        title: `Bạn có chắc chắn`,
        text: 'Xóa bản tin này',
        accept:this.destroy
      })
    },
    searchBlog() {
      if (this.timer) {
        clearTimeout(this.timer);
        this.timer = null;
      }
      this.timer = setTimeout(() => {
          this.listVariant({ keyword: this.keyword })
          .then(response => {
              this.list = response.data;
          }).catch(err => {
              this.list = err.data;
          });
      }, 800);
    },
    destroy(){
      this.deleteVariant({id:this.id_item}).then(response => {
        this.listVariants();
        this.loadings(false);
        this.$success('xóa thành công');
      });
    }
  },
  mounted() {
    this.listVariants();
  }
};
</script>